<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiSampah;
use App\Models\Batch;
use App\Models\KategoriSampah;
use Illuminate\Http\Request;

class TransaksiSampahController extends Controller
{
    public function index(Request $request)
    {
        $query = TransaksiSampah::with(['user', 'kategori', 'batch.team', 'batch.truck']);

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $transaksi = $query->orderBy('id_transaksi', 'DESC')->get();

        $batches = Batch::where('status', 'pending')->orderBy('tanggal')->get();

        return view('Admin.transaksi.index', compact('transaksi', 'batches'));
    }

    // show() removed per requirements

    public function edit($id)
    {
        $transaksi = TransaksiSampah::findOrFail($id);
        $kategori = KategoriSampah::all();
        $batches = Batch::with('truck', 'team')->get();

        return view('Admin.transaksi.edit', compact('transaksi', 'kategori', 'batches'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = TransaksiSampah::findOrFail($id);

        $validated = $request->validate([
            'id_kategori'    => 'sometimes|exists:kategori_sampah,id_kategori',
            'id_batch'       => 'sometimes|nullable|exists:batches,id_batch',
            'tanggal_pickup' => 'sometimes|date',
            'pickup_window'  => 'sometimes|string',
            'alamat'         => 'sometimes|string',
            'no_hp'          => 'sometimes|string',
            'catatan'        => 'nullable|string',
            'status'         => 'sometimes|in:menunggu,dalam_batch,dijemput,selesai'
        ]);

        $transaksi->update($validated);

        return redirect()->route('admin.transaksi.index')
                         ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function moveToBatch(Request $request, $id)
    {
        $request->validate([
            'id_batch' => 'required|exists:batches,id_batch'
        ]);

        $batch = Batch::withCount('transaksi')->findOrFail($request->id_batch);
        if ($batch->transaksi_count >= 5) {
            return back()->withErrors(['msg' => 'Batch sudah penuh (max 5 transaksi).']);
        }

        $transaksi = TransaksiSampah::findOrFail($id);

        $transaksi->id_batch = $batch->id_batch;
        $transaksi->status = 'dalam_batch';
        $transaksi->save();

        return back()->with('success', 'Transaksi berhasil dipindahkan ke batch.');
    }

    public function assignBatch(Request $request, $id)
    {
        $request->validate([
            'id_batch' => 'required|exists:batches,id_batch'
        ]);

        $batch = Batch::withCount('transaksi')->findOrFail($request->id_batch);
        if ($batch->transaksi_count >= 5) {
            return back()->withErrors(['msg' => 'Batch sudah penuh (max 5 transaksi).']);
        }

        $transaksi = TransaksiSampah::findOrFail($id);
        $transaksi->id_batch = $batch->id_batch;
        $transaksi->status = 'dalam_batch';
        $transaksi->save();

        return back()->with('success', 'Transaksi dimasukkan ke batch.');
    }

    public function removeBatch($id)
    {
        $transaksi = TransaksiSampah::findOrFail($id);
        $transaksi->id_batch = null;
        $transaksi->status = 'menunggu';
        $transaksi->save();

        return back()->with('success', 'Transaksi dikeluarkan dari batch.');
    }
}
