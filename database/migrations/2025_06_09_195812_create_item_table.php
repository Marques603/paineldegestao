<?php

use Illuminate\Database\Eloquent\SoftDeletes;
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
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_material', [
                'epi_epc',
                'maquinario',
                'material_escritorio',
                'material_informatica',
                'material_limpeza',
                'material_eletrico',
                'material_producao',
                'outro',
                'prestacao_servico'
            ]);
            $table->enum('tipo_utilizacao', [
                'industrializacao',
                'uso_consumo',
                'imobilizado'
            ]);
            $table->string('descricao'); // Descrição da solicitação
            $table->string('descricao_detalhada'); // Descrição detalhada do material
            $table->string('marcas')->nullable(); // Marcas do material
            $table->string('link_exemplo')->nullable(); // Link de exemplo do material
            $table->string('imagem')->nullable(); // Imagem do material
            $table->unsignedBigInteger('compra_id')->nullable(); // ID da compra associada
            $table->softDeletes(); // Soft delete para o item
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item');
    }
};
