<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            // Admin - keep the same
            [
                'nama' => 'Raden',
                'email' => 'raden1@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'no_hp' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Regular users - 10 users
            [
                'nama' => 'Rizki Pratama',
                'email' => 'rizki@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'no_hp' => '081234567891',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Wati Susanti',
                'email' => 'wati@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'no_hp' => '081234567892',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'no_hp' => '081234567893',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'no_hp' => '081234567894',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Andi Wijaya',
                'email' => 'andi@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'no_hp' => '081234567895',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dewi Lestari',
                'email' => 'dewi@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'no_hp' => '081234567896',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Rudi Hartono',
                'email' => 'rudi@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'no_hp' => '081234567897',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Linda Permata',
                'email' => 'linda@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'no_hp' => '081234567898',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Agus Setiawan',
                'email' => 'agus@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'no_hp' => '081234567899',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Nina Handayani',
                'email' => 'nina@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'no_hp' => '081234567800',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $u) {
            DB::table('users')->updateOrInsert(
                ['email' => $u['email']],
                $u
            );
        }
    }
}
