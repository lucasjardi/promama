<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('informacao');
            $table->string('titulo');
            $table->text('url');
            $table->integer('duvidafrequente')->nullable();
            $table->timestamps();
            $table->foreign('duvidafrequente')->references('id')->on('duvidas_frequentes');
            $table->foreign('informacao')
                   ->references('informacao_id')
                   ->on('informacao')
                   ->onDelete('cascade')
                   ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link');
    }
}
