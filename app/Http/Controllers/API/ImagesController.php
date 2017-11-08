<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Image;

class ImagesController extends Controller
{
    public function getImagesByCount($category_id, $count, $offset)
    {
        return Image::where('approved', 1)
            ->where('cat_id', $category_id)
            ->offset($offset)
            ->limit($count)
            ->get();
    }
}
