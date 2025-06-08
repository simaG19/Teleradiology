<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalImage;
use Illuminate\Support\Facades\DB;
class MedicalImageController extends Controller
{
    public function index()
    {
        // 1. Group by batch_no and uploader_id, count how many images each batch has
        $batches = MedicalImage::select(
                'batch_no',
                'uploader_id',
                DB::raw('COUNT(*) as images_count'),
                DB::raw('MAX(created_at) as latest_upload') // for ordering if needed
            )
            ->groupBy('batch_no', 'uploader_id')
            ->with('uploader') // eager-load the uploader relationship
            ->orderByDesc('latest_upload')
            ->get();

        // 2. Pass the grouped results to the view
        return view('admin.images.index', compact('batches'));
    }
}
