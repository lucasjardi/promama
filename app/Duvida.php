<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Duvida extends Model
{
    //

    protected $fillable = [
      'duvida_pergunta'
    ];

    protected $primaryKey = 'duvida_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'duvida_user', 'id');
    }

}
