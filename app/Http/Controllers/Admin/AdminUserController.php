<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Show a table of all “Clients” (role = customer).
     */
    public function clients()
    {
        // Fetch all users with role “customer”
        $clients = User::role('customer')
                       ->orderBy('name')
                       ->get(['id','name','email']);

        return view('admin.users.clients', compact('clients'));
    }

    /**
     * Show a table of all “Hospitals” (role = hospital).
     */
    public function hospitals()
    {
        // Fetch all users with role “hospital”
        // $hospitals = User::role('hospital')
        //                  ->orderBy('name')
        //                  ->get(['id','name','email']);
         $hospitals = User::role('hospital')->get();

        return view('admin.users.hospitals', compact('hospitals'));
    }

    public function createHospital()
{
    return view('admin.users.create-hospital');
}

// Validate and store a new hospital user
public function storeHospital(Request $request)
{
    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'monthly_file_limit'    => 'integer|min:0',
        'uploader_account_limit'=> 'integer|min:0',
        'billing_rate'          => 'numeric|min:0',


    ]);

    $user = User::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => bcrypt($data['password']),
    ]);
    $user->hospitalProfile()->create([
    'monthly_file_limit'     => 10000000,
    'uploader_account_limit' =>100,
]);

    $user->assignRole('hospital');

    return redirect()->route('admin.users.hospitals')
                     ->with('success', 'Hospital user created successfully.');
}

    /**
     * Show a table of all “Readers” (role = reader), with counts:
     *  - assigned_count
     *  - reported_count (status = 'completed')
     *  - unread_count   (status = 'unread')
     */
    public function readers()
    {
        // We assume an Assignment model with a belongsTo(User, 'assigned_to') relationship:
        // and that Assignment has a “status” column: 'unread', 'completed', etc.

        $readers = User::role('reader')
            ->withCount([
                // total assignments
                'assignments as assigned_count',

                // assignments where status = 'completed'
                'assignments as reported_count' => function($q) {
                    $q->where('status', 'completed');
                },

                // assignments where status = 'unread'
                'assignments as unread_count' => function($q) {
                    $q->where('status', 'unread');
                },
            ])
            ->orderBy('name')
            ->get(['id','name','email']);

        return view('admin.users.readers', compact('readers'));
    }


    /**
 * Show the “Create Reader” form.
 */
public function createReader()
{
    return view('admin.users.create-reader');
}

/**
 * Validate and store a new reader account.
 */
public function storeReader(Request $request)
{
    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => bcrypt($data['password']),
    ]);

    $user->assignRole('reader');

    return redirect()->route('admin.users.readers')
                     ->with('success', 'Reader created successfully.');
}

}
