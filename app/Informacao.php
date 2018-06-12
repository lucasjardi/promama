<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Informacao extends Model
{
    //
    protected $fillable = [
        'informacao_titulo',
        'informacao_corpo',
        'informacao_data',
        'informacao_autor',
        'informacao_idadeSemanasInicio',
        'informacao_idadeSemanasFim',
        'informacao_foto',
    ];
    protected $table = 'informacao';
    protected $primaryKey = 'informacao_id';


    public function links()
    {
        return $this->hasMany(Link::class, 'informacao', 'informacao_id');
    }
}
