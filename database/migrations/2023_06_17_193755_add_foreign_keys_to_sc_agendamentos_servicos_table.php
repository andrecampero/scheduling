<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToScAgendamentosServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sc_agendamentos_servicos', function (Blueprint $table) {
            $table->foreign(['id_agendamento'], 'fk_agendamento')->references(['id'])->on('sc_agendamentos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['id_servicos'], 'fk_servicos')->references(['id'])->on('sc_servicos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sc_agendamentos_servicos', function (Blueprint $table) {
            $table->dropForeign('fk_agendamento');
            $table->dropForeign('fk_servicos');
        });
    }
}
