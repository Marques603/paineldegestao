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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_upload'); // ID do usuário que fez o upload
            $table->string('revision')->nullable();
            $table->unsignedBigInteger('macro_id'); // ID da macro associada
            $table->timestamps(); // created_at, updated_at
            $table->string('file_path');
            $table->string('file_type');
            $table->boolean('status')->default(1); // 1 para ativo, 0 para inativo
    
            // Chave estrangeira para o usuário
            $table->foreign('user_upload')->references('id')->on('users')->onDelete('cascade');
            // Chave estrangeira para a macro
            $table->foreign('macro_id')->references('id')->on('macros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
