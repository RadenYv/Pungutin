<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiSampah;
use App\Models\Petugas;

class TransaksiSampahController extends Controller
{
    // Menampilkan semua transaksi
    public function index()
    {
        $transaksi = TransaksiSampah::with(['user', 'petugas', 'kategori'])
            ->orderBy('created_at', 'desc')
            ->get();

        $petugas = Petugas::all();

        return view('admin.transaksi.index', compact('transaksi', 'petugas'));
    }

    // Assign petugas ke transaksi
    public function assign(Request $request, $id)
    {
        $request->validate([
            'id_petugas' => ['required', 'exists:petugas,id_petugas'],
        ]);

        $transaksi = TransaksiSampah::findOrFail($id);
        $transaksi->id_petugas = $request->id_petugas;
        $transaksi->status = 'dijemput';
        $transaksi->save();

        return redirect()->route('admin.transaksi.index')->with('success', 'Petugas berhasil di-assign.');
    }
}
