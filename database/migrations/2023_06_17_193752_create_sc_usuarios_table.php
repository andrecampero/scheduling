<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_usuarios', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_perfil')->index('fk_perfil');
            $table->string('nome', 250);
            $table->string('login', 250);
            $table->string('senha', 250);
            $table->integer('ativo')->default(1);
            $table->timestamp('data_registro')->useCurrent();
            $table->timestamp('data_modificacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sc_usuarios');
    }
}
