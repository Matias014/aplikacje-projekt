<?php

namespace App\Http\Controllers;

use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('index');
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            ActivityLogger::log('auth.login', Auth::user());
            return redirect()->route('index');
        }

        return back()->withErrors([
            'email' => 'Podane dane uwierzytelniające nie są zgodne z naszymi danymi.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        ActivityLogger::log('auth.logout', Auth::user());
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->back();
    }
}
