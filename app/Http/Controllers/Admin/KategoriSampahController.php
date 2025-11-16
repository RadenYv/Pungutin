<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriSampah;

class KategoriSampahController extends Controller
{
    public function index()
    {
        $kategori = KategoriSampah::all();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'harga_per_kg'  => 'required|numeric|min:0',
            'poin_per_kg'   => 'required|numeric|min:0',
        ]);

        KategoriSampah::create([
            'nama_kategori' => $request->nama_kategori,
            'harga_per_kg'  => $request->harga_per_kg,
            'poin_per_kg'   => $request->poin_per_kg,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = KategoriSampah::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriSampah::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'harga_per_kg'  => 'required|numeric|min:0',
            'poin_per_kg'   => 'required|numeric|min:0',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'harga_per_kg'  => $request->harga_per_kg,
            'poin_per_kg'   => $request->poin_per_kg,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        KategoriSampah::findOrFail($id)->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
