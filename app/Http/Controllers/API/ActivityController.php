<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ActivityController extends Controller
{
    public function setActivity()
    {
        Session::put('activity',Carbon::now());        
    }

    public function checkActivity()
    {
        $lastActivity = Session::get('activity');

        if ($lastActivity instanceof Carbon) {
            $differenceTimestamp = Carbon::now()->timestamp - $lastActivity->timestamp;

            if ($differenceTimestamp > 890) {
                Auth::logout();

                return json_encode([
                    'status' => 'logout'
                ]);
            }
        }

        return json_encode([
            'status' => 'OK'
        ]);
    }
}
