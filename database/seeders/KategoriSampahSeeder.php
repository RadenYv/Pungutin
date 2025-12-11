<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSampahSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_sampah')->insert([
            [
                'nama_kategori' => 'bottle',
                'harga_per_kg' => 3000,
                'poin_per_kg' => 1,
            ],
            [
                'nama_kategori' => 'cans',
                'harga_per_kg' => 5000,
                'poin_per_kg' => 2,
            ],
            [
                'nama_kategori' => 'glass bottle',
                'harga_per_kg' => 4000,
                'poin_per_kg' => 1,
            ],
        ]);
    }
}
