<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'name', 'user_id', 'cat_id',
        'tags', 'title', 'approved',
        'favorited'
    ];

    public function checkIfFavorited()
    {
        if (Auth::guest()) return false;
        
        $favorited = new FavoritedImages;

        $images  = $favorited->where('image_id', $this->id)
                    ->where('user_id', Auth::user()->id)
                    ->count();

        return $images ? true : false;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
}
