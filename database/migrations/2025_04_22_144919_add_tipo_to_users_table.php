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
        Schema::table('users', function (Blueprint $table) {
<<<<<<<< HEAD:database/migrations/2025_04_22_151720_add_tipo_to_users_table.php
            $table->enum('tipo', ['admin', 'user'])->default('user')->after('email');
========
            $table->enum('tipo', ['admin', 'user'])->default('user') ;
>>>>>>>> login:database/migrations/2025_04_22_144919_add_tipo_to_users_table.php
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
};
