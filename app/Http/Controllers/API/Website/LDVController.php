<?php

namespace App\Http\Controllers\API\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bulletin;

class LDVController extends Controller
{
    public function getHistory($count, $offset)
    {
        $bulletins = [];
        $count = 10;

        for ($i = 1; $i < 11; $i++) {
            $class = 'green';
            $symbol = '+';
            if ($i % 2 ) {
                $class = 'red';
                $symbol = '-';                
            }
            $bulletins[] = [
                'num' => $i,
                'data' => 'TXN #' . $i,
                'extra' => $symbol . '45 LDV',
                'class' => $class,
                'add_info' => true,
            ];
        }

        if ($offset > 10) {
            $bulletins = [];
            $count = 0;
        }
            
        return response()->json([
            'bulletins' => $bulletins,
            'count' => $count,
            'status' => 'OK'
        ]);
    }

    public function getValues()
    {
        $connection_c = curl_init();
        curl_setopt( $connection_c, CURLOPT_URL, 'https://api.coinmarketcap.com/v2/ticker/?limit=10' );
        curl_setopt( $connection_c, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $connection_c, CURLOPT_TIMEOUT, 20 );
        $json_return = curl_exec( $connection_c );
        curl_close( $connection_c );

        return $json_return;
    }
}
