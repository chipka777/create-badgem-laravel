<?php

namespace App\Http\Controllers\API\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bulletin;

class BulletinController extends Controller
{
    public function getBulletins($count, $offset)
    {
        $bulletins = Bulletin::offset($offset)
            ->limit($count)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item, $key) {
                $item->num = $key + 1;
                $item->data = $item->name;
                $item->extra = $item->description;

                return $item;
            });
            

        return response()->json([
            'bulletins' => $bulletins,
            'count' => Bulletin::offset($offset)->limit($count)->count(),
            'status' => 'OK'
        ]);
    }
}
