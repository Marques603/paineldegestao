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
        Schema::table('document_user', function (Blueprint $table) {
            // Verificar se a coluna já existe antes de adicionar
            if (!Schema::hasColumn('document_user', 'document_id')) {
                $table->foreignId('document_id')->constrained()->onDelete('cascade');
            }

            if (!Schema::hasColumn('document_user', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_user', function (Blueprint $table) {
            // Remover as colunas, se existirem
            $table->dropColumn('document_id');
            $table->dropColumn('user_id');
        });
    }
};
