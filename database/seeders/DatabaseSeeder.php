<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Jalankan seeder lain di sini
        $this->call([AdminSeeder::class,
                PetugasSeeder::class,
                UserSeeder::class,
        ]);
    }
}
