<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TransaksiSampah;
use App\Models\KategoriSampah;

class UserTransaksiController extends Controller
{

    public function index()
    {
        $transaksi = TransaksiSampah::where('id_user', Auth::id())
            ->with(['kategori', 'petugas'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $kategori = KategoriSampah::all();
        return view('user.transaksi.create', compact('kategori'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'berat_kg' => 'required|numeric|min:0.1',
        'id_kategori' => 'required|exists:kategori_sampah,id_kategori',
        'alamat' => 'required',
        'no_hp' => 'required',
    ]);

    $kategori = KategoriSampah::findOrFail($request->id_kategori);

    $total_uang = $kategori->harga_per_kg * $request->berat_kg;
    $poin = $kategori->poin_per_kg * $request->berat_kg;

    TransaksiSampah::create([
        'id_user' => Auth::id(),
        'id_petugas' => null,
        'id_kategori' => $request->id_kategori,
        'berat_kg' => $request->berat_kg,
        'total_uang' => $total_uang,
        'poin_didapat' => $poin,
        'alamat' => $request->alamat,
        'no_hp' => $request->no_hp,
        'catatan' => $request->catatan,
        'status' => 'menunggu'
    ]);

    return redirect()->route('user.transaksi.index')
        ->with('success', 'Permintaan penjemputan berhasil dikirim!');
    }


    public function show($id)
    {
        $transaksi = TransaksiSampah::where('id_transaksi', $id)
            ->where('id_user', Auth::id())
            ->with(['kategori', 'petugas'])
            ->firstOrFail();

        return view('user.transaksi.show', compact('transaksi'));
    }
}
