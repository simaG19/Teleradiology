<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploaderAuthController extends Controller
{
    protected $guard = 'uploader';

    public function showLoginForm()
    {
        return view('hospital.uploaders.login');
    }

   public function login(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    if (Auth::guard($this->guard)->attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        // Instead of route('uploads.create'), send them to uploader.dashboard:
        return redirect()->intended(route('uploader.dashboard'));
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}


    public function logout(Request $request)
    {
        Auth::guard($this->guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('uploader.uploads.login');
    }
}
