<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AssignmentController extends Controller
{
    public function index()
    {
        // Join with medical_images to group by batch_no
        $batches = Assignment::join('medical_images', 'assignments.image_id', '=', 'medical_images.id')
            ->where('assignments.assigned_to', Auth::id())
            ->select(
                'medical_images.batch_no',
                'assignments.status',
                'assignments.assigned_at',
                'assignments.deadline'
            )
            ->groupBy('medical_images.batch_no', 'assignments.status', 'assignments.assigned_at', 'assignments.deadline')
            ->orderByDesc('assignments.assigned_at')
            ->get();

        return view('reader.assignments.index', compact('batches'));
    }

    public function downloadBatch($batch_no)
    {
        $path = storage_path("app/batches/{$batch_no}.zip");
        if (! File::exists($path)) {
            return back()->withErrors(['download' => 'ZIP not found.']);
        }
        return response()->download($path);
    }

    public function createReport($batch_no)
    {
        // Verify assignment exists via join
        $exists = Assignment::join('medical_images', 'assignments.image_id', '=', 'medical_images.id')
            ->where('medical_images.batch_no', $batch_no)
            ->where('assignments.assigned_to', Auth::id())
            ->exists();

        if (! $exists) {
            return redirect()->route('reader.assignments.index')
                             ->withErrors(['batch_no' => 'Invalid batch number.']);
        }

        return view('reader.assignments.report-create', compact('batch_no'));
    }

    public function storeReport(Request $request, $batch_no)
    {
        $request->validate([
            'report_text' => 'required|string',
            'report_pdf'  => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $report = Report::create([
            'batch_no'    => $batch_no,
            'created_by'  => Auth::id(),
            'report_text' => $request->input('report_text'),
            'status'      => 'completed',
        ]);

        if ($request->hasFile('report_pdf')) {
            $stored = $request->file('report_pdf')
                              ->storeAs("reports/{$batch_no}", 'report.pdf', 'local');
            $report->pdf_path = $stored;
            $report->save();
        }

        // Update status via join
        $ids = Assignment::join('medical_images', 'assignments.image_id', '=', 'medical_images.id')
            ->where('medical_images.batch_no', $batch_no)
            ->where('assignments.assigned_to', Auth::id())
            ->pluck('assignments.id');

        Assignment::whereIn('id', $ids)->update(['status' => 'completed']);

        return redirect()->route('reader.assignments.index')
                         ->with('success', 'Report submitted successfully.');
    }
}
