<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('petugas')->insert([
            'nama' => 'Anto',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('petugas123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
