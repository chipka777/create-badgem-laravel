<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoriesController extends Controller
{
    public function getAll($paginate = 0)
    {
       return Category::all();
    }

    public function getAllVisibility()
    {
       return Category::where('visibility',1)->get();
    }
}
