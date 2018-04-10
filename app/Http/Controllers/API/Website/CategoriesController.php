<?php

namespace App\Http\Controllers\API\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    public function getAll($paginate = 0)
    {
        if (Auth::user()->hasRole('administrator')) return Category::all();
        
        return Category::where('user_id', Auth::user()->id)->get();
    }

    public function getAllVisibility()
    {
       return Category::where('visibility',1)->get();
    }
}
