<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\PickupTruck;
use App\Models\Team;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with(['truck', 'team.members.petugas', 'transaksi'])
            ->orderBy('tanggal', 'desc')
            ->get();

        $teams = Team::withCount('members')->get();

        return view('Admin.batch.index', compact('batches', 'teams'));
    }

    public function create()
    {
        $trucks = PickupTruck::where('status', 'idle')->get();
        return view('Admin.batch.create', compact('trucks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_truck'      => 'nullable|exists:pickup_truck,id_truck',
            'tanggal'       => 'required|date',
            'pickup_window' => 'required|in:09:00-12:00,13:00-16:00,17:00-20:00'
        ]);

        $batch = Batch::create([
            'id_truck'      => $validated['id_truck'] ?? null,
            'tanggal'       => $validated['tanggal'],
            'pickup_window' => $validated['pickup_window'],
            'status'        => 'pending',
        ]);

        return redirect()->route('admin.batches.index')
                         ->with('success', 'Batch berhasil dibuat.');
    }

    public function assignTeam(Request $request, $id_batch)
    {
        $batch = Batch::with('truck')->findOrFail($id_batch);

        $request->validate([
            'id_team' => 'required|integer|exists:teams,id_team'
        ]);

        $team = Team::with('truck')->withCount('members')->findOrFail($request->id_team);

        if ($team->members_count !== 2) {
            return back()->withErrors(['msg' => 'Team harus memiliki tepat 2 petugas']);
        }

        // Assign team to batch
        $batch->id_team = $team->id_team;
        $batch->status = 'ditugaskan';
        $batch->save();

        // Update truck status from idle to penjemputan
        if ($batch->truck) {
            $batch->truck->status = 'penjemputan';
            $batch->truck->save();
        }

        // Update all transaksi in this batch to 'dalam_batch'
        $batch->transaksi()->where('status', 'menunggu')->update(['status' => 'dalam_batch']);

        return redirect()->route('admin.batches.index')
                         ->with('success', 'Team berhasil diassign ke batch. Truck dalam penjemputan.');
    }

    public function start($id_batch)
    {
        $batch = Batch::with(['truck', 'transaksi'])->findOrFail($id_batch);

        // Set batch to berjalan
        $batch->status = 'berjalan';
        $batch->save();

        // Update truck status to penjemputan (if not already)
        if ($batch->truck && $batch->truck->status !== 'penjemputan') {
            $batch->truck->status = 'penjemputan';
            $batch->truck->save();
        }

        // Update all transaksi in this batch to 'dijemput'
        $batch->transaksi()->whereIn('status', ['menunggu', 'dalam_batch'])->update(['status' => 'dijemput']);

        return redirect()->route('admin.batches.index')
                         ->with('success', 'Batch dimulai, semua transaksi dalam status dijemput.');
    }

    public function selesai($id_batch)
    {
        $batch = Batch::with(['truck', 'transaksi'])->findOrFail($id_batch);

        // Complete batch
        $batch->status = 'selesai';
        $batch->save();

        // Free the truck back to idle
        if ($batch->truck) {
            $batch->truck->status = 'idle';
            $batch->truck->save();
        }

        // Update ALL transaksi in this batch to 'selesai'
        $batch->transaksi()->update(['status' => 'selesai']);

        return redirect()->route('admin.batches.index')
                         ->with('success', 'Batch selesai. Semua transaksi telah diselesaikan, truck kembali idle.');
    }

    public function transaksi($id_batch)
    {
        $batch = Batch::with([
            'transaksi.user',
            'transaksi.kategori',
            'team.members.petugas',
            'truck'
        ])->findOrFail($id_batch);

        return view('Admin.batch.transaksi', compact('batch'));
    }
}
