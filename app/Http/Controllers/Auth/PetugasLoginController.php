<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.petugas-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check if email exists in petugas table
        $petugas = \App\Models\Petugas::where('email', $request->email)->first();
        
        if (!$petugas) {
            return back()->withErrors([
                'email' => 'Email belum terdaftar sebagai petugas.',
            ])->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::guard('petugas')->attempt($credentials)) {
            $request->session()->regenerate();
            session()->flash('success', 'Selamat Anda Max Versteppen!');
            return redirect()->route('petugas.dashboard');
        }

        return back()->withErrors([
            'email' => 'Password salah.',
        ])->withInput();
    }

    public function logout()
    {
        Auth::guard('petugas')->logout();
        return redirect()->route('petugas.login');
    }
}