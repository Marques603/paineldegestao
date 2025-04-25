<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('documents', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->string('revision')->nullable();
        $table->string('file_path');
        $table->string('file_type')->nullable();
        $table->foreignId('macro_id')->nullable()->constrained()->nullOnDelete(); // documento pertence a uma macro
        $table->unsignedBigInteger('uploaded_by'); // usuário que enviou

        $table->boolean('status')->default(1); // ativo/inativo
        $table->timestamps();

        $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
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
