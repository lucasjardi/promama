<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateTableMarco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marco', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('crianca');
            $table->integer('marco')->default(0);
            $table->date('data');
            $table->text('dataPorExtenso');
            $table->text('extra');
            $table->timestamps();
            $table->foreign('crianca')
                   ->references('crianca_id')
                   ->on('crianca')
                   ->onDelete('cascade')
                   ->onUpdate('cascade');
            $table->foreign('marco')->references('id')->on('marco_relacao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marco');
    }
}
