<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_menu', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 191);
            $table->string('url', 191)->nullable();
            $table->string('icon', 100)->nullable();
            $table->integer('item_order')->nullable()->unique('item_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sc_menu');
    }
}
