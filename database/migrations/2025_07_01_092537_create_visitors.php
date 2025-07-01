<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            // Identificação do visitante
            $table->string('name');
            $table->string('document')->unique(); // CPF ou CNPJ
            $table->enum('typevisitor', [
            'CANDIDATO',
            'CLIENTE',
            'COLETA DE RESÍDUOS',
            'COLETA/RETIRA DE MATERIAIS',
            'FORNECEDOR',
            'LOJISTA',
            'OUTROS',
            'PRESTADOR DE SERVIÇOS',
            'REPRESENTANTE'
            ]);
            $table->string('company')->nullable();
            $table->string('service')->nullable();
            $table->enum('parking', ['Sim', 'Não'])->nullable();
            $table->string('vehicle_plate')->nullable(); // Placa do veículo
            $table->string('vehicle_model')->nullable(); // Modelo do veículo
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
