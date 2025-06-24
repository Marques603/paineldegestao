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
            $table->date('date'); 
            $table->time('timeinit'); 
            $table->time('timeend')->nullable(); // Hora de término, pode ser nula se não houver término
            $table->string('destination');
            $table->string('motive');
            $table->timestamps();
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
