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
    public function index(Request $request)
    {
        $search = $request->search;
        $teams = Team::with(['truck', 'members.petugas'])
        ->when($search, function ($query) use ($search) {
            $query->where('id_team', 'like', "%{$search}%")
                  ->orWhereHas('truck', function ($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('plat_nomor', 'like', "%{$search}%");
                  })
                  ->orWhereHas('members.petugas', function ($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  });
        })
        ->orderBy('tanggal', 'desc')
        ->paginate(5)
        ->withQueryString();
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
            'co_driver' => 'nullable|exists:petugas,id_petugas|different:driver',
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

        if (!empty($validated['co_driver'])) {
            TeamPetugas::create([
                'id_team'    => $team->id_team,
                'id_petugas' => $validated['co_driver'],
                'role'       => 'co-driver',
            ]);
        }

        $truck = PickupTruck::find($validated['id_truck']);
        $truck->status = 'penjemputan';
        $truck->save();

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team berhasil dibuat.');
    }

    public function edit($id)
    {
        $team = Team::with(['truck', 'members.petugas'])->findOrFail($id);
        
        // Get all trucks (include current one even if not idle)
        $trucks = PickupTruck::where('status', 'idle')
            ->orWhere('id_truck', $team->id_truck)
            ->get();
            
        $petugas = Petugas::where('status', 'aktif')->get();
        
        // Get current driver and co-driver
        $currentDriver = $team->members()->where('role', 'driver')->first()?->petugas;
        $currentCoDriver = $team->members()->where('role', 'co-driver')->first()?->petugas;

        return view('Admin.team.edit', compact('team', 'trucks', 'petugas', 'currentDriver', 'currentCoDriver'));
    }

    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);
        
        $validated = $request->validate([
            'id_truck'  => 'required|exists:pickup_truck,id_truck',
            'tanggal'   => 'required|date',
            'driver'    => 'required|exists:petugas,id_petugas',
            'co_driver' => 'nullable|exists:petugas,id_petugas|different:driver',
        ]);

        // Check if truck is already assigned to another team on the same date (except current team)
        $existingTeam = Team::where('id_truck', $validated['id_truck'])
            ->where('tanggal', $validated['tanggal'])
            ->where('id_team', '!=', $team->id_team)
            ->first();

        if ($existingTeam) {
            return back()->withErrors(['id_truck' => 'Truck ini sudah digunakan oleh team lain pada tanggal tersebut.'])->withInput();
        }

        // Update old truck status if truck changed
        if ($team->id_truck != $validated['id_truck']) {
            $oldTruck = PickupTruck::find($team->id_truck);
            if ($oldTruck) {
                $oldTruck->status = 'idle';
                $oldTruck->save();
            }

            // Update new truck status
            $newTruck = PickupTruck::find($validated['id_truck']);
            if ($newTruck) {
                $newTruck->status = 'penjemputan';
                $newTruck->save();
            }
        }

        // Update team data
        $team->update([
            'id_truck' => $validated['id_truck'],
            'tanggal'  => $validated['tanggal'],
        ]);

        // Delete old team members
        $team->members()->delete();

        // Create new driver
        TeamPetugas::create([
            'id_team'    => $team->id_team,
            'id_petugas' => $validated['driver'],
            'role'       => 'driver',
        ]);

        // Create new co-driver if provided
        if (!empty($validated['co_driver'])) {
            TeamPetugas::create([
                'id_team'    => $team->id_team,
                'id_petugas' => $validated['co_driver'],
                'role'       => 'co-driver',
            ]);
        }

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->members()->delete();
        if ($team->truck) {
            $team->truck->status = 'idle';
            $team->truck->save();
        }
        $team->delete();
        return redirect()->route('admin.teams.index')
            ->with('success', 'Team berhasil dihapus.');
    }
}
