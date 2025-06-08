<?php

namespace App\Http\Controllers;

use App\Models\MedicalImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MedicalImageController extends Controller
{
    public function create()
    {
        return view('uploads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'archive' => 'required|file|mimes:zip|max:51200', // 50 MB
        ]);

        $zipFile    = $request->file('archive');
        $original   = $zipFile->getClientOriginalName();
        $extension  = $zipFile->extension(); // should be “zip”
        $batchNo    = Str::uuid();
        $tempName   = "{$batchNo}.{$extension}";

        // 1. Store the uploaded ZIP in a temporary disk
        $zipPath = $zipFile->storeAs('temp', $tempName, 'dicom');
        // e.g. storage/app/dicom/temp/{batchNo}.zip

        // 2. Move it to a permanent “batches” directory
        $batchesDir = storage_path("app/batches");
        if (! File::exists($batchesDir)) {
            File::makeDirectory($batchesDir, 0755, true);
        }

        // From: storage/app/dicom/temp/{batchNo}.zip
        $from = storage_path("app/dicom/{$zipPath}");
        // To:   storage/app/batches/{batchNo}.zip
        $permanentZip = "{$batchesDir}/{$tempName}";
        File::move($from, $permanentZip);

        // 3. Extract the ZIP from its new location
        $zip = new \ZipArchive;
        if ($zip->open($permanentZip) === true) {
            $extractDir = storage_path("app/extracted/{$batchNo}");
            File::makeDirectory($extractDir, 0755, true);

            $zip->extractTo($extractDir);
            $zip->close();
        } else {
            return back()->withErrors(['archive' => 'Unable to open ZIP file.']);
        }

        // 4. Loop through extracted files for MedicalImage records
        $files = File::allFiles($extractDir);
        foreach ($files as $file) {
            $extensionLower = strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
            $isDicom = $extensionLower === 'dcm'
                || ($extensionLower === '' && File::mimeType($file->getRealPath()) === 'application/dicom');

            if (! $isDicom) {
                continue;
            }

            $dicomName = Str::uuid().'.dcm';
            Storage::disk('dicom')->putFileAs('', $file->getRealPath(), $dicomName);

            MedicalImage::create([
                'uploader_id'   => $request->user()->id,
                'filename'      => $dicomName,
                'original_name' => $file->getFilename(),
                'mime_type'     => 'application/dicom',
                'status'        => 'uploaded',
                'batch_no'      => $batchNo,
            ]);
        }

        // 5. (Optionally) you may keep the extracted folder for other workflows.
        //    We no longer delete $permanentZip or $extractDir here.

        return redirect()->route('uploads.create')
                         ->with('success', 'ZIP uploaded (and stored) successfully.');
    }
}
