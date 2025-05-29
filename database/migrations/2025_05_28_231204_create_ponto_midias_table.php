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
        Schema::create('ponto_midias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ponto_id')->constrained()->onDelete('cascade');
            $table->string('tipo'); // imagem, video, audio
            $table->string('caminho');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ponto_midias');
    }
};
