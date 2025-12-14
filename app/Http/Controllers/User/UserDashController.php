<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TransaksiSampah;

class UserDashController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $transaksi = TransaksiSampah::where('id_user', $user->id_user)
            ->with(['kategori', 'petugas'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.dashboard', compact('user', 'transaksi'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }
}

