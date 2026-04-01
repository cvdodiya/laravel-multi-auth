<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // ── Show the admin login form ─────────────────────────────────────────────
    public function showLogin()
    {
        // If already logged in as admin, go straight to dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    // ── Handle login form submission ──────────────────────────────────────────
    public function login(Request $request)
    {
        // 1. Validate input
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // 2. attempt() checks DB, hashes password, creates session — all in one call
        //    We MUST pass 'admin' guard, otherwise it checks the 'users' table!
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate(); // prevent session fixation attack
            return redirect()->route('admin.dashboard');
        }

        // 3. attempt() returned false → wrong credentials
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->onlyInput('email');
    }

    // ── Logout ────────────────────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
