<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiSampah;
use App\Models\Batch;
use App\Models\KategoriSampah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
       
        $startDate = $request->input('start_date')
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : Carbon::now()->endOfDay();
    
        if ($endDate->lt($startDate)) {
            $endDate = $startDate->copy()->endOfDay();
        }
     
        $completedQuery = TransaksiSampah::where('status', 'selesai')
            ->whereBetween('tanggal_pickup', [$startDate, $endDate]);

        
        $totalKg        = (float) (clone $completedQuery)->sum('berat_kg_final');
        $totalUang      = (float) (clone $completedQuery)->sum('total_uang');
        $totalPoin      = (int)   (clone $completedQuery)->sum('poin_didapat');
        $totalTransaksi = (int)   (clone $completedQuery)->count();
        $avgKg          = $totalTransaksi > 0 ? $totalKg / $totalTransaksi : 0;
        $avgUang        = $totalTransaksi > 0 ? $totalUang / $totalTransaksi : 0;
 
        $batchSelesai = Batch::where('status', 'selesai')
            ->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
            ->count();

        $transaksiMenunggu = TransaksiSampah::where('status', 'menunggu')
            ->whereBetween('tanggal_pickup', [$startDate, $endDate])
            ->count();

    
        $perKategori = (clone $completedQuery)
            ->select(
                'id_kategori',
                DB::raw('SUM(berat_kg_final) as total_kg'),
                DB::raw('SUM(total_uang) as total_uang'),
                DB::raw('SUM(poin_didapat) as total_poin'),
                DB::raw('COUNT(*) as total_transaksi')
            )
            ->groupBy('id_kategori')
            ->with('kategori')
            ->orderByDesc('total_kg')
            ->get();


        $perHari = (clone $completedQuery)
            ->select(
                DB::raw('DATE(tanggal_pickup) as tanggal'),
                DB::raw('SUM(berat_kg_final) as total_kg'),
                DB::raw('SUM(total_uang) as total_uang'),
                DB::raw('COUNT(*) as total_transaksi')
            )
            ->groupBy(DB::raw('DATE(tanggal_pickup)'))
            ->orderBy('tanggal', 'DESC')
            ->get();

        return view('Admin.laporan.index', [
            'startDate'         => $startDate,
            'endDate'           => $endDate,
            'totalKg'           => $totalKg,
            'totalUang'         => $totalUang,
            'totalPoin'         => $totalPoin,
            'totalTransaksi'    => $totalTransaksi,
            'avgKg'             => $avgKg,
            'avgUang'           => $avgUang,
            'batchSelesai'      => $batchSelesai,
            'transaksiMenunggu' => $transaksiMenunggu,
            'perKategori'       => $perKategori,
            'perHari'           => $perHari,
            'generatedAt'       => Carbon::now(),
        ]);
    }
}
