<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acompanhamento extends Model
{
    //

    protected $fillable = [
      'crianca',
      'data',
      'peso',
      'altura',
      'alimentacao'
    ];
    protected $table = 'acompanhamento';
}
