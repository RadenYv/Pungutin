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

        $pickupWindows = ['09:00-12:00', '13:00-16:00', '17:00-20:00'];
        $statuses = ['menunggu', 'dalam_batch', 'dijemput',];
        $addresses = [
            'Jl. Merdeka No. 45',
            'Jl. Sudirman No. 123',
            'Jl. Gatot Subroto No. 78',
            'Jl. Ahmad Yani No. 56',
            'Jl. Diponegoro No. 89',
            'Jl. Veteran No. 34',
            'Jl. Imam Bonjol No. 67',
            'Jl. Cendrawasih No. 12',
            'Jl. Pahlawan No. 90',
            'Jl. Kartini No. 23'
        ];

        // Generate 10 dummy transaksi with varied statuses
        for ($i = 0; $i < 10; $i++) {
            $user     = $users->random();
            $kategori = $kategoriList->random();

            // 50% chance to be in a batch
            $hasBatch = (rand(0, 1) === 1) && ($batches->count() > 0);
            
            $batchId = null;
            $status = 'menunggu';
            $tanggalPickup = Carbon::now()->addDays(rand(1, 7))->format('Y-m-d'); // Default future date

            if ($hasBatch) {
                $batch = $batches->random();
                $batchId = $batch->id_batch;
                $status = ['dalam_batch', 'dijemput', 'selesai'][rand(0, 2)];
                $tanggalPickup = Carbon::parse($batch->tanggal)->format('Y-m-d');
            }

            // Estimated vs final weight
            $beratUser  = rand(10, 50) / 10;   // 1.0 – 5.0 kg
            $beratFinal = max($beratUser - (rand(0, 3) / 10), 0.1); // Slight correction by petugas

            // Calculate money & points
            $totalUang = $beratFinal * $kategori->harga_per_kg;
            $poin      = floor($beratFinal * $kategori->poin_per_kg);

            TransaksiSampah::create([
                'id_user'        => $user->id_user,
                'id_kategori'    => $kategori->id_kategori,
                'id_batch'       => $batchId,

                'berat_kg'       => $beratUser,
                'berat_kg_final' => $beratFinal,
                'total_uang'     => $totalUang,
                'poin_didapat'   => $poin,

                'tanggal_pickup' => $tanggalPickup,
                'pickup_window'  => $pickupWindows[array_rand($pickupWindows)],

                'alamat'         => $addresses[$i],
                'no_hp'          => '0812345' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'catatan'        => $i % 2 == 0 ? 'Taruh depan pagar' : 'Hubungi dulu sebelum datang',

                'status'         => $status
            ]);
        }
    }
}