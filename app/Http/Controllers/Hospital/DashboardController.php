<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalImage;
use Carbon\Carbon;

use App\Models\HospitalUpload;


class DashboardController extends Controller
{
    // app/Http/Controllers/Hospital/DashboardController.php

public function dashboard()
{
    $user    = Auth::user();
    $profile = $user->hospitalProfile;

    // Count uploader accounts
    $uploaderCount = $profile->uploaders()->count();

    // 1) Fetch all uploads (batches) for this hospital
    $uploads = HospitalUpload::with(['uploader','fileType','assignments.report'])
                ->where('hospital_id', $profile->id)
                ->orderByDesc('created_at')
                ->get();

    // (Optional) your existing usage & billing logic here...

    return view('hospital.dashboard', [
        'profile'       => $profile,
        'uploaderCount' => $uploaderCount,
        'uploads'       => $uploads,
        // 'bills'      => $bills, etc.
    ]);
}

}
