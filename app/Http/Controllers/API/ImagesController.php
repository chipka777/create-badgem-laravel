<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Image;

class ImagesController extends Controller
{
    public function getImagesByCount($category_id, $count, $offset)
    {
        if ($category_id == 'all') {
            return Image::where('approved', 1)
                ->orderBy('id', 'desc')
                ->offset($offset)
                ->limit($count)
                ->get();
        }
        return Image::where('approved', 1)
            ->where('cat_id', $category_id)
            ->orderBy('id', 'desc')
            ->offset($offset)
            ->limit($count)
            ->get();
    }
}
