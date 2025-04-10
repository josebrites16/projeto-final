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
        Schema::table('rotas', function (Blueprint $table) {
            $table->enum('zona', ['sul', 'centro', 'norte']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rotas', function (Blueprint $table) {
            $table->dropColumn('zona');
        });
    }
};
