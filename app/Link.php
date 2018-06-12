<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    //

	public $timestamps = false;

    protected $table = 'link';

    protected $fillable = [
    	'informacao',
    	'titulo',
    	'url'
    ];
}
