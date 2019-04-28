<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAcompanhamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acompanhamento', function (Blueprint $table) {
            $table->increments('acompanhamento_id');
            $table->date('data');
            $table->text('dataPorExtenso');
            $table->integer('peso')->nullable();
            $table->integer('altura')->nullable();
            $table->text('alimentacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acompanhamento');
    }
}
