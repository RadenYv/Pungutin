<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TransaksiSampah;
use App\Models\Batch;

class PenjemputanController extends Controller
{
    public function index()
    {
        $petugasId = Auth::guard('petugas')->id();

        $batchIds = Batch::whereHas('team.members', function($q) use ($petugasId) {
                $q->where('id_petugas', $petugasId);
            })
            ->pluck('id_batch');

        $transaksi = TransaksiSampah::whereIn('id_batch', $batchIds)
            ->whereIn('status', ['dalam_batch', 'dijemput'])
            ->with(['user', 'kategori'])
            ->get();

        return view('petugas.penjemputan.index', compact('transaksi'));
    }

    public function updateBerat(Request $request, $id)
    {
        $request->validate([
            'berat_kg_final' => 'required|numeric|min:0.1',
        ]);

        $t = TransaksiSampah::with('kategori')->findOrFail($id);

        $t->berat_kg_final = $request->berat_kg_final;
        $t->total_uang = (int) round($t->kategori->harga_per_kg * $t->berat_kg_final);
        $t->poin_didapat = (int) round($t->kategori->poin_per_kg * $t->berat_kg_final);
        $t->status = 'dijemput';
        $t->save();

        return redirect()->route('petugas.penjemputan.index')
            ->with('success', 'Berat berhasil diperbarui.');
    }

    public function selesaikan($id)
    {
        $t = TransaksiSampah::findOrFail($id);
        $t->status = 'selesai';
        $t->save();

        return redirect()->route('petugas.penjemputan.index')
            ->with('success', 'Transaksi diselesaikan.');
    }
}

