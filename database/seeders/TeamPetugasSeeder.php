<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\TeamPetugas;
use App\Models\Petugas;

class TeamPetugasSeeder extends Seeder
{
    public function run(): void
    {
        $teams = Team::all();
        $petugas = Petugas::take(20)->get(); // enough petugas pool

        $i = 0;

        foreach ($teams as $team) {

            // assign driver
            TeamPetugas::create([
                'id_team'    => $team->id_team,
                'id_petugas' => $petugas[$i % $petugas->count()]->id_petugas,
                'role'       => 'driver'
            ]);

            // assign co-driver
            TeamPetugas::create([
                'id_team'    => $team->id_team,
                'id_petugas' => $petugas[($i + 1) % $petugas->count()]->id_petugas,
                'role'       => 'co-driver'
            ]);

            $i += 2;
        }
    }
}
