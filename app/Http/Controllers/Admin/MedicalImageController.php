<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Assignment;
use Illuminate\Support\Facades\DB;

class MedicalImageController extends Controller
{
    public function index()
    {
        // 1) Get all batch_nos that already have an assigned image
        $assignedBatchNos = Assignment::join('medical_images', 'assignments.image_id', '=', 'medical_images.id')
            ->distinct()
            ->pluck('medical_images.batch_no');

        // 2) Get only unconfirmed (unassigned) batches
        $batches = Batch::with('uploader')
            ->whereNotIn('batch_no', $assignedBatchNos)   // ✅ match by batch_no
            ->orderByDesc('created_at')
            ->get();

        return view('admin.images.index', compact('batches'));
    }
}
