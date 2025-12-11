<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
    $this->call([
            UserSeeder::class,             
            PetugasSeeder::class,
            KategoriSampahSeeder::class,
            PickupTrucksSeeder::class,

            // TEAM SYSTEM
            TeamSeeder::class,           // requires trucks
            TeamPetugasSeeder::class,    // requires teams + petugas

            // BATCHES
            BatchesSeeder::class,        // requires teams + trucks

            // TRANSAKSI
            TransaksiSampahSeeder::class // requires users + kategori + batches
        ]);
    }
}
