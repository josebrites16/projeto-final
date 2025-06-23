<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescricaoLongaToRotasTable extends Migration
{
    public function up()
    {
        Schema::table('rotas', function (Blueprint $table) {
            $table->text('descricaoLonga')->nullable(); 
        });
    }

    public function down()
    {
        Schema::table('rotas', function (Blueprint $table) {
            $table->dropColumn('descricaoLonga');
        });
    }
}

