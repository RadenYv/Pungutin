<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_petugas', function (Blueprint $table) {
            $table->id('id_team_petugas');

            // FK to team
            $table->unsignedBigInteger('id_team');

            // FK to petugas
            $table->unsignedBigInteger('id_petugas');
            
            $table->enum('role', ['driver', 'co-driver']);
            $table->timestamps();

            $table->foreign('id_team')
                ->references('id_team')->on('teams')
                ->cascadeOnDelete();

            $table->foreign('id_petugas')
                ->references('id_petugas')->on('petugas')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_petugas');
    }
};
