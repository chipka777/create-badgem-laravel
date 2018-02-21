<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:consumer')->only('becomeDesigner', 'activateDesigner');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'dashboard';
        return view('admin.index', compact('page'));
    }

    public function favorite()
    {
        $page = 'favorite';
        return view('admin.favorite', compact('page'));
    }

    public function becomeDesigner()
    {
        $page = 'become-designer';
        return view('admin.become-designer', compact('page'));
    }

    public function activateDesigner(Request $request)
    {
        $code = e($request->invite_code);

        $user = Auth::user();

        if ($user->invite_code == $code) {
            $user->detachRole('consumer');
            $user->attachRole('designer');

            $user->invite_code = NULL;

            $user->save();

            return redirect('/dashboard')->with('activate_invite', 'Congratulations! You became a Designer.');            
        }

        return back()->with('error', 'Invalid invitation code');

        
    } 
  
}
