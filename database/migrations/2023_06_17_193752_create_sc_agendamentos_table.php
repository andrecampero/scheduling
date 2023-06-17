<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScAgendamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_agendamentos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_usuario')->index('fk_usuario');
            $table->date('data_agendamento');
            $table->time('hora_agendamento');
            $table->string('status', 250)->default('Agendado');
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
        Schema::dropIfExists('sc_agendamentos');
    }
}
