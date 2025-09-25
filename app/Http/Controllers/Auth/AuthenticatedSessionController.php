<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
//  use Illuminate\Support\Facades\Auth;

public function store(LoginRequest $request)
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();

    // 1️⃣ Admin & Super‑Admin
    if ($user->hasAnyRole(['admin','super-admin'])) {
        $intended = route('admin.images.index');
    }
    // 2️⃣ Reader
    elseif ($user->hasRole('reader')) {
        $intended = route('reader.assignments.index');
    }
    // 3️⃣ Hospital
    elseif ($user->hasRole('hospital')) {
        $intended = route('hospital.dashboard');
    }
    // 4️⃣ Customer (normal)
    elseif ($user->hasRole('customer')) {
        $intended = route('uploads.create');
    }
    // Fallback
    else {
        $intended = '/';
    }

    return redirect()->intended($intended);
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
