<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    //
    protected $fillable = [
        'resposta_duvida',
        'resposta_texto',
        'resposta_paraTodos'
    ];
    
    protected $primaryKey = 'resposta_id';

    public function duvida()
    {
        return $this->hasOne(Duvida::class, 'resposta_duvida', 'duvida_id');
    }
}
