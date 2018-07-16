<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DuvidaFrequente extends Model
{
    //

    protected $table = 'duvidas_frequentes';

    protected $fillable = [
      'titulo',
      'texto'
    ];

    public function links()
    {
        return $this->hasMany(Link::class, 'duvidafrequente', 'id');
    }
}
