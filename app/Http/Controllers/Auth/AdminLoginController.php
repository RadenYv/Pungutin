<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check if email exists in database
        $candidate = \App\Models\User::where('email', $request->email)->first();
        
        if (!$candidate) {
            return back()->withErrors([
                'email' => 'Email belum terdaftar dalam sistem.',
            ])->withInput();
        }
        
        // If the account exists but isn't admin, show 401 page
        if ($candidate && ($candidate->role ?? 'user') !== 'admin') {
            return response()->view('Errors.401', [], 401);
        }

        // Require role=admin on the shared users table
        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'admin';

        if (Auth::guard('admin')->attempt($credentials)) {

            // FORCE Laravel to use admin guard
            Auth::shouldUse('admin');

            $request->session()->regenerate();
            session()->flash('success', 'Admin telah tiba!');

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
