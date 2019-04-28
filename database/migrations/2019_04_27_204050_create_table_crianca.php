<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprinteger;
use Illuminate\Database\Migrations\Migration;

class CreateTableCrianca extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crianca', function (Blueprinteger $table) {
            $table->increments('crianca_id');
            $table->unsignedintegereger('user_id');
            $table->string('crianca_primeiro_nome');
            $table->string('crianca_sobrenome')->nullable();
            $table->date('crianca_dataNascimento');
            $table->integer('crianca_sexo');
            $table->integer('crianca_pesoAoNascer')->nullable();
            $table->integer('crianca_alturaAoNascer')->nullable();
            $table->text('crianca_outrasInformacoes')->nullable();
            $table->integer('crianca_idade_gestacional')->nullable();
            $table->integer('crianca_tipo_parto')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crianca');
    }
}
