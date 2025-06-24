<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mileages_car', function (Blueprint $table) {
            $table->id();
            $table->foreignId('concierge_id')->constrained('concierge')->onDelete('cascade'); // Relacionamento com concierge
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade'); // Relacionamento com veículos
            $table->integer('kminit')->nullable(); 
            $table->integer('kmcurrent')->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mileages_car');
    }
};

