<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScPerfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_perfil', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome', 250);
            $table->string('tipo', 250);
            $table->string('permissao', 250);
            $table->integer('admin');
            $table->integer('relacionado');
            $table->integer('ativo')->default(1);
            $table->timestamp('data_registro')->useCurrent();
            $table->timestamp('data_modificacao')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sc_perfil');
    }
}
