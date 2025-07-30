<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalImage;
use Illuminate\Support\Facades\DB;
use App\Models\Assignment;
class MedicalImageController extends Controller
{
   public function index()
{
    // 1) Get all batch_nos that have at least one assignment
    $assignedBatchNos = Assignment::join('medical_images', 'assignments.image_id', '=', 'medical_images.id')
        ->distinct()
        ->pluck('medical_images.batch_no');

    // 2) Query MedicalImage grouped by batch_no/uploader,
    //    but exclude any batch_no in the assigned list
    $batches = MedicalImage::select([
                'batch_no',
                'uploader_id',
                DB::raw('COUNT(*) as images_count'),
                DB::raw('MAX(created_at) as latest_upload'),
            ])
            ->whereNotIn('batch_no', $assignedBatchNos)
            ->groupBy('batch_no', 'uploader_id')
            ->with('uploader')            // eager‐load uploader relationship
            ->orderByDesc('latest_upload')
            ->get();

    return view('admin.images.index', compact('batches'));
}
}
