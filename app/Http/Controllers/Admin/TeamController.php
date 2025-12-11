<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamPetugas;
use App\Models\PickupTruck;
use App\Models\Petugas;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with(['truck', 'members.petugas'])->get();
        return view('Admin.team.index', compact('teams'));
    }

    public function create()
    {
        $trucks = PickupTruck::where('status', 'idle')->get();
        $petugas = Petugas::where('status', 'aktif')->get();

        return view('Admin.team.create', compact('trucks', 'petugas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_truck'  => 'required|exists:pickup_truck,id_truck',
            'tanggal'   => 'required|date',
            'driver'    => 'required|exists:petugas,id_petugas',
            'co_driver' => 'required|exists:petugas,id_petugas|different:driver',
        ]);

        // Check if truck is already assigned to another team on the same date
        $existingTeam = Team::where('id_truck', $validated['id_truck'])
            ->where('tanggal', $validated['tanggal'])
            ->first();

        if ($existingTeam) {
            return back()->withErrors(['id_truck' => 'Truck ini sudah digunakan oleh team lain pada tanggal tersebut.'])->withInput();
        }

        $team = Team::create([
            'id_truck' => $validated['id_truck'],
            'tanggal'  => $validated['tanggal'],
        ]);

        TeamPetugas::create([
            'id_team'    => $team->id_team,
            'id_petugas' => $validated['driver'],
            'role'       => 'driver',
        ]);

        TeamPetugas::create([
            'id_team'    => $team->id_team,
            'id_petugas' => $validated['co_driver'],
            'role'       => 'co-driver',
        ]);

        $truck = PickupTruck::find($validated['id_truck']);
        $truck->status = 'penjemputan';
        $truck->save();

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team berhasil dibuat.');
    }
}
