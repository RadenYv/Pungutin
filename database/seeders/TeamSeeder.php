<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\PickupTruck;
use Carbon\Carbon;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $trucks = PickupTruck::take(10)->get();
        $dates = [
            Carbon::now()->subDays(5)->toDateString(),
            Carbon::now()->subDays(4)->toDateString(),
            Carbon::now()->subDays(3)->toDateString(),
            Carbon::now()->subDays(2)->toDateString(),
            Carbon::now()->subDays(1)->toDateString(),
            Carbon::now()->toDateString(),
            Carbon::now()->addDays(1)->toDateString(),
            Carbon::now()->addDays(2)->toDateString(),
            Carbon::now()->addDays(3)->toDateString(),
            Carbon::now()->addDays(4)->toDateString(),
        ];

        foreach ($trucks as $index => $truck) {
            Team::create([
                'id_truck' => $truck->id_truck,
                'tanggal'  => $dates[$index]
            ]);
        }
    }
}
