<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.user-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check if email exists in database
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email belum terdaftar. Silakan daftar terlebih dahulu.',
            ])->withInput()->with('show_signup', true);
        }

        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'user';

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            session()->flash('success', 'Selamat Datang Pungut!');
            return redirect()->route('user.dashboard');
        }

        return back()->withErrors([
            'email' => 'Password salah.',
        ])->withInput();
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('user.login');
    }
}
