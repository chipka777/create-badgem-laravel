<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $fillable = [
        'name', 'price', 'story',
        'photo', 'type', 'sizes',
        'photo_wcloud', 'extra_images'
    ];
}
