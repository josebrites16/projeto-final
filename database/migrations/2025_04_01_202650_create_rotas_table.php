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
        Schema::create('rotas', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->text('descricao')->nullable(); 
        $table->decimal('distancia', 8, 2); 
        $table->enum('zona', ['Sul', 'Centro', 'Norte']);
        $table->json('coordenadas'); 
        $table->string('imagem')->nullable(); 
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rotas');
    }
};
