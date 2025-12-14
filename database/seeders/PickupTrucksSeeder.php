<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PickupTrucksSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pickup_truck')->insert([
            [
                'nama' => 'Truck letoy',
                'plat_nomor' => 'B 1234 CD',
                'kapasitas' => 1000,
                'status' => 'idle',
                'warehouse' => 'Warehouse 1',
            ],
            [
                'nama' => 'Truck Bravo',
                'plat_nomor' => 'B 2345 EF',
                'kapasitas' => 1100,
                'status' => 'idle',
                'warehouse' => 'Warehouse 1',
            ],
            [
                'nama' => 'Truck Charlie',
                'plat_nomor' => 'B 3456 GH',
                'kapasitas' => 1200,
                'status' => 'idle',
                'warehouse' => 'Warehouse 2',
            ],
            [
                'nama' => 'Truck Delta',
                'plat_nomor' => 'B 4567 IJ',
                'kapasitas' => 1300,
                'status' => 'idle',
                'warehouse' => 'Warehouse 2',
            ],
            [
                'nama' => 'Truck Echo',
                'plat_nomor' => 'B 5678 KL',
                'kapasitas' => 1400,
                'status' => 'idle',
                'warehouse' => 'Warehouse 2',
            ],
            [
                'nama' => 'Truck Foxtrot',
                'plat_nomor' => 'B 6789 MN',
                'kapasitas' => 1500,
                'status' => 'idle',
                'warehouse' => 'Warehouse 3',
            ],
            [
                'nama' => 'Truck Golf',
                'plat_nomor' => 'B 7890 OP',
                'kapasitas' => 900,
                'status' => 'idle',
                'warehouse' => 'Warehouse 3',
            ],
            [
                'nama' => 'Truck Hotel',
                'plat_nomor' => 'B 8901 QR',
                'kapasitas' => 1100,
                'status' => 'idle',
                'warehouse' => 'Warehouse 3',
            ],
            [
                'nama' => 'Truck India',
                'plat_nomor' => 'B 9012 ST',
                'kapasitas' => 1000,
                'status' => 'idle',
                'warehouse' => 'Warehouse 4',
            ],
            [
                'nama' => 'Truck Juliet',
                'plat_nomor' => 'B 0123 UV',
                'kapasitas' => 1300,
                'status' => 'idle',
                'warehouse' => 'Warehouse 4',
            ],
        ]);
    }
}
