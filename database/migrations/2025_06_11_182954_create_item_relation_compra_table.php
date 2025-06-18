<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
             // Tabela pivô sector_responsible_user
    Schema::create('item_compra', function (Blueprint $table) {
        $table->id();
        $table->foreignId('compras_id')->constrained('compras')->onDelete('cascade');
        $table->foreignId('item_id')->constrained('item')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_compra');
 
   }
};
