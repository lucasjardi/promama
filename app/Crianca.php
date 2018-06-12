<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crianca extends Model
{
    //
    protected $fillable = [
        'user_id',
        'crianca_primeiro_nome',
        'crianca_sobrenome',
        'crianca_dataNascimento',
        'crianca_sexo',
        'crianca_pesoAoNascer',
        'crianca_alturaAoNascer',
        'crianca_outrasInformacoes',
        'crianca_idade_gestacional',
        'crianca_tipo_parto'
    ];
    protected $table = 'crianca';
    protected $primaryKey = 'crianca_id';


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function marcos()
    {
        return $this->hasOne('App\Marco','crianca', 'crianca_id');
    }

    public function acompanhamentos()
    {
        return $this->hasMany('App\Acompanhamento','crianca', 'crianca_id');
    }

    public function fotos()
    {
        return $this->hasMany('App\Foto','crianca', 'crianca_id');
    }
}
