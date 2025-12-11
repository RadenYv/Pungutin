<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {

            $table->id('id_team');

            // Truck assigned to this team
            $table->unsignedBigInteger('id_truck');

            // Team operational date
            $table->date('tanggal');

            $table->timestamps();

            // FK -> pickup truck
            $table->foreign('id_truck')
                ->references('id_truck')
                ->on('pickup_truck')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
