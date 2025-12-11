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
            [
                'nama' => 'Anto',
                'email' => 'anto@gmail.com',
                'password' => Hash::make('petugas123'),
                'no_hp' => '08123456789',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi',
                'email' => 'budi@gmail.com',
                'password' => Hash::make('petugas123'),
                'no_hp' => '08234567890',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Candra',
                'email' => 'candra@gmail.com',
                'password' => Hash::make('petugas123'),
                'no_hp' => '08345678901',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dedi',
                'email' => 'dedi@gmail.com',
                'password' => Hash::make('petugas123'),
                'no_hp' => '08456789012',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Eko',
                'email' => 'eko@gmail.com',
                'password' => Hash::make('petugas123'),
                'no_hp' => '08567890123',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Fajar',
                'email' => 'fajar@gmail.com',
                'password' => Hash::make('petugas123'),
                'no_hp' => '08678901234',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Gilang',
                'email' => 'gilang@gmail.com',
                'password' => Hash::make('petugas123'),
                'no_hp' => '08789012345',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Hadi',
                'email' => 'hadi@gmail.com',
                'password' => Hash::make('petugas123'),
                'no_hp' => '08890123456',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Imam',
                'email' => 'imam@gmail.com',
                'password' => Hash::make('petugas123'),
                'no_hp' => '08901234567',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Joko',
                'email' => 'joko@gmail.com',
                'password' => Hash::make('petugas123'),
                'no_hp' => '08911223344',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
