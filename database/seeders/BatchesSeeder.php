<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batch;
use App\Models\Team;
use Carbon\Carbon;

class BatchesSeeder extends Seeder
{
    public function run(): void
    {
        $teams = Team::take(3)->get();
        $statuses = ['pending', 'ditugaskan', 'berjalan', 'selesai'];

        foreach ($teams as $index => $team) {
            Batch::create([
                'id_team'  => $team->id_team,
                'id_truck' => $team->id_truck,
                'tanggal'  => $team->tanggal,
                'status'   => $statuses[$index % 4]
            ]);
        }
    }
}
