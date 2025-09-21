<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\HospitalUpload;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;



namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use App\Models\HospitalUpload;
use App\Models\FileType;
use App\Models\HospitalProfile;


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
        if (! $uploader) {
            return back()->withErrors(['uploader' => 'Uploader not authenticated.']);
        }

        // Ensure uploader is linked to a hospital
        if (empty($uploader->hospital_id)) {
            return back()->withErrors(['hospital' => 'Uploader is not attached to a hospital profile.']);
        }

        $fileType = FileType::findOrFail($data['file_type_id']);

        // Start transaction
        DB::beginTransaction();
        try {
            // 1) prepare batch id and store ZIP on local disk
            $batchNo  = Str::uuid()->toString();
            $zip      = $request->file('archive');
            $filename = $zip->getClientOriginalName();

            // store under storage/app/hospital_uploads/{batch}/{originalName}
            $zipPath = $zip->storeAs("hospital_uploads/{$batchNo}", $filename, 'local'); // returns path like hospital_uploads/{batch}/{filename}

            $fullPath = Storage::disk('local')->path($zipPath);

            // 2) open ZIP and count files (non-directories). We don't extract.
            $zipObj = new ZipArchive;
            $res = $zipObj->open($fullPath);
            if ($res !== true) {
                // failed to open zip
                DB::rollBack();
                return back()->withErrors(['archive' => "Unable to open ZIP file (code: {$res})."]);
            }

            $fileCount = 0;
            for ($i = 0; $i < $zipObj->numFiles; $i++) {
                $stat = $zipObj->statIndex($i);
                $name = $stat['name'] ?? null;
                if (! $name) continue;

                // ignore directory entries (names ending with '/')
                if (substr($name, -1) === '/') continue;

                // Optionally: filter by extension (e.g. .dcm) or count all files.
                // Here we count all non-directory entries.
                $fileCount++;
            }
            $zipObj->close();

            // 3) compute amount based on selected file type price
            $amount = bcmul((string)$fileCount, (string)$fileType->price_per_file, 2); // string math to avoid float issues

            // 4) create the HospitalUpload row (store zip_path, file_count, quoted_price)
            $upload = HospitalUpload::create([
                'id'               => $batchNo,
                'hospital_id'      => $uploader->hospital_id,
                'uploader_id'      => $uploader->id,
                'zip_path'         => $zipPath,      // path relative to storage/app
                'file_count'       => $fileCount,
                'urgency'          => $data['urgency'],
                'clinical_history' => $data['clinical_history'],
                'file_type_id'     => $fileType->id,
                'quoted_price'     => $amount,
                'status'           => 'uploaded',
            ]);

            // 5) increment hospital profile billing_rate by amount
            $profile = HospitalProfile::where('id', $uploader->hospital_id)->first();
            if ($profile) {
                // Use decimal arithmetic or DB increment
                // Option A: increment column numerically
                $profile->increment('billing_rate', $amount);

                // Option B (alternative): if you want to store in a separate column,
                // use $profile->increment('billing_balance', $amount);
            } else {
                // If no profile found, rollback and error
                DB::rollBack();
                return back()->withErrors(['hospital' => 'Hospital profile not found for uploader.']);
            }

            DB::commit();

            return redirect()->route('uploader.dashboard')->with('success', 'Batch uploaded successfully. Files: '.$fileCount.' — Charge: '.number_format($amount,2).' birr');
        } catch (\Throwable $e) {
            DB::rollBack();
            logger()->error('Hospital upload failed: '.$e->getMessage(), ['exception' => $e]);
            return back()->withErrors(['upload' => 'Upload failed. Please try again.']);
        }
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
