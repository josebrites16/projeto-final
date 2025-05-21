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
<<<<<<<< HEAD:database/migrations/2025_04_11_092105_create_faqs_table.php
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('pergunta');
            $table->text('resposta');
========
        Schema::create('ponto_imagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ponto_id')->constrained('pontos')->onDelete('cascade');
            $table->string('caminho');
>>>>>>>> rotas:database/migrations/2025_05_05_220200_create_ponto_imagens_table.php
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<<< HEAD:database/migrations/2025_04_11_092105_create_faqs_table.php
        Schema::dropIfExists('faqs');
========
        Schema::dropIfExists('ponto_imagens');
>>>>>>>> rotas:database/migrations/2025_05_05_220200_create_ponto_imagens_table.php
    }
};
