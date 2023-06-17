<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScMenuSubmenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_menu_submenu', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('sc_menu_id')->index('menu_id');
            $table->integer('item_order')->nullable()->unique('item_order');
            $table->string('name', 200);
            $table->string('url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sc_menu_submenu');
    }
}
