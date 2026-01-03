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

 use App\Models\Batch;
use App\Models\FileType;


use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HospitalController extends Controller
{



public function allUploads()
{
    $hospital = Auth::user()->hospitalProfile;
    $uploads  = HospitalUpload::with(['hospital', 'hospital.user','uploader','fileType','assignments.report'])
                // ->where('hospital_id', $hospital->id)
                ->orderByDesc('created_at')
                ->get();
// $first = HospitalUpload::with('hospital')->first();
// dd($first->toArray(), $first->hospital);

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
            // 'monthly_file_limit' => 'required|integer|min:1',
            'uploader_account_limit' => 'required|integer|min:1',
            // 'monthly_rate' => 'required|numeric|min:0',
            // 'per_file_rate' => 'required|numeric|min:0',
            // 'billing_type' => 'required|in:monthly,per_file,both',
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
            // 'monthly_file_limit' => $request->monthly_file_limit,
            'uploader_account_limit' => $request->uploader_account_limit,
            // 'monthly_rate' => $request->monthly_rate,
            // 'per_file_rate' => $request->per_file_rate,
            // 'billing_type' => $request->billing_type,
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





// App\Http/Controllers/Admin/HospitalController.php (billingByUser)



public function billingByUser(User $user)
{
    // ensure profile exists
    $profile = $user->hospitalProfile
               ?? $user->hospitalProfile()->create([
                      'monthly_file_limit'      => 0,
                      'uploader_account_limit'  => 0,
                      'billing_rate'            => 0,
                  ]);

    $rate  = (float) $profile->billing_rate;
    $start = now()->startOfMonth();
    $end   = now()->endOfMonth();

    // Get uploader ids for the hospital (fallback to the user id if none)
    $uploaderIds = $profile->uploaders()->pluck('id')->toArray();
    if (empty($uploaderIds)) {
        $uploaderIds = [$user->id];
    }

    // --- Customer batches (grouped by batch_no) ---
    $customerBatches = MedicalImage::select(
            'batch_no',
            DB::raw('COUNT(*) as files_count'),
            DB::raw('MIN(created_at) as first_uploaded_at')
        )
        ->whereIn('uploader_id', $uploaderIds)
        ->whereBetween('created_at', [$start, $end])
        ->groupBy('batch_no')
        ->orderBy('first_uploaded_at')
        ->get();

    // fetch corresponding Batch records (to read file_type_id / quoted_price)
    $batchIds = $customerBatches->pluck('batch_no')->unique()->values()->all();
    $batchRecords = Batch::with('fileType')
                    ->whereIn('id', $batchIds)
                    ->get()
                    ->keyBy('id');

    // Build lines for customer batches using file type name
    $customerLines = $customerBatches->map(function ($row) use ($rate, $batchRecords) {
        $batchId = (string) $row->batch_no;
        $batch = $batchRecords->get($batchId);

        // prefer batch quoted_price if present, otherwise use billing_rate * files_count
        $price = null;
        if ($batch && !is_null($batch->quoted_price)) {
            $price = (float) $batch->quoted_price;
        } else {
            $price = $row->files_count * $rate;
        }

        // file type name (attempt to read from related Batch->fileType)
        $fileTypeName = null;
        $fileTypeAnatomy = null;
        if ($batch && $batch->fileType) {
            $fileTypeName    = $batch->fileType->name;
            $fileTypeAnatomy = $batch->fileType->anatomy ?? null;
        }

        return (object)[
            'source'        => 'customer',
            'batch_id'      => $batchId,
            'date'          => $row->first_uploaded_at,
            'files_count'   => (int) $row->files_count,     // keep available if you need later
            'price'         => (float) $price,
            'file_type_name'=> $fileTypeName,
            'file_type_anatomy' => $fileTypeAnatomy,
        ];
    });

    // --- Hospital uploads (ZIPs) ---
    $hospitalUploads = HospitalUpload::where('hospital_id', $profile->id)
                        ->whereBetween('created_at', [$start, $end])
                        ->orderBy('created_at')
                        ->get();

    $hospitalLines = $hospitalUploads->map(function ($h) use ($rate) {
        $files = (int) ($h->file_count ?? 0);
        $price = !is_null($h->quoted_price) ? (float)$h->quoted_price : ($files * $rate);

        $fileTypeName = optional($h->fileType)->name;
        $fileTypeAnatomy = optional($h->fileType)->anatomy ?? null;

        return (object)[
            'source'        => 'hospital',
            'batch_id'      => $h->id,
            'date'          => $h->created_at,
            'files_count'   => $files,
            'price'         => (float) $price,
            'file_type_name'=> $fileTypeName,
            'file_type_anatomy' => $fileTypeAnatomy,
        ];
    });

    // combine, sort and totals
    $lines = $customerLines->concat($hospitalLines)
             ->sortByDesc('date')
             ->values();

    // count here we switch to count of batches (not number of files)
    $count = $lines->count();
    $bill  = $lines->sum('price');

    return view('admin.hospitals.billing', compact(
        'user','profile','lines','count','bill','start','end'
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
