<?php

namespace App\Http\Controllers\API\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Image;
use App\FavoritedImages;
use App\User;
use App\UserHistory;
use Illuminate\Support\Facades\Auth;


class ImagesController extends Controller
{
    public function getImagesByCount($category_id, $count, $offset)
    {
        if ($category_id == 'favorited') {
            $favorited = new FavoritedImages;
            $images = $favorited->imagesByUser(Auth::user()->id)
                        ->orderBy('id', 'desc')
                        ->offset($offset)
                        ->limit($count)
                        ->get()
                        ->map(function ($item){
                            $item->favorite = $item->checkIfFavorited();
                            return $item;
                        });

                       
        }else {
            $images = Image::where('approved', 1)
                ->where(function ($q) use ($category_id) {
                    if ($category_id != 'all') {
                        $q->where('cat_id', $category_id);
                    }
                })
                ->orderBy('id', 'desc')
                ->offset($offset)
                ->limit($count)
                ->get()->map(function ($item){
                    $item->favorite = $item->checkIfFavorited();
                    return $item;
                });
        }
       
        foreach($images as  $key => $image) {

            $image->user = ucfirst(User::find($image->user_id)->name);
            $image->num = $key + 1;
            $image->insta = 0;
        }

        return $images;
    }

    public function getImagesByCountAll($category_id, $count, $offset)
    {
        $user = Auth::user();

        if ($category_id == 'favorited') {
            $favorited = new FavoritedImages;
            $images = $favorited->imagesByUser($user->id)
                        ->orderBy('id', 'desc')
                        ->offset($offset)
                        ->limit($count)
                        ->get()
                        ->map(function ($item){
                            $item->favorite = $item->checkIfFavorited();
                            return $item;
                        });
                        
        }else {
            $images =  Image::
                where(function($query) use ($category_id) {
                    if ($category_id != 'all') $query->where('cat_id', $category_id);
                })
                ->orderBy('id', 'desc')
                ->offset($offset)
                ->limit($count)
                ->get()->map(function ($item){
                    $item->favorite = $item->checkIfFavorited();
                    return $item;
                });
        }


        return $images;
    }

    public function getImagesByUser($category_id, $count, $offset)
    {
        $user = Auth::user();

        if ($user->hasRole('administrator')) {
            return $this->getImagesByCountAll($category_id, $count, $offset);
        }
        
        $images =  Image::
            where(function($query) use ($category_id) {
                if ($category_id != 'all') $query->where('cat_id', $category_id);
            })
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->offset($offset)
            ->limit($count)
            ->get()->map(function ($item){
                $item->favorite = $item->checkIfFavorited();
                return $item;
            });

        return $images;
    }

    public function getCreations($count, $offset)
    {
        $query = Auth::user()->images();

        $images = $query->orderBy('id', 'desc')
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

    public function getFavorites($count, $offset)
    {
        $query = Auth::user()->favoriteImages();

        $images = $query->orderBy('id', 'desc')
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
    public function getCountByCategory($category_id)
    {
        if ($category_id == 'all') {
            $count = Image::count();
        }elseif($category_id == 'favorited') {
            $favorited = new FavoritedImages;
            $count = $favorited->imagesByUser(Auth::user()->id)->count();
        }else {
            $count = Image::where('cat_id', $category_id)->count();
        }

        $data = ['count' => $count];

        return $count;
    }

    public function getCountByUser($category_id)
    {
        if (Auth::user()->hasRole('administrator')) {
            return $this->getCountByCategory($category_id);
        }

        if ($category_id == 'all') {
            $count = Image::where('user_id', Auth::user()->id)->count();
        }elseif($category_id == 'favorited') {
            $favorited = new FavoritedImages;
            $count = $favorited->imagesByUser(Auth::user()->id)->count();
        }else {
            $count = Image::where('user_id', Auth::user()->id)->where('cat_id', $category_id)->count();
        }

        $data = ['count' => $count];

        return $count;
    }

    public function addToFavorite($id) 
    {
        if (FavoritedImages::where('user_id', Auth::user()->id)->where('image_id', $id)->count()) return false;

        Image::whereId($id)->increment('favorited');

        $image = Image::whereId($id)->first();

        $history = new UserHistory;

        $data = [
            'name' => $image->title,
            'author' => ucfirst(Auth::user()->meta->first_name) . ' ' . ucfirst(Auth::user()->meta->last_name),
            'id' => $image->user_id 
        ];

        $history->createFromTemplate('favorited', Auth::user(), $data);

        return FavoritedImages::create(['user_id' => Auth::user()->id, 'image_id' => $id]);
    }

    public function removeFromFavorite($id) 
    {
        Image::whereId($id)->decrement('favorited');
        
        $image = Image::whereId($id)->first();

        $history = new UserHistory;

        $data = [
            'name' => $image->title,
            'author' => ucfirst(Auth::user()->meta->first_name) . ' ' . ucfirst(Auth::user()->meta->last_name),
            'id' => $image->user_id 
        ];

        $history->createFromTemplate('unfavorited', Auth::user(), $data);

        $image = FavoritedImages::where('user_id', Auth::user()->id)
                ->where('image_id', $id)
                ->delete();

        if ($image instanceOf FavoritedImages) {
            return $image;
        } 

        return 0;
    }

    public function getImagesFromInstagram()
    {
        $panel = "";
        $access_token = '13912890.3a81a9f.e3b482cc330b4aa5abd41bf48d9c7272';
        $username = 'honeybadgem';
        $user_id = 3967824490;
        $return = $this->getInstagramDataByApi("https://api.instagram.com/v1/users/" . $user_id . "/media/recent?access_token=" . $access_token."");
        $counter = 0;
        $data = [];
        foreach ($return->data as $key => $post)
        {
            $entry = new \StdClass;
            $entry->id = $post->id;
            $entry->num = $key + 1;
            $entry->insta = 1;
            $entry->name = $post->images->standard_resolution->url;

            $data[] = $entry;
            /*
            if($counter<=9)
            {
                $panel .= "<div id='img-".$post->id."' class='panel pos".$counter." canva-img'><div class='caption'><h2></h2><h3></h3></div><img onmousedown='panelImg(event, $(this))' src=".$post->images->standard_resolution->url." /></div>";
            }
            else
            {
                $panel .= "<div id='img-".$post->id."' class='panel pos".$counter." hide_image canva-img'><div class='caption'><h2></h2><h3></h3></div><img onmousedown='panelImg(event, $(this))' src=".$post->images->standard_resolution->url." /></div>";
            }
            $counter++;*/
        }

       return $data ;
    }

    public function getInstagramDataByApi( $api_url )
    {
        $connection_c = curl_init();
        curl_setopt( $connection_c, CURLOPT_URL, $api_url );
        curl_setopt( $connection_c, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $connection_c, CURLOPT_TIMEOUT, 20 );
        $json_return = curl_exec( $connection_c );
        curl_close( $connection_c );
        return json_decode( $json_return );
    }
    
    public function createBadgemImage(Request $request)
    {
        $tmps = [];

        $cmd = "convert -size 1152x768 xc:white Badge.png \n "; 

        foreach ($request->images as $key => $image) {
            if (stristr($image['src'], 'http')) {
                copy($image['src'], "tmp_main_" . $image['width'] . $key . ".png");
                $image['src'] = "tmp_main_" . $image['width'] . $key . ".png";
                $tmps[] = "tmp_main_" . $image['width'] . $key . ".png";
            }
            exec("convert -resize x" . $image['height'] . " '" . $image['src'] . "' " . "'tmp_" . $image['width'] . $key . ".png'");
            $str = "composite \( -geometry +" . $image['left'] . "+" . $image['top'] . 
                    " -rotate " . $image['rotate'] . " " . "'tmp_" . $image['width'] . $key . ".png' \)" . " Badge.png Badge.png \n ";
            $cmd .= $str;

            $tmps[] = "tmp_" . $image['width'] . $key . ".png";
        }

            exec($cmd);

            foreach($tmps as $tmp) {
              exec("rm $tmp");
            }
    }

   
}

// 66.6 100 convert -size 1152x768 xc:white Badge.png composite -geometry +311.04+238.08 -rotate 60.007741981843 tmp_230.40.png Badge.png Badge.png composite -geometry +702.72+230.4 -rotate 0 tmp_230.41.png Badge.png Badge.png