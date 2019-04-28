<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFaleConosco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fale_conosco', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user');
            $table->text('pergunta');
            $table->text('resposta');
            $table->tinyInteger('paraTodos');
            $table->timestamps();
            $table->foreign('user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fale_conosco');
    }
}
