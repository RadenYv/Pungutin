<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_sampah', function (Blueprint $table) {
            $table->id('id_transaksi');

            // Relations
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_batch');

            // Weight System
            $table->float('berat_kg')->nullable();        
            $table->float('berat_kg_final')->nullable(); 

            // Calculations
            $table->integer('total_uang')->nullable();
            $table->integer('poin_didapat')->nullable();

            // Pickup info
            $table->date('tanggal_pickup');
            $table->enum('pickup_window', ['09:00-12:00', '13:00-16:00', '17:00-20:00']);  

            // Contact info
            $table->string('alamat');
            $table->string('no_hp');

            // Optional notes
            $table->text('catatan')->nullable();

            // Status flow
            $table->enum('status', ['menunggu', 'dalam_batch', 'dijemput', 'selesai'])->default('menunggu');

            $table->timestamps();

            // FK constraints
            $table->foreign('id_user')
                ->references('id_user')->on('users')
                ->cascadeOnDelete();

            $table->foreign('id_kategori')
                ->references('id_kategori')->on('kategori_sampah')
                ->cascadeOnDelete();

            $table->foreign('id_batch')
                ->references('id_batch')->on('batches')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_sampah');
    }
};
