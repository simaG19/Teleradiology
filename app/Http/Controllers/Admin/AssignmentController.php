<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        // 1. Ensure this batch actually exists (at least one image)
        $exists = MedicalImage::where('batch_no', $batch_no)->exists();
        if (! $exists) {
            return redirect()->route('admin.images.index')
                             ->withErrors(['batch_no' => 'Invalid batch number.']);
        }

        // 2. Fetch all readers (users with role “reader”)
        //    (adjust if you have a custom way to fetch “reader” role)
        $readers = User::role('reader')->orderBy('name')->get();

        // 3. Pass batch_no and readers to the view
        return view('admin.images.assign', compact('batch_no', 'readers'));
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

        // Wrap in a transaction so we create assignments atomically
        DB::transaction(function () use ($batch_no, $readerId, $deadline) {
            // 1. Fetch all DICOMs for this batch
            $images = MedicalImage::where('batch_no', $batch_no)->get();

            foreach ($images as $image) {
                // 2. Create an Assignment row for each image
                Assignment::create([
                    'image_id'    => $image->id,
                    'assigned_by' => Auth::id(),
                    'assigned_to' => $readerId,
                    'assigned_at' => now(),
                    'deadline'    => $deadline,      // <-- you’ll need a “deadline” column
                    'status'      => 'pending',
                ]);

                // 3. Update each MedicalImage’s status to “assigned”
                $image->status = 'assigned';
                $image->save();
            }
        });

        return redirect()->route('admin.images.index')
                         ->with('success', 'Batch assigned to reader successfully.');
    }

     public function indexAssignedList()
    {
        // 1. Load all assignments with the relationships we need
        $all = Assignment::with([
            'image.uploader',
            'assignedBy',
            'assignedTo',
        ])
        ->orderByDesc('created_at')
        ->get();

        // 2. Group by batch_no, then take the first Assignment in each group
        $grouped = $all
            ->groupBy(fn($a) => $a->image->batch_no)
            ->map(fn(Collection $group) => $group->first())
            ->values();

        // 3. Pass the “one-per-batch” collection to the view
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
