<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalUpload;
use App\Models\MedicalImage;
use App\Models\Batch;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;

use Illuminate\Support\Collection;



class AssignmentController extends Controller
{


public function indexAssignedList()
{
    // Load all assignments with the relations we might need.
    // We eager-load image, batch, hospitalUpload and user relations so the view has everything.
    $all = Assignment::with([
            'image.uploader',
            'batch.uploader',
            'hospitalUpload.uploader',
            'assignedBy',
            'assignedTo',
            'report',
        ])
        ->orderByDesc('created_at')
        ->get();

    // Group assignments by the logical "batch identifier":
    // - prefer medical image's batch_no (legacy customer-per-image)
    // - else batch_id (new customer batch table)
    // - else hospital_upload_id (hospital ZIPs)
    $grouped = $all->groupBy(function ($assignment) {
        // images may be null (assignments created for batch/hospital uploads)
        if ($assignment->image && !empty($assignment->image->batch_no)) {
            return (string) $assignment->image->batch_no;
        }

        if (!empty($assignment->batch_id)) {
            return (string) $assignment->batch_id;
        }

        if (!empty($assignment->hospital_upload_id)) {
            return (string) $assignment->hospital_upload_id;
        }

        // Fallback so grouping key is unique
        return 'unknown_'.$assignment->id;
    });

    // From each group pick the first (represents that batch)
    $onePerBatch = $grouped->map(function (Collection $group) {
        return $group->first();
    })->values();

    // Pass to view (expects a collection called $assignments)
    return view('admin.assignments.index', [
        'assignments' => $onePerBatch,
    ]);
}


public function showBatch(string $batch_no)
{
    // 1) Hospital ZIPs (HospitalUpload uses id)
    $upload = HospitalUpload::find($batch_no);
    if ($upload) {
        $readers = User::role('reader')->orderBy('name')->get();
        $type = 'hospital';
        // We will use the unified view (admin.images.assign)
        return view('admin.images.assign', compact('upload', 'readers', 'type'));
    }

    // 2) Optional Batch table (if you use a batches table)
    if (class_exists(Batch::class)) {
        $batchModel = Batch::find($batch_no);
        if ($batchModel) {
            $readers = User::role('reader')->orderBy('name')->get();
            $type = 'batch';
            return view('admin.images.assign', compact('batchModel','readers','type'));
        }
    }

    // 3) Customer DICOM batches stored as medical_images.batch_no
    $exists = MedicalImage::where('batch_no', $batch_no)->exists();
    if ($exists) {
        $readers = User::role('reader')->orderBy('name')->get();
        $type = 'customer';
        return view('admin.images.assign', compact('batch_no','readers','type'));
    }

    // Not found -> log and redirect with message
    Log::warning('showBatch: batch not found', ['batch_no' => $batch_no]);
    return redirect()->route('admin.images.index')
                     ->withErrors(['batch_no' => 'Invalid batch number or no files found for this batch.']);
}


public function storeBatch(Request $request, string $batch_no)
{
    $request->validate([
        'reader_id' => 'required|exists:users,id',
        'deadline'  => 'required|date|after:now',
    ]);

    $readerId = $request->input('reader_id');
    $deadline = Carbon::parse($request->input('deadline'));

   DB::beginTransaction();

    // 1) Hospital ZIP flow
    $upload = HospitalUpload::find($batch_no);
    if ($upload) {
        Assignment::create([
            'hospital_upload_id' => $upload->id,
            'image_id'           => null,
            'batch_id'           => null,
            'assigned_by'        => Auth::id(),
            'assigned_to'        => $readerId,
            'assigned_at'        => now(),
            'deadline'           => $deadline,
            'status'             => 'pending',
        ]);

        $upload->status = 'assigned';
        $upload->save();

        DB::commit();
        return redirect()->route('admin.images.index')->with('success', 'Hospital batch assigned.');
    }

    // 2) Customer batch flow (Batch model)
    $batch =Batch::find($batch_no);
    if ($batch) {
        Assignment::create([
            'hospital_upload_id' => null,
            'image_id'           => null,
            'batch_id'           => $batch->id,   // <- use batch id here
            'assigned_by'        => Auth::id(),
            'assigned_to'        => $readerId,
            'assigned_at'        => now(),
            'deadline'           => $deadline,
            'status'             => 'pending',
        ]);

        // if you track status on Batch
        $batch->status = 'assigned';
        $batch->save();

        DB::commit();
        return redirect()->route('admin.images.index')->with('success', 'Customer batch assigned.');
    }

    // 3) Backwards-compat: if you still have per-image rows
    $images = MedicalImage::where('batch_no', $batch_no)->get();
    if ($images->isNotEmpty()) {
        $created = 0;
        foreach ($images as $image) {
            Assignment::create([
                'image_id'    => $image->id,
                'hospital_upload_id' => null,
                'batch_id'    => null,
                'assigned_by' => Auth::id(),
                'assigned_to' => $readerId,
                'assigned_at' => now(),
                'deadline'    => $deadline,
                'status'      => 'pending',
            ]);
            $image->status = 'assigned';
            $image->save();
            $created++;
        }
        DB::commit();
        return redirect()->route('admin.images.index')->with('success', "Assigned {$created} images.");
    }

    DB::rollBack();
    return redirect()->route('admin.images.index')->withErrors(['batch_no' => 'Batch not found.']);

}

}
