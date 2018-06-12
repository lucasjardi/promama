<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    //
    public $timestamps = false;
   	protected $fillable = [
   		'titulo',
   		'texto',
   		'semana'
   	];
    protected $table = 'notificacao';
}
