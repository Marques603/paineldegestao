<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();

            $table->date('data_necessidade'); // Data em que o material é necessário
            $table->enum('realizar_orcamento', ['sim', 'nao']); // Indica se é necessário realizar orçamento
            $table->decimal('valor_previsto', 10, 2);
            $table->integer('quantidade'); 
            $table->text('justificativa'); 
            $table->string('sugestao_fornecedor')->nullable(); 
            $table->timestamps();
            $table->softDeletes(); // Soft delete para a compra
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
