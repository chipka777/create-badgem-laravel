<?php

namespace App\Http\Controllers\API\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Video;

class VideoController extends Controller
{
    public function getByCount($count, $offset)
    {

        $videos = Video::orderBy('id', 'desc')
            ->offset($offset)
            ->limit($count)
            ->get()
            ->map(function ($video, $key) {
                $video->num = $key + 1;

                return $video;
            });


        return response()->json([
            'images' => $videos,
            'count'  => Video::offset($offset)->limit($count)->count(),
            'status' => 'OK'
        ]);
    }
}
