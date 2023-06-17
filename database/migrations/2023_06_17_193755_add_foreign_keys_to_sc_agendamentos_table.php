<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToScAgendamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sc_agendamentos', function (Blueprint $table) {
            $table->foreign(['id_usuario'], 'fk_usuario')->references(['id'])->on('sc_usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sc_agendamentos', function (Blueprint $table) {
            $table->dropForeign('fk_usuario');
        });
    }
}
