<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posto extends Model
{
    //
    protected $fillable = [
        'posto_nome',
        'posto_endereco',
        'posto_telefone',
        'posto_bairro'
    ];

    protected $table = 'posto';
    protected $primaryKey = 'posto_id';

    public function bairro()
    {
        return $this->belongsTo(Bairro::class, 'posto_bairro', 'bairro_id');
    }

}
