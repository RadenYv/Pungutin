<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::create('pickup_truck', function (Blueprint $table) {
            $table->id('id_truck');
            
            $table->string('nama');         
            $table->string('plat_nomor');    
            $table->integer('kapasitas')->nullable();
            $table->enum('status', ['idle', 'maintenance', 'penjemputan'])->default('idle');
            $table->string('warehouse');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pickup_truck');
    }

};
