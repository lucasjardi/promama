<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bairro extends Model
{
    //

    protected $fillable = [
      'bairro_nome'
    ];
    protected $table = 'bairro';
    protected $primaryKey = 'bairro_id';

}
