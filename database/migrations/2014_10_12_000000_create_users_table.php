<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('bairro')->nullable();
            $table->integer('posto_saude')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('api_token');
            $table->text('senha_reserva');
            $table->string('foto_url')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('bairro')->references('bairro_id')->on('bairro');
            $table->foreign('posto_saude')->references('id')->on('posto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
