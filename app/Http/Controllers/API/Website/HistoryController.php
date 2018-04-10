<?php

namespace App\Http\Controllers\API\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Image;
use Carbon\Carbon;

class HistoryController extends Controller
{
    public function getHistoryByCount($count, $offset)
    {
        $query = Auth::user()->imagesHistory();

        $images = $query->orderBy('expires', 'desc')
            ->offset($offset)
            ->limit($count)
            ->get()
            ->map(function ($image, $key) {
                $image->num = $key + 1;

                return $image;
            });

        $count = $query->count();

        return response()->json([
            'images' => $images,
            'count'  => $count,
            'status' => 'OK'
        ]);
    }


    public function setToHistory(Request $request)
    {
        $user = Auth::user();

        $image = Image::find($request->id);

        $prevImage = $user->imagesHistory()->where('image_id', $image->id)->first();

        $expires = Carbon::now()->addDay();

        if ($prevImage !== null) {
            $user->imagesHistory()->detach($prevImage->id);
        }

        if ($user->imagesHistory()->count() > 50) {
            $removeImage = $user->imagesHistory()->orderBy('expires')->first();

            $user->imagesHistory()->detach($removeImage->id);
        }
        

        return $user->imagesHistory()->attach($image->id, ['expires' => $expires]);
    }
}
