<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'nama' => 'Letoy',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
