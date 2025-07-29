<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalUpload;
use App\Models\MedicalImage;
use App\Models\User;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Collection;
class AssignmentController extends Controller
{
    /**
     * Display the “Assign Reader” form for a given batch_no.
     */
    public function showBatch(string $batch_no)
{
    // 1) Try hospital uploads first
    $upload = HospitalUpload::where('id', $batch_no)->first();

    if ($upload) {
        $readers = User::role('reader')->orderBy('name')->get();

        return view('admin.hospitals.assign', compact('upload','readers'));
    }

    // 2) Fallback to customer flow
    $exists = MedicalImage::where('batch_no', $batch_no)->exists();
    if (! $exists) {
        return redirect()->route('admin.images.index')
                         ->withErrors(['batch_no' => 'Invalid batch number.']);
    }

    $readers = User::role('reader')->orderBy('name')->get();
    return view('admin.images.assign', compact('batch_no','readers'));
}

    /**
     * Process the “Assign Reader” form (POST) for a given batch_no.
     */
    public function storeBatch(Request $request, string $batch_no)
{
    $request->validate([
        'reader_id' => 'required|exists:users,id',
        'deadline'  => 'required|date|after:now',
    ]);

    $readerId = $request->input('reader_id');
    $deadline = Carbon::parse($request->input('deadline'));

    // First, check if this is a hospital ZIP batch
    $upload = HospitalUpload::find($batch_no);
    if ($upload) {
        // Create a single Assignment for the entire ZIP batch
       Assignment::create([
    'hospital_upload_id' => $upload->id,
    'assigned_by'        => Auth::id(),
    'assigned_to'        => $readerId,
    'assigned_at'        => now(),
    'deadline'           => $deadline,
    'status'             => 'pending',
]);


        // Optionally update the upload’s status
        $upload->status = 'assigned';
        $upload->save();

        return redirect()->route('admin.images.index')
                         ->with('success', 'Hospital batch assigned successfully.');
    }

    // Otherwise treat it as a customer DICOM batch
    DB::transaction(function () use ($batch_no, $readerId, $deadline) {
        $images = MedicalImage::where('batch_no', $batch_no)->get();
        foreach ($images as $image) {
            Assignment::create([
                'image_id'    => $image->id,
                'assigned_by' => Auth::id(),
                'assigned_to' => $readerId,
                'assigned_at' => now(),
                'deadline'    => $deadline,
                'status'      => 'pending',
            ]);
            $image->status = 'assigned';
            $image->save();
        }
    });

    return redirect()->route('admin.images.index')
                     ->with('success', 'Customer batch assigned successfully.');
}
  public function indexAssignedList()
{
    // 1. Load all assignments with both relationships
    $all = Assignment::with([
            'image.uploader',
            'hospitalUpload.uploader',  // <-- load hospitalUpload relationship
            'assignedBy',
            'assignedTo',
        ])
        ->orderByDesc('created_at')
        ->get();

    // 2. Group by the appropriate batch identifier:
    $grouped = $all->groupBy(function (Assignment $a) {
        // if it's a customer‐DICOM assignment:
        if ($a->image) {
            return $a->image->batch_no;
        }
        // otherwise it's a hospital‐ZIP assignment:
        return $a->hospital_upload_id;
    })->map(fn(Collection $group) => $group->first())
      ->values();

    // 3. Pass to view
    return view('admin.assignments.index', [
        'assignments' => $grouped,
    ]);
}


    /**
     * Generate a ZIP of all DICOM files in $batch_no
     * and return it for download.
     */


// …

    public function downloadBatch(string $batch_no)
    {
        $batchesDir = storage_path('app/batches');
        $zipPath    = "{$batchesDir}/{$batch_no}.zip";

        if (! File::exists($zipPath)) {
            return redirect()->back()
                             ->withErrors(['download' => 'Original ZIP not found for batch: '.$batch_no]);
        }

        // Return it as a download; do NOT re-zip—just serve the file exactly.
        return response()->download($zipPath, "batch-{$batch_no}.zip");
    }


    public function download(Assignment $assignment)
{
    $filePath = storage_path('app/assignments/' . $assignment->image->filename);

    if (file_exists($filePath)) {
        return response()->download($filePath);
    }

    return abort(404, 'File not found.');
}

}
