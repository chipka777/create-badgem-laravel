<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class BitcoinController extends Controller
{
    public function getTicker()
    {
        $connection_c = curl_init();
        curl_setopt( $connection_c, CURLOPT_URL, 'https://www.bitstamp.net/api/ticker/' );
        curl_setopt( $connection_c, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $connection_c, CURLOPT_TIMEOUT, 20 );
        $json_return = curl_exec( $connection_c );
        curl_close( $connection_c );
        return $json_return;
    }
}
