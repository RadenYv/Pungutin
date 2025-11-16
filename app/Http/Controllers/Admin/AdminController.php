<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Petugas;
use App\Models\TransaksiSampah;
use App\Models\KategoriSampah;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUser' => User::count(),
            'totalPetugas' => Petugas::count(),
            'totalTransaksi' => TransaksiSampah::count(),
            'totalKategori' => KategoriSampah::count(),
            'transaksiTerbaru' => TransaksiSampah::with(['user', 'petugas', 'kategori'])
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
