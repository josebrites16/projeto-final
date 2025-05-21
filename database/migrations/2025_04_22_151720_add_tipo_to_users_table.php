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
<<<<<<<< HEAD:database/migrations/2025_04_11_092105_create_faqs_table.php
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('pergunta');
            $table->text('resposta');
            $table->timestamps();
        });
    }
 
========
{
    Schema::table('users', function (Blueprint $table) {
        $table->enum('tipo', ['admin', 'user'])->default('user')->after('email');
    });
}

>>>>>>>> users-page:database/migrations/2025_04_22_151720_add_tipo_to_users_table.php
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<<< HEAD:database/migrations/2025_04_11_092105_create_faqs_table.php
        Schema::dropIfExists('faqs');
========
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
>>>>>>>> users-page:database/migrations/2025_04_22_151720_add_tipo_to_users_table.php
    }
};