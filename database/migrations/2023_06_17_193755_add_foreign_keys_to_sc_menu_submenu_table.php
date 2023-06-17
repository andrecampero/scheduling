<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToScMenuSubmenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sc_menu_submenu', function (Blueprint $table) {
            $table->foreign(['sc_menu_id'], 'menu_submenu_fk')->references(['id'])->on('sc_menu')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sc_menu_submenu', function (Blueprint $table) {
            $table->dropForeign('menu_submenu_fk');
        });
    }
}
