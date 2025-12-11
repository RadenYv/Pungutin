<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batch;

class BatchesSeeder extends Seeder
{
    public function run(): void
    {
        $pickupWindows = ['09:00-12:00', '13:00-16:00', '17:00-20:00'];

        // Create 3 fresh batches (no truck, no team assigned)
        foreach ($pickupWindows as $window) {
            Batch::create([
                'id_team'       => null,
                'id_truck'      => null,
                'tanggal'       => now()->toDateString(),
                'pickup_window' => $window,
                'status'        => 'pending'
            ]);
        }
    }
}
