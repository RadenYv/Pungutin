<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id('id_batch');

            $table->unsignedBigInteger('id_truck')->nullable();
            $table->unsignedBigInteger('id_team')->nullable(); 

            $table->date('tanggal');
            $table->enum('pickup_window', ['09:00-12:00', '13:00-16:00', '17:00-20:00']);

            $table->enum('status', ['pending', 'ditugaskan', 'berjalan', 'selesai'])
                    ->default('pending');

            $table->timestamps();

            // Foreign Keys
            $table->foreign('id_truck')
                  ->references('id_truck')
                  ->on('pickup_truck')
                  ->cascadeOnDelete();

            $table->foreign('id_team')
                  ->references('id_team')
                  ->on('teams')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
