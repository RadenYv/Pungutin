<?php 

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TransaksiSampah;

class PetugasDashController extends Controller
{
    public function index()
    {
        $petugas = Auth::guard('petugas')->user();

        $transaksi = TransaksiSampah::where('id_petugas', $petugas->id_petugas)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('petugas.dashboard', compact('petugas', 'transaksi'));
    }
}