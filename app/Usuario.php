<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    //

    protected $fillable = [
        'usuario_nome',
        'usuario_email',
        'usuario_senha',
        'usuario_parto',
        'usuario_idadeGestacional',
        'usuario_bairro',
        'usuario_postoSaude',
        'usuario_data_nascimento'
    ];

    protected $hidden = [
      'usuario_senha',
      'api_token',
    ];

    protected $primaryKey = 'usuario_id';
    protected $table = 'usuario';


    public function bairro()
    {
        return $this->belongsTo(Bairro::class, 'usuario_bairro', 'bairro_id');
    }

    public function posto()
    {
        return $this->belongsTo(Posto::class, 'usuario_postoSaude', 'bairro_id');
    }
}
