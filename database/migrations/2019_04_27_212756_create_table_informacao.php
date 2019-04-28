<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInformacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informacao', function (Blueprint $table) {
            $table->increments('informacao_id');
            $table->string('informacao_titulo');
            $table->text('informacao_corpo');
            $table->string('informacao_autor')->nullable();
            $table->double('informacao_idadeSemanasInicio');
            $table->double('informacao_idadeSemanasFim')->nullable();
            $table->string('informacao_foto')->nullable();
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
        Schema::dropIfExists('informacao');
    }
}
