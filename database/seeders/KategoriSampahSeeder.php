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
                'nama_kategori' => 'Botol Plastik',
                'harga_per_kg' => 3000,
                'poin_per_kg' => 3,
            ],
            [
                'nama_kategori' => 'Kaleng',
                'harga_per_kg' => 5000,
                'poin_per_kg' => 5,
            ],
            [
                'nama_kategori' => 'Botol Kaca',
                'harga_per_kg' => 4000,
                'poin_per_kg' => 4,
            ],
        ]);
    }
}
