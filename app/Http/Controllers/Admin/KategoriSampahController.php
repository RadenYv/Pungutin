<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriSampah;

class KategoriSampahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $kategori = KategoriSampah::when($search, function ($query, $search) {
            $query->where('nama_kategori', 'like', "%{$search}%")
                  ->orWhere('id_kategori', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(5);
        
        return view('Admin.kategori.index', compact('kategori', 'search'));
    }

    public function create()
    {
        $kategori = KategoriSampah::all();
        return view('Admin.kategori.create');
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
        return view('Admin.kategori.edit', compact('kategori'));
    }

    // show() removed per requirements

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
