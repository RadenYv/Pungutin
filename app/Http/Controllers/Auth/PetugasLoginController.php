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
        $credentials = $request->only('email', 'password');

        if (Auth::guard('petugas')->attempt($credentials)) {
            $request->session()->regenerate();
            session()->flash('success', 'Selamat Anda Max Versteppen!');
            //return redirect()->route('cuming soon');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function logout()
    {
        Auth::guard('petugas')->logout();
        return redirect()->route('petugas.login');
    }
}