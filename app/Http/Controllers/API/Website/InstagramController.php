<?php

namespace App\Http\Controllers\API\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InstagramController extends Controller
{
    private $clientId = '109b7d98f71a41f0aa9ebd7ad2bb3cfb';

    private $clientSecret = 'd9c075774516412fbb76c7358390ce75';

    private $redirectUri = 'http://badgem.app/instagram-auth/';

    private $accessToken = '6790854258.109b7d9.d793f54537f84311a4100b24fbcd9d3c"';

    private $token = null;

    public function getImages(Request $request)
    {
        $dataUrl = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=6790854258.109b7d9.d793f54537f84311a4100b24fbcd9d3c';

        $url = "https://api.instagram.com/oauth/authorize/?client_id=" . $this->clientId . "&redirect_uri=" . $this->redirectUri . "&response_type=token";
        
        $newurl = "https://www.instagram.com/oauth/authorize/?redirect_uri=" . $this->redirectUri . "&response_type=code&scope=basic&client_id=109b7d98f71a41f0aa9ebd7ad2bb3cfb";

 
        $this->getDataFromUrl($url);
        
    }

    public function authCallback(Request $request)
    {
        var_dump($request->all());
    }

    private function getDataFromUrl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);

        curl_close($ch);

        var_dump($response);
    }
}
