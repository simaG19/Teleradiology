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
        // Clear any previous intended URLs to prevent redirect to default login
        session()->forget('url.intended');
        return view('hospital.uploaders.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Clear intended URL before authentication
        session()->forget('url.intended');

        if (Auth::guard($this->guard)->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Use explicit redirect instead of intended()
            return redirect()->route('uploader.dashboard');
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