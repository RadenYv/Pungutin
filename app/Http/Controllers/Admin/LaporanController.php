<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiSampah;
use App\Models\Batch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        [$startDate, $endDate] = $this->ambilRentangTanggal($request);

        $querySelesai = TransaksiSampah::where('status', 'selesai')
            ->whereBetween('tanggal_pickup', [$startDate, $endDate]);

        $ringkasan = $this->hitungRingkasan($querySelesai);

        $batchSelesai = Batch::where('status', 'selesai')
            ->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
            ->count();

        $transaksiMenunggu = TransaksiSampah::where('status', 'menunggu')
            ->whereBetween('tanggal_pickup', [$startDate, $endDate])
            ->count();

        $perKategori = $this->breakdownPerKategori($querySelesai);
        $perHari     = $this->breakdownPerHari($querySelesai);

        return view('Admin.laporan.index', array_merge($ringkasan, [
            'startDate'         => $startDate,
            'endDate'           => $endDate,
            'batchSelesai'      => $batchSelesai,
            'transaksiMenunggu' => $transaksiMenunggu,
            'perKategori'       => $perKategori,
            'perHari'           => $perHari,
            'generatedAt'       => Carbon::now(),
        ]));
    }

    private function ambilRentangTanggal(Request $request): array
    {
        $mulai = $request->filled('start_date')
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : Carbon::now()->startOfMonth();

        $akhir = $request->filled('end_date')
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : Carbon::now()->endOfDay();

        if ($akhir->lt($mulai)) {
            $akhir = $mulai->copy()->endOfDay();
        }

        return [$mulai, $akhir];
    }

    private function hitungRingkasan($query): array
    {
        $agregat = (clone $query)
            ->selectRaw('
                COALESCE(SUM(berat_kg_final), 0) as total_kg,
                COALESCE(SUM(total_uang), 0)    as total_uang,
                COALESCE(SUM(poin_didapat), 0)  as total_poin,
                COUNT(*) as total_transaksi
            ')
            ->first();

        $totalKg        = (float) $agregat->total_kg;
        $totalUang      = (float) $agregat->total_uang;
        $totalTransaksi = (int)   $agregat->total_transaksi;

        return [
            'totalKg'        => $totalKg,
            'totalUang'      => $totalUang,
            'totalPoin'      => (int) $agregat->total_poin,
            'totalTransaksi' => $totalTransaksi,
            'avgKg'          => $totalTransaksi > 0 ? $totalKg / $totalTransaksi : 0,
            'avgUang'        => $totalTransaksi > 0 ? $totalUang / $totalTransaksi : 0,
        ];
    }

    private function breakdownPerKategori($query)
    {
        return (clone $query)
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
    }

    private function breakdownPerHari($query)
    {
        return (clone $query)
            ->select(
                DB::raw('DATE(tanggal_pickup) as tanggal'),
                DB::raw('SUM(berat_kg_final) as total_kg'),
                DB::raw('SUM(total_uang) as total_uang'),
                DB::raw('COUNT(*) as total_transaksi')
            )
            ->groupBy(DB::raw('DATE(tanggal_pickup)'))
            ->orderByDesc('tanggal')
            ->get();
    }
}
