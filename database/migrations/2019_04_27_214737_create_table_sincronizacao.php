<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSincronizacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sincronizacao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('informacao')->default(0);
            $table->integer('notificacao');
            $table->integer('bairro');
            $table->integer('posto');
            $table->integer('duvidas_frequentes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sincronizacao');
    }
}
