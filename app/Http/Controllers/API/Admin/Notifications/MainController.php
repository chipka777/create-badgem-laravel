<?php

namespace App\Http\Controllers\API\Admin\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\UserNotification;


class MainController extends Controller
{
    public function getByCount($offset, $count)
    {
        $user = Auth::user();

        $role = $user->roles()->first()->name;

        $notifications = UserNotification::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->offset($offset)
            ->limit($count)
            ->get();

        $count = UserNotification::where('user_id', $user->id)
                    ->where('read', 0)
                    ->count();
    
        return json_encode([
            'notifications' => $notifications,
            'count' => $count
        ]);
    }

    public function setAsRead()
    {
        $user = Auth::user();

        UserNotification::where('user_id', $user->id)
            ->update(['read' => 1]);
    }
}
