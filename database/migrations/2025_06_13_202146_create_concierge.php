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
        Schema::create('concierge', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('user_upload'); // ID do usuário que fez o upload
            // $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->string('destination'); // Destino da viagem
            $table->string('motive'); // Motivo da viagem
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
        Schema::dropIfExists('concierge');
    }
};
