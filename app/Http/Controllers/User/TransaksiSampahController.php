<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TransaksiSampah;
use App\Models\Batch;
use App\Models\PickupTruck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiSampahController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $transaksi = TransaksiSampah::where('id_user', $user->id_user)
            ->with(['kategori','batch'])
            ->orderBy('id_transaksi','DESC')
            ->get();

        return view('user.transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        return view('user.transaksi.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'id_kategori'    => 'required|exists:kategori_sampah,id_kategori',
            'berat_kg'       => 'nullable|numeric|min:0',
            'tanggal_pickup' => 'required|date',
            'pickup_window'  => 'required|string',
            'alamat'         => 'required|string',
            'no_hp'          => 'required|string',
            'catatan'        => 'nullable|string',
        ]);

        // Find pending batch for that date
        $batch = Batch::where('status', 'pending')
            ->where('tanggal', $validated['tanggal_pickup'])
            ->withCount('transaksi')
            ->having('transaksi_count', '<', 5)
            ->first();

        // Create batch if none exists
        if (!$batch) {
            $truck = PickupTruck::where('status', 'idle')->first();
            if (!$truck) {
                return back()->withErrors(['msg' => 'Belum ada truck idle untuk membuat batch.']);
            }

            $batch = Batch::create([
                'id_truck' => $truck->id_truck,
                'id_team'  => null,
                'tanggal'  => $validated['tanggal_pickup'],
                'status'   => 'pending',
            ]);
        }

        // CREATE transaksi
        $transaksi = TransaksiSampah::create([
            'id_user'        => $user->id_user,
            'id_kategori'    => $validated['id_kategori'],
            'id_batch'       => $batch->id_batch,
            'berat_kg'       => $validated['berat_kg'] ?? null,
            'tanggal_pickup' => $validated['tanggal_pickup'],
            'pickup_window'  => $validated['pickup_window'],
            'alamat'         => $validated['alamat'],
            'no_hp'          => $validated['no_hp'],
            'catatan'        => $validated['catatan'],
            'status'         => 'dalam_batch',
        ]);

        return redirect()->route('user.transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
    }
}
