<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\HospitalUpload;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class UploaderDashboardController extends Controller
{
    protected function guard() {
        return Auth::guard('uploader');
    }

    /** GET /uploader/dashboard */
   public function index()
    {
        $uploader = Auth::guard('uploader')->user();

        // Fetch all “batch” uploads, not individual images:
        $batches = HospitalUpload::with(['fileType','assignments.report'])
                         ->where('uploader_id', $uploader->id)
                         ->orderByDesc('created_at')
                         ->get();

        // Pass $batches (not $images) into the view:
        return view('hospital.uploaders.dashboard', compact('batches'));
    }

    /** GET /uploader/uploads/create */
    public function create()
    {
        return view('hospital.uploaders.uploads.create');
    }

    /** POST /uploader/uploads */
public function store(Request $request)
{
    $data = $request->validate([
        'archive'          => 'required|file|mimes:zip|max:51200',
        'urgency'          => 'required|in:normal,urgent',
        'clinical_history' => 'nullable|string|max:2000',
        'file_type_id'     => 'required|exists:file_types,id',
    ]);

    $uploader = Auth::guard('uploader')->user();

    $batchNo = Str::uuid()->toString();
    $zip     = $request->file('archive');
    $zipName = $zip->getClientOriginalName();
    $zipPath = $zip->storeAs("hospital_uploads/{$batchNo}", $zipName, 'local');

    HospitalUpload::create([
        'id'               => $batchNo,
        'hospital_id'      => $uploader->hospital_id,
        'uploader_id'      => $uploader->id,
        'zip_path'         => $zipPath,
        'urgency'          => $data['urgency'],
        'clinical_history' => $data['clinical_history'],
        'file_type_id'     => $data['file_type_id'],
        'status'           => 'uploaded',
    ]);

    return redirect()->route('uploader.dashboard')
                     ->with('success','Batch uploaded successfully.');
}
    /** GET /uploader/uploads/{image} */
    public function show(MedicalImage $image)
    {
        $uploader = $this->guard()->user();
        if ($image->uploader_id !== $uploader->id) {
            abort(403);
        }

        // eager load any report relationship
        $image->load('report');

        return view('uploader.uploads.show', compact('image'));
    }
}
