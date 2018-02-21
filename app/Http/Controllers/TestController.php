<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Category;
use Mail;
use App\User;

class TestController extends Controller
{
    public function test(Request $request)
    {
       var_dump($request->all());
    }
}
