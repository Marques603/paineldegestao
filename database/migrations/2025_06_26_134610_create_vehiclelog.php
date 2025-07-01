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
        Schema::create('vehiclelog', function (Blueprint $table) {
            $table->id();
            $table->foreignId('concierge_id')->constrained('concierge')->onDelete('cascade'); // Referência para o concierge
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade'); // Referência para o veículo
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Referência para o usuário que registrou o log
            $table->string('kminit')->nullable(); // Quilometragem inicial do veículo
            $table->string('kmcurrent')->nullable(); // Quilometragem atual do veículo
            $table->boolean('status')->default(1); // 1 para ativo, 0 para inativo
            $table->timestamps(); // Timestamps para created_at e updated_at
            $table->softDeletes(); // Adiciona a coluna deleted_at para soft deletes
   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiclelog');
    }
};
