<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome do veículo
            $table->enum('model', ['Hatch', 'Sedan', 'SUV', 'Picape', 'Caminhonete', 'Van', 'Utilitário', 'Caminhão']); // Modelo do veículo
            $table->string('plate')->unique(); // Placa do veículo
            $table->string('brand'); // Marca do veículo
            $table->timestamps(); // Timestamps para created_at e updated_at
            $table->softDeletes(); // Soft delete para permitir exclusão lógica
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
