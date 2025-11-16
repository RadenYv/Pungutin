<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_sampah', function (Blueprint $table) {
            // Primary Key
            $table->id('id_transaksi');

            // Data transaksi utama
            $table->decimal('berat_kg', 8, 2)->comment('Berat sampah aktual dalam kilogram');
            $table->integer('total_uang')->default(0)->comment('Total uang yang diterima user');
            $table->integer('poin_didapat')->default(0)->comment('Total poin yang didapat user');

            // Informasi tambahan dari form user
            $table->text('alamat')->nullable()->comment('Alamat lokasi pengambilan');
            $table->string('no_hp')->nullable()->comment('Nomor HP user');
            $table->text('catatan')->nullable()->comment('Catatan tambahan dari user');

            // Status proses transaksi
            $table->enum('status', ['menunggu', 'dijemput', 'selesai'])
                ->default('menunggu')
                ->comment('Status proses pengambilan sampah');

            // Timestamps
            $table->timestamps();

            // Relasi antar tabel
           $table->foreignId('id_user')
                ->constrained('users', 'id_user')
                ->cascadeOnDelete();

            $table->foreignId('id_petugas')
                ->constrained('petugas', 'id_petugas')
                ->restrictOnDelete();

            $table->foreignId('id_kategori')
                ->constrained('kategori_sampah', 'id_kategori')
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_sampah');
    }
};
