<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idade extends Model
{
    //
    public $timestamps = false;
    protected $table = 'idades';
    protected $fillable = [
    	'idade',
    	'semanas'
    ];
}
