<?php

namespace App\Http\Controllers\API\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BulletinController extends Controller
{
    public function getBulletins($count, $offset)
    {
        $data = [];

        $bulletins = [
            1  => 'bulletin 1',
            2  => 'bulletin 2',
            3  => 'bulletin 3',
            4  => 'bulletin 4',
            5  => 'bulletin 5',
            6  => 'bulletin 6',
            7  => 'bulletin 7',
            8  => 'bulletin 8',            
            9  => 'bulletin 9',            
            10 => 'bulletin 10',            
            11 => 'bulletin 11',                                    
        ];

        $counter = 0;

        for($i = $offset;$i < $count; $i++) {
            if (isset($bulletins[$i])){
                $counter++;                
                $data[$counter] = [];
                $data[$counter]['data'] = $bulletins[$i];
                $data[$counter]['num'] = $counter;
            } 
        }

        return response()->json([
            'bulletins' => array_values($data),
            'count'  => count($data),
            'status' => 'OK'
        ]);
    }
}
