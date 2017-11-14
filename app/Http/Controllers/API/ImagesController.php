<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Image;

class ImagesController extends Controller
{
    public function getImagesByCount($category_id, $count, $offset)
    {
        if ($category_id == 'all') {
            $images =  Image::where('approved', 1)
                ->orderBy('id', 'desc')
                ->offset($offset)
                ->limit($count)
                ->get();
        }else {
            $images = Image::where('approved', 1)
                ->where('cat_id', $category_id)
                ->orderBy('id', 'desc')
                ->offset($offset)
                ->limit($count)
                ->get();
        }

        foreach($images as  $key => $image) {
            $image->num = $key + 1;
            $image->insta = 0;
        }

        return $images;
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
            exec("convert -resize " . $image['width'] . "x " . $image['src'] . " " . "tmp_" . $image['width'] . $key . ".png");
            $str = "composite \( -geometry +" . $image['left'] . "+" . $image['top'] . 
                    " -rotate " . $image['rotate'] . " " . "tmp_" . $image['width'] . $key . ".png \)" . " Badge.png Badge.png \n ";
            $cmd .= $str;

            $tmps[] = "tmp_" . $image['width'] . $key . ".png";
        }

            exec($cmd);

            foreach($tmps as $tmp) {
              exec("rm $tmp");
            }
    }
}

//convert -size 1152x768 xc:white Badge.png composite -geometry +311.04+238.08 -rotate 60.007741981843 tmp_230.40.png Badge.png Badge.png composite -geometry +702.72+230.4 -rotate 0 tmp_230.41.png Badge.png Badge.png