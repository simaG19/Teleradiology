<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Batch;


use App\Models\Assignment;
use App\Models\Report;

use Illuminate\Support\Facades\DB;

use App\Models\FileType;
class MedicalImageController extends Controller
{

public function index()
{
    // 1) Get all batches for the current uploader and eager load fileType
    $batches = Batch::with('fileType')
                    ->where('uploader_id', Auth::id())
                    ->orderByDesc('created_at')
                    ->get();

    if ($batches->isEmpty()) {
        return view('uploads.index', compact('batches'))->with('reportsMap', collect());
    }

    // 2) Build a map of batch_id => first Report (joined via assignments)
    $batchIds = $batches->pluck('id')->toArray();

    // Join reports -> assignments so we can know the batch_id for each report
    $reportsQuery = Report::select('reports.*', 'assignments.batch_id')
        ->join('assignments', 'reports.assignment_id', '=', 'assignments.id')
        ->whereIn('assignments.batch_id', $batchIds)
        ->orderBy('reports.created_at', 'desc');

    // If you also have reports attached to hospital_uploads (rare for uploader batches),
    // you can include them similarly. For uploader batches above we use batch_id.

    $reports = $reportsQuery->get();

    // Group by batch_id and keep the newest report per batch
    $reportsMap = $reports->groupBy('batch_id')->map(function ($group) {
        return $group->first(); // latest report for that batch
    });

    // Pass both batches and the map (collection keyed by batch id)
    return view('uploads.index', compact('batches', 'reportsMap'));
}

    public function create()
    {
        return view('uploads.create');
    }

 // use statements at top of controller file



public function store(Request $request)
{
    $request->validate([
        'archive'          => 'required|file|mimes:zip|max:51200',
        'urgency'          => 'required|in:normal,urgent',
        'clinical_history' => 'nullable|string|max:2000',
        'file_type_id'     => 'nullable|exists:file_types,id',
    ]);

    $zipFile = $request->file('archive');
    $batchNo = (string) Str::uuid();
    $originalName = $zipFile->getClientOriginalName();
    $disk = 'local'; // storage/app

    // ensure batches dir exists
    if (! Storage::disk($disk)->exists('batches')) {
        Storage::disk($disk)->makeDirectory('batches');
    }

    // store zip as storage/app/batches/{batchNo}.zip
    $zipFilename = $batchNo . '.zip';
    $storedPath = $zipFile->storeAs('batches', $zipFilename, $disk);
    // $storedPath will be "batches/{batchNo}.zip"

    // create Batch record and save archive_path
    $batch = Batch::create([
        'id'               => $batchNo,
        'uploader_id'      => $request->user()->id,
        'urgency'          => $request->input('urgency'),
        'clinical_history' => $request->input('clinical_history'),
        'file_type_id'     => $request->input('file_type_id') ?? null,
        'archive_path'     => $storedPath,
        'confirmed'        => false,
    ]);

    // If you still need to extract individual DICOMs to MedicalImage,
    // do it AFTER creating the Batch. Otherwise skip extraction as you requested.

    return redirect()->route('uploads.index')
                     ->with('success', 'ZIP uploaded successfully. Batch: '.$batchNo);
}




public function showPaymentForm($batchId)
{
    $batch = Batch::with(['fileType','images'])
                  ->where('id', $batchId)
                  ->where('uploader_id', Auth::id())
                  ->firstOrFail();

    if (is_null($batch->quoted_price)) {
        return redirect()->route('uploads.index')
                         ->withErrors(['pay'=>'Price not set yet.']);
    }

    // Now $batch->fileType and $batch->images are available
    return view('uploads.pay', compact('batch'));
}
}
