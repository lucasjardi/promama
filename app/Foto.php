<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Crianca;

class Foto extends Model
{
    //
    protected $fillable = [
        'crianca',
        'mes',
        'url'
    ];
    protected $table = 'foto';

    public function crianca()
    {
    	return $this->belongsTo(Crianca::class, 'crianca', 'crianca_id');
    }
}
