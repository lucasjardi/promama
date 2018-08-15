<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Termo extends Model
{
    protected $fillable = [
        'titulo',
        'texto'
    ];

    public $timestamps = false;
}
