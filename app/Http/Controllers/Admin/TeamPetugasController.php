<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamPetugas;
use App\Models\Petugas;
use Illuminate\Http\Request;

class TeamPetugasController extends Controller
{
    public function index($id_team)
    {
        $team = Team::with('members.petugas')->findOrFail($id_team);
        $petugas = Petugas::where('status', 'aktif')->get();

        return view('Admin.team.members', compact('team', 'petugas'));
    }

    public function store(Request $request, $id_team)
    {
        $request->validate([
            'id_petugas' => 'required|exists:petugas,id_petugas',
            'role'       => 'required|string|in:driver,co-driver,helper'
        ]);

        $team = Team::findOrFail($id_team);

        if (TeamPetugas::where('id_team', $id_team)
                        ->where('id_petugas', $request->id_petugas)
                        ->exists()) 
        {
            return back()->withErrors('Petugas sudah ada dalam team ini.');
        }

        if ($team->members->count() >= 2) {
            return back()->withErrors('Team sudah penuh. Maksimal 2 petugas.');
        }

        TeamPetugas::create([
            'id_team'    => $id_team,
            'id_petugas' => $request->id_petugas,
            'role'       => $request->role,
        ]);

        return back()->with('success', 'Petugas berhasil ditambahkan ke team.');
    }

    public function destroy($id_team_petugas)
    {
        $tp = TeamPetugas::findOrFail($id_team_petugas);

        $tp->delete();

        return back()->with('success', 'Petugas berhasil dihapus dari team.');
    }
}
