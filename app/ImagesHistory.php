<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagesHistory extends Model
{
    protected $table = "images_history";

    protected $fillable = [
        'id' , 'user_id', 'image_id', 'expires'
    ];

}
