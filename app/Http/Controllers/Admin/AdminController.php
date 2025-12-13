<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Petugas;
use App\Models\PickupTruck;
use App\Models\TransaksiSampah;
use App\Models\Batch;
use App\Models\Team;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $recentTransaksi = TransaksiSampah::with([
            'batch.truck',
            'batch.team.members.petugas'
        ])
        ->where('status', 'selesai')
        ->orderBy('id_transaksi', 'DESC')
        ->take(5)
        ->get();
    
        return view('Admin.dashboard', [
            'totalUsers'        => User::where('role', 'user')->count(),
            'totalPetugas'      => Petugas::count(),
            'totalTrucks'       => PickupTruck::count(),
            'recentTransaksi'   => $recentTransaksi,

            // Transaksi statistics
            'transaksiMenunggu' => TransaksiSampah::where('status', 'menunggu')->count(),
            'transaksiBatch'    => TransaksiSampah::where('status', 'dalam_batch')->count(),
            'transaksiJemput'   => TransaksiSampah::where('status', 'dijemput')->count(),
            'transaksiSelesai'  => TransaksiSampah::where('status', 'selesai')->count(),

            // Batch statistics
            'batchPending'      => Batch::where('status', 'pending')->count(),
            'batchTugas'        => Batch::where('status', 'ditugaskan')->count(),
            'batchBerjalan'     => Batch::where('status', 'berjalan')->count(),
            'batchSelesai'      => Batch::where('status', 'selesai')->count(),
        ]);
    }
}
