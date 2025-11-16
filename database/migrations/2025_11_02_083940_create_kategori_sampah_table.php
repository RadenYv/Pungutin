<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kategori_sampah', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori')->unique();
            $table->decimal('harga_per_kg', 10, 2); // lebih presisi untuk harga non-bulat
            $table->integer('poin_per_kg')->default(10);
            $table->timestamps();
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_sampah');
    }
};
