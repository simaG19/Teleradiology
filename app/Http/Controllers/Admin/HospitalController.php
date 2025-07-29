<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;                // for route model binding on {user}
use App\Models\MedicalImage;
use Illuminate\Http\Request;

use App\Models\HospitalUsageLog;

use App\Models\HospitalProfile;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
 use App\Models\HospitalUpload;
 use Illuminate\Support\Facades\Auth;
class HospitalController extends Controller
{



public function allUploads()
{
    $hospital = Auth::user()->hospitalProfile;
    $uploads  = HospitalUpload::with(['hospital','uploader','fileType','assignments.report'])
                // ->where('hospital_id', $hospital->id)
                ->orderByDesc('created_at')
                ->get();

    return view('admin.hospitals.all', compact('uploads'));
}



    public function index()
    {
        $hospitals = HospitalProfile::with(['user', 'usageLogs', 'bills'])
            ->withCount('uploaders')
            ->get()
            ->map(function ($hospital) {
                $hospital->current_month_usage = $hospital->getCurrentMonthUsage();
                $hospital->current_month_bill = $hospital->bills()
                    ->where('bill_year', now()->year)
                    ->where('bill_month', now()->month)
                    ->first();
                return $hospital;
            });

        return view('admin.hospitals.index', compact('hospitals'));
    }

    public function create()
    {
        return view('admin.hospitals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hospital_name' => 'required|string|max:255',
            'hospital_code' => 'required|string|max:50|unique:hospital_profiles',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'monthly_file_limit' => 'required|integer|min:1',
            'uploader_account_limit' => 'required|integer|min:1',
            'monthly_rate' => 'required|numeric|min:0',
            'per_file_rate' => 'required|numeric|min:0',
            'billing_type' => 'required|in:monthly,per_file,both',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date|after:contract_start_date',
        ]);

        // Generate random password
        $password = Str::random(12);

        // Create user account
        $user = User::create([
            'name' => $request->contact_person,
            'email' => $request->email,
            'password' => Hash::make($password),
        ]);

        // Assign hospital role
        $user->assignRole('hospital');

        // Create hospital profile
        $hospital = HospitalProfile::create([
            'user_id' => $user->id,
            'hospital_name' => $request->hospital_name,
            'hospital_code' => $request->hospital_code,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'address' => $request->address,
            'monthly_file_limit' => $request->monthly_file_limit,
            'uploader_account_limit' => $request->uploader_account_limit,
            'monthly_rate' => $request->monthly_rate,
            'per_file_rate' => $request->per_file_rate,
            'billing_type' => $request->billing_type,
            'contract_start_date' => $request->contract_start_date,
            'contract_end_date' => $request->contract_end_date,
        ]);

        return redirect()->route('admin.hospitals.index')
            ->with('success', "Hospital created successfully! Login credentials - Email: {$request->email}, Password: {$password}");
    }

   public function show(User $user)
    {
        $profile = $user->hospitalProfile;
        return view('admin.hospitals.show', compact('user','profile'));
    }

  public function edit(User $user)
    {
        // Ensure profile exists
        // $profile = $user->hospitalProfile
        //          ?? $user->hospitalProfile()->create([
        //                 'monthly_file_limit'     => 0,
        //                 'uploader_account_limit' => 0,
        //                 'billing_rate'           => 0,
        //             ]);
 $profile = $user->hospitalProfile;
        return view('admin.hospitals.edit', compact('user','profile'));
    }

    public function update(Request $request, User $user)
    {
        $profile = $user->hospitalProfile
                 ?? $user->hospitalProfile()->create([
                        'monthly_file_limit'     => 0,
                        'uploader_account_limit' => 0,
                        'billing_rate'           => 0,
                    ]);

        // validate...
        $data = $request->validate([
            'name'                    => 'required|string|max:255',
            'email'                   => 'required|email|unique:users,email,'.$user->id,
            'monthly_file_limit'      => 'required|integer|min:0',
            'uploader_account_limit'  => 'required|integer|min:0',
            'billing_rate'            => 'required|numeric|min:0',
        ]);

        // update user
        $user->update([
          'name'  => $data['name'],
          'email' => $data['email'],
        ]);

        // update profile
       $profile->update([
  'monthly_file_limit'      => $data['monthly_file_limit'],
  'uploader_account_limit'  => $data['uploader_account_limit'],
  'billing_rate'            => $data['billing_rate'],
  'is_active'               => $request->boolean('is_active'),
]);


        return redirect()->route('admin.hospitals.edit', $user)
                         ->with('success','Hospital updated.');
    }





    public function destroy(HospitalProfile $hospital)
    {
        $hospital->user->delete(); // This will cascade delete the hospital profile

        return redirect()->route('admin.hospitals.index')
            ->with('success', 'Hospital deleted successfully!');
    }


// In HospitalController



   public function activate(HospitalProfile $hospital)
    {
        \Log::info("Activating hospital ID: {$hospital->id}");
        $hospital->update(['is_active' => true]);
        return back()->with('success', 'Hospital activated.');
    }

    public function deactivate(HospitalProfile $hospital)
    {
        $hospital->update(['is_active' => false]);
        return back()->with('success', 'Hospital deactivated.');
    }






public function billingByUser(User $user)
{
    // If the User has no profile yet, create a default one
    $profile = $user->hospitalProfile
               ?? $user->hospitalProfile()->create([
                      'monthly_file_limit'      => 0,
                      'uploader_account_limit'  => 0,
                      'billing_rate'            => 0,
                  ]);

    $rate  = $profile->billing_rate;
    $start = now()->startOfMonth();
    $end   = now()->endOfMonth();

    $uploads = MedicalImage::where('uploader_id', $user->id)
        ->whereBetween('created_at', [$start, $end])
        ->orderBy('created_at')
        ->get(['original_name', 'created_at']);

    $count = $uploads->count();
    $bill  = $count * $rate;

    return view('admin.hospitals.billing', compact(
        'user','profile','uploads','count','bill','start','end'
    ));
}



// public function billingByUser(User $user)
// {
//     $profile = $user->hospitalProfile;   // get the profile row
//     $rate    = $profile->billing_rate;
//     $start   = now()->startOfMonth();
//     $end     = now()->endOfMonth();

//     $uploads = MedicalImage::where('uploader_id', $user->id)
//         ->whereBetween('created_at', [$start, $end])
//         ->orderBy('created_at')
//         ->get(['original_name','created_at']);

//     $count = $uploads->count();
//     $bill  = $count * $rate;

//     return view('admin.hospitals.billing', compact(
//         'user','profile','uploads','count','bill','start','end'
//     ));
// }


public function billing(HospitalProfile $hospital)
{
    $profile = $hospital;
    $user    = $hospital->user;

    $rate = $profile->billing_rate;
    $start = now()->startOfMonth();
    $end   = now()->endOfMonth();

    $uploads = MedicalImage::where('uploader_id', $user->id)
        ->whereBetween('created_at', [$start, $end])
        ->orderBy('created_at')
        ->get(['original_name','created_at']);

    $count = $uploads->count();
    $bill  = $count * $rate;

    return view('admin.hospitals.billing', compact(
        'user','profile','uploads','count','bill','start','end'
    ));
}

    public function generateBill(HospitalProfile $hospital, Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'month' => 'required|integer|min:1|max:12',
        ]);

        $year = $request->year;
        $month = $request->month;

        // Check if bill already exists
        $existingBill = HospitalBill::where('hospital_id', $hospital->id)
            ->where('bill_year', $year)
            ->where('bill_month', $month)
            ->first();

        if ($existingBill) {
            return back()->withErrors(['error' => 'Bill for this period already exists.']);
        }

        // Calculate usage for the month
        $monthlyUsage = HospitalUsageLog::where('hospital_id', $hospital->id)
            ->whereYear('upload_date', $year)
            ->whereMonth('upload_date', $month)
            ->sum('file_count');

        // Calculate fees
        $monthlyFee = 0;
        $perFileFee = 0;

        if (in_array($hospital->billing_type, ['monthly', 'both'])) {
            $monthlyFee = $hospital->monthly_rate;
        }

        if (in_array($hospital->billing_type, ['per_file', 'both'])) {
            $perFileFee = $monthlyUsage * $hospital->per_file_rate;
        }

        $totalAmount = $monthlyFee + $perFileFee;

        // Create bill
        HospitalBill::create([
            'hospital_id' => $hospital->id,
            'bill_year' => $year,
            'bill_month' => $month,
            'files_uploaded' => $monthlyUsage,
            'monthly_fee' => $monthlyFee,
            'per_file_fee' => $perFileFee,
            'total_amount' => $totalAmount,
            'due_date' => now()->addDays(30),
        ]);

        return back()->with('success', 'Bill generated successfully!');
    }
}
