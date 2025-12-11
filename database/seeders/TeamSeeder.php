<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\PickupTruck;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        // Example: create 3 teams for 3 trucks for today's date

        $trucks = PickupTruck::take(8)->get();  // adjust count if needed

        foreach ($trucks as $truck) {
            Team::create([
                'id_truck' => $truck->id_truck,
                'tanggal'  => now()->toDateString()
            ]);
        }
    }
}
