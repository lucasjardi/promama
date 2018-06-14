<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Duvida extends Model
{
    //

    protected $table = 'fale_conosco';

    protected $fillable = [
      'pergunta'
    ];

    // protected $primaryKey = 'duvida_id';

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

}
