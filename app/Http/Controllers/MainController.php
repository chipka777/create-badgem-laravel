<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Category;

class MainController extends Controller
{
    public function index()
    {
        $images = Image::where('approved', 1)->where('cat_id', 0)->limit(8)->get();
        $categories = Category::all();

        return view('main', compact('images', 'categories'));
    }
}
