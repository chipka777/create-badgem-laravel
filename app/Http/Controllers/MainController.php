<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Category;
use Mail;
use App\User;

class MainController extends Controller
{
    public function index(Request $request)
    {
       /* $user = User::find(1);
        Mail::send('emails.registerCode', ['user' => $user], function ($m) use ($user) {
            $m->from('hello@app.com', 'Your Application');

            $m->to('illya.lopatko@gmail.com', $user->name)->subject('Your Reminder!');
        });*/

        return view('main');
    }
}
