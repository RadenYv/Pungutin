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
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $recentTransaksi = TransaksiSampah::with([
            'batch.truck',
            'batch.team.members.petugas'
        ])
        ->whereIn('status', ['dijemput', 'dalam_batch'])
        ->orderBy('updated_at', 'DESC')
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

            // Truck statistics
            'truckIdle'         => PickupTruck::where('status', 'idle')->count(),
            'truckPenjemputan'  => PickupTruck::where('status', 'penjemputan')->count(),
            'truckMaintenance'  => PickupTruck::where('status', 'maintenance')->count(),
        ]);
    }

    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('Admin.profile', compact('admin'));
    }
}
