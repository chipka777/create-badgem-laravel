<?php

namespace App\Http\Controllers\API\History;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserHistory;
use App\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


class MainController extends Controller
{
    private $path = 'vendor.histories.';

    public function __construct()
    {
        $this->middleware('role:administrator|designer');

    }

    public function getByCount($offset, $count, $id)
    {
        $user = User::find($id);

        $query = $user->histories();
        

        $histories = $query->select(['content','name','created_at'])
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($count)
            ->get()
            ->map(function($item) {
                $item->html = view($this->path . $item->name, ['data' => json_decode($item->content), 'date' =>$item->created_at->diffForHumans()])->render();

                return $item;
            });

        $count = $user->histories()->count();
            
    
        return json_encode([
            'histories' => $histories,
            'count' => $count
        ]);
    }
}
