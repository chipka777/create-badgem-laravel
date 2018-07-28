<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];
    
    protected $table = 'bulletins';
}
