<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToScUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sc_usuarios', function (Blueprint $table) {
            $table->foreign(['id_perfil'], 'fk_perfil')->references(['id'])->on('sc_perfil')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sc_usuarios', function (Blueprint $table) {
            $table->dropForeign('fk_perfil');
        });
    }
}
