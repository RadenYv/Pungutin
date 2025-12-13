<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransaksiSampah;
use App\Models\User;
use App\Models\KategoriSampah;
use App\Models\Batch;
use Carbon\Carbon;

class TransaksiSampahSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $kategoriList = KategoriSampah::all();
        $batches = Batch::all();

        if ($users->count() == 0 || $kategoriList->count() == 0 || $batches->count() == 0) {
            return; // avoid FK crashes
        }

        // Generate 20 dummy transaksi, all status 'menunggu'
        for ($i = 0; $i < 20; $i++) {
            $user     = $users->random();
            $kategori = $kategoriList->random();
            $batch    = $batches->random();

            // Estimated vs final weight
            $beratUser  = rand(1, 5) + (rand(0, 9) / 10);   // 1.0 – 5.9 kg
            $beratFinal = max($beratUser - (rand(0, 2) / 10), 0.1); // Slight correction by petugas

            // Calculate money & points
            $totalUang = $beratFinal * $kategori->harga_per_kg;
            $poin      = floor($beratFinal * $kategori->poin_per_kg);
            $tanggalPickup = Carbon::parse($batch->tanggal)->format('Y-m-d');

            // Define allowed pickup windows as ENUM values (example: '09:00-12:00', ..., '18:00-21:00')
            $pickupWindows = [
                '09:00-12:00',
                '13:00-16:00',
                '17:00-20:00',
            ];
            $pickupWindow = $pickupWindows[array_rand($pickupWindows)];

            TransaksiSampah::create([
                'id_user'        => $user->id_user,
                'id_kategori'    => $kategori->id_kategori,
                'id_batch'       => $batch->id_batch,

                'berat_kg'       => $beratUser,
                'berat_kg_final' => $beratFinal,
                'total_uang'     => $totalUang,
                'poin_didapat'   => $poin,

                'tanggal_pickup' => $tanggalPickup,
                'pickup_window'  => $pickupWindow,

                'alamat'         => "Jl. Contoh No. " . rand(1, 200),
                'no_hp'          => '08123' . rand(10000, 99999),
                'catatan'        => 'Taruh depan pagar',

                // Must match ENUM in database
                'status'         => 'menunggu'
            ]);
        }
    }
}