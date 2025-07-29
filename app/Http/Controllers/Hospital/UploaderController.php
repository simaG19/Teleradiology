<?php
namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\UploaderAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\HospitalUpload;

use App\Models\MedicalImage;

class UploaderController extends Controller
{
  public function index()
{
    $uploaders = Auth::user()
                     ->hospitalProfile
                     ->uploaders()
                     ->get();

    return view('hospital.uploaders.index', compact('uploaders'));
}

public function create()
{
    return view('hospital.uploaders.create');
}

public function store(Request $request)
{
    $profile = $request->user()->hospitalProfile;

    // 1️⃣ Check the uploader limit
    if ($profile->uploader_account_limit > 0) {
        $currentCount = $profile->uploaders()->count();
        if ($currentCount >= $profile->uploader_account_limit) {
            return back()
                ->withInput()
                ->withErrors([
                    'limit' => "You have reached your uploader account limit ({$currentCount}/{$profile->uploader_account_limit})."
                ]);
        }
    }

    // 2️⃣ Validate and create
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:uploader_accounts,email',
      'password' => 'required|confirmed|min:8',
    ]);

    $request->user()
            ->hospitalProfile
            ->uploaders()
            ->create([
               'name'     => $data['name'],
               'email'    => $data['email'],
               'password' => Hash::make($data['password']),
            ]);

    return redirect()->route('hospital.uploaders.index')
                     ->with('success','Uploader created.');
}

// …

public function show(UploaderAccount $uploader)
{
    // 1) Get all batches this uploader has sent
    $batches = HospitalUpload::with(['fileType','assignments.report'])
                ->where('uploader_id', $uploader->id)
                ->orderByDesc('created_at')
                ->get();

    // 2) Pass uploader + batches
    return view('hospital.uploaders.show', compact('uploader','batches'));
}

 public function edit(UploaderAccount $uploader)
    {
        // Ensure this uploader belongs to the current hospital
        if ($uploader->hospital_id !== Auth::user()->hospitalProfile->id) {
            abort(403);
        }

        return view('hospital.uploaders.edit', compact('uploader'));
    }

    /**
     * Handle the form submission to update an uploader.
     */
    public function update(Request $request, UploaderAccount $uploader)
    {
        if ($uploader->hospital_id !== Auth::user()->hospitalProfile->id) {
            abort(403);
        }

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => "required|email|unique:uploader_accounts,email,{$uploader->id}",
            'password' => 'nullable|confirmed|min:8',
        ]);

        $uploader->name  = $data['name'];
        $uploader->email = $data['email'];
        if (!empty($data['password'])) {
            $uploader->password = Hash::make($data['password']);
        }
        $uploader->save();

        return redirect()
            ->route('hospital.uploaders.index')
            ->with('success', 'Uploader updated successfully.');
    }

    /**
     * Delete an uploader account.
     */
    public function destroy(UploaderAccount $uploader)
    {
        if ($uploader->hospital_id !== Auth::user()->hospitalProfile->id) {
            abort(403);
        }

        $uploader->delete();

        return redirect()
            ->route('hospital.uploaders.index')
            ->with('success', 'Uploader deleted.');
    }


}
