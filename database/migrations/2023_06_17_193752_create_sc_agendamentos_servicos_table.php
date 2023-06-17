<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScAgendamentosServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_agendamentos_servicos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_agendamento')->index('fk_agendamento');
            $table->integer('id_servicos')->index('fk_servicos');
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
        Schema::dropIfExists('sc_agendamentos_servicos');
    }
}
