<?php
namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Assignment;
use App\Models\HospitalUpload;
use App\Models\Batch;
use App\Models\MedicalImage;
use App\Models\Report;
use Illuminate\Support\Collection;


use Illuminate\Support\Facades\Log;





class AssignmentController extends Controller
{
    /**
     * Show assigned batches (grouped).
     */

public function index()
{
    $readerId = Auth::id();

    // load all assignments for this reader with eager relations
    $all = Assignment::with(['image', 'hospitalUpload'])
        ->where('assigned_to', $readerId)
        ->orderByDesc('assigned_at')
        ->get();

    // Group assignments into "batches" (key = hospital_upload_id or image.batch_no)
    $grouped = $all->groupBy(function (Assignment $a) {
        if ($a->hospital_upload_id) {
            return 'hospital:'.$a->hospital_upload_id;
        }
        // guard for null image
        return 'batch:'.optional($a->image)->batch_no;
    });

    // Map to items for view
    $items = $grouped->map(function (Collection $group, $key) {
        // key like "hospital:UUID" or "batch:UUID"
        [$type, $id] = explode(':', $key, 2);

        $first = $group->first();

        // compute display fields
        return (object)[
            'type' => $type === 'hospital' ? 'hospital' : 'batch',
            'batch_id' => $id,                    // identifier to pass to routes
            'assigned_at' => $first->assigned_at ?? $first->created_at,
            'deadline' => $first->deadline,
            'status' => $first->status,
            'assignments_count' => $group->count(),
            // optionally include uploader/email or sample image
            'uploader_email' => optional($first->image)->uploader->email
                                ?? optional($first->hospitalUpload)->uploader->email
                                ?? null,
        ];
    })->values();

    return view('reader.assignments.index', [
        'items' => $items,
    ]);
}

    /**
     * Download ZIP for a given batch_no (customer batch id or hospital upload id).
     * Marks relevant assignments (for this reader) as in_progress before serving the zip.
     */
    public function downloadBatch(string $batch_no)
    {
        $readerId = Auth::id();

        // 1) Try hospital upload first
        $upload = HospitalUpload::find($batch_no);
        if ($upload) {
            // mark this reader's assignments for this hospital_upload as in_progress
            Assignment::where('hospital_upload_id', $upload->id)
                ->where('assigned_to', $readerId)
                ->update(['status' => 'in_progress']);

            // path stored on row (zip_path) or fallback to storage/app/hospital_uploads/{id}/...
            $zipPath = $upload->zip_path
                     ? Storage::disk('local')->path($upload->zip_path)
                     : storage_path("app/hospital_uploads/{$upload->id}.zip");

            if (! File::exists($zipPath)) {
                return back()->withErrors(['download' => 'ZIP file not found for hospital upload.']);
            }

            return response()->download($zipPath, "hospital-{$upload->id}.zip");
        }

        // 2) Otherwise handle customer batch (Batch model)
        $batch = Batch::find($batch_no);
        if ($batch) {
            // mark assignments (join via medical_images)
            $assignmentIds = Assignment::join('medical_images', 'assignments.image_id', '=', 'medical_images.id')
                ->where('medical_images.batch_no', $batch_no)
                ->where('assignments.assigned_to', $readerId)
                ->pluck('assignments.id');

            if ($assignmentIds->isNotEmpty()) {
                Assignment::whereIn('id', $assignmentIds)->update(['status' => 'in_progress']);
            }

            // Prefer archive_path if present, otherwise fallback to storage/app/batches/{id}.zip
            $zipPath = null;
            if (! empty($batch->archive_path)) {
                $zipFull = Storage::disk('local')->path($batch->archive_path);
                if (File::exists($zipFull)) $zipPath = $zipFull;
            }
            if (! $zipPath) {
                $candidate = storage_path("app/batches/{$batch->id}.zip");
                if (File::exists($candidate)) $zipPath = $candidate;
            }

            if (! $zipPath) {
                return back()->withErrors(['download' => 'ZIP file for this batch not found.']);
            }

            return response()->download($zipPath, "batch-{$batch->id}.zip");
        }

        // Not found
        return back()->withErrors(['download' => 'Batch not found.']);
    }




// use statements at top of controller

public function createReport(string $batch_no)
{
    $readerId = Auth::id();

    // 1) Is this a hospital upload?
    $upload = HospitalUpload::find($batch_no);
    if ($upload) {
        $exists = Assignment::where('hospital_upload_id', $upload->id)
            ->where('assigned_to', $readerId)
            ->exists();

        if (! $exists) {
            // Log helpful debug info and show a clear error instead of silent redirect
            dd('not assigned', $batch_no, $readerId);

            return redirect()->route('reader.assignments.index')
                ->withErrors(['batch_no' => 'You are not assigned to this hospital batch.']);
        }

        // load any additional data for the view
        $fileType = $upload->fileType;
        return view('reader.assignments.report-create', [
            'batch_no' => $batch_no,
            'type'     => 'hospital',
            'upload'   => $upload,
            'fileType' => $fileType,
        ]);
    }

    // 2) Otherwise treat as customer batch (images table)
    // Find assignments by joining to medical_images (assignment rows reference image_id)
    $exists = Assignment::join('medical_images', 'assignments.image_id', '=', 'medical_images.id')
        ->where('medical_images.batch_no', $batch_no)
        ->where('assignments.assigned_to', $readerId)
        ->exists();

    if (! $exists) {
         dd('not assigned', $batch_no, $readerId);

        return redirect()->route('reader.assignments.index')
            ->withErrors(['batch_no' => 'Invalid batch number or not assigned to you.']);
    }

    // Pass the list of images for the batch (reader will need them)
    $images = MedicalImage::where('batch_no', $batch_no)
                ->orderBy('created_at')
                ->get(['id','original_name','filename','created_at']);

    return view('reader.assignments.report-create', [
        'batch_no' => $batch_no,
        'type'     => 'batch',
        'images'   => $images,
    ]);
}


public function storeReport(Request $request, $batch_no)
{
    $request->validate([
        'report_text' => 'required|string',
        'report_pdf'  => 'nullable|file|mimes:pdf|max:20480',
    ]);

    $readerId = Auth::id();

    // Find assignment ids for this reader & batch (covers customer-image batches)
    $assignmentIds = Assignment::join('medical_images','assignments.image_id','=','medical_images.id')
        ->where('medical_images.batch_no', $batch_no)
        ->where('assignments.assigned_to', $readerId)
        ->pluck('assignments.id')
        ->toArray();

    // Also support hospital_upload assignments
    if (empty($assignmentIds)) {
        $hospitalUpload = \App\Models\HospitalUpload::find($batch_no);
        if ($hospitalUpload) {
            $assignmentIds = Assignment::where('hospital_upload_id', $hospitalUpload->id)
                ->where('assigned_to', $readerId)
                ->pluck('id')
                ->toArray();
        }
    }

    if (empty($assignmentIds)) {
        Log::warning('storeReport: no assignments found for batch', [
            'batch_no' => $batch_no,
            'reader_id' => $readerId,
        ]);
        return redirect()->route('reader.assignments.index')
                         ->withErrors(['report' => 'No assignments found for this batch (or you are not assigned).']);
    }

    foreach ($assignmentIds as $assignId) {
        $report = \App\Models\Report::create([
            'assignment_id' => $assignId,
            'notes' => $request->input('report_text'),
        ]);

        if ($request->hasFile('report_pdf')) {
            $stored = $request->file('report_pdf')
                            ->storeAs("reports/{$batch_no}", "report_{$assignId}.pdf", 'local');
            $report->pdf_path = $stored;
            $report->save();
        }
    }

    // Mark assignments completed
    Assignment::whereIn('id', $assignmentIds)->update(['status' => 'done']);

    return redirect()->route('reader.assignments.index')->with('success','Report submitted successfully.');
}



}
