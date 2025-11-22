<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TransaksiSampah;

class PenjemputanController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiSampah::where('id_petugas', Auth::id())
            ->whereIn('status', ['dijemput', 'menunggu'])
            ->with(['user', 'kategori'])
            ->get();

        return view('petugas.penjemputan.index', compact('transaksi'));
    }

    public function show($id)
    {
        $item = TransaksiSampah::where('id_petugas', Auth::id())
            ->where('id_transaksi', $id)
            ->with(['user', 'kategori'])
            ->firstOrFail();

        return view('petugas.penjemputan.show', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'berat_kg' => 'required|numeric|min:0.1',
        ]);

        $t = TransaksiSampah::where('id_transaksi', $id)->firstOrFail();

        $kategori = $t->kategori;

        // Recalculate uang & poin after adjustment
        $t->berat_kg = $request->berat_kg;
        $t->total_uang = $kategori->harga_per_kg * $request->berat_kg;
        $t->poin_didapat = $kategori->poin_per_kg * $request->berat_kg;
        $t->status = 'selesai';
        $t->save();

        return redirect()->route('petugas.penjemputan.index')
            ->with('success', 'Berat berhasil diperbarui & transaksi selesai.');
    }
}

