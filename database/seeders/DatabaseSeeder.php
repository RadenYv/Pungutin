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
            TeamSeeder::class,
            TeamPetugasSeeder::class,    
            BatchesSeeder::class,        
            TransaksiSampahSeeder::class 
        ]);
    }
}
