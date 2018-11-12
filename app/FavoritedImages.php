<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoritedImages extends Model
{
    protected $table = 'favorited_images';

    protected $fillable = ['id','user_id','image_id'];

    public function imagesByUser($userId) 
    {
        $favorites =  $this->where('user_id', $userId)->get()
                        ->map(function ($item) {
                            return $item->image_id;
                        });

        $images = Image::whereIn('id', $favorites)->where('approved', 1);
        return $images;
    }

}
