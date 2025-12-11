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
        // Get existing teams
        $teams = Team::all();

        foreach ($teams as $team) {

            // Create 3 batches for each team
            for ($i = 0; $i < 3; $i++) {

                $start = Carbon::createFromTime(9 + ($i * 2), 0, 0);   // 09:00, 11:00, 13:00
                $end   = $start->copy()->addHours(2);                 // +2 hours

                Batch::create([
                    'id_team'    => $team->id_team,
                    'id_truck'   => $team->id_truck,
                    'tanggal'    => $team->tanggal,
                    'start_time' => $start->format('H:i:s'),
                    'end_time'   => $end->format('H:i:s'),
                    'status'     => 'pending'
                ]);
            }
        }
    }
}
