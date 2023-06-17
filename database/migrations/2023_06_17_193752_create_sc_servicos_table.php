<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_servicos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('servico', 250);
            $table->decimal('valor', 10);
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
        Schema::dropIfExists('sc_servicos');
    }
}
