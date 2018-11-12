<?php

namespace App\Http\Controllers\API\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BasketController extends Controller
{
    public function addToCart(Request $request)
    {
        $basket = Session::get('basket') !== null ? Session::get('basket') : [];
        $basket[] = $request->data;
        Session::put('basket', $basket);    
    }

    public function getProducts()
    {
        return response()->json([
            'products' => array_values(Session::get('basket') !== null ? Session::get('basket') : [])
        ]);
    }

    public function getProductsImages()
    {
        $images = '';

        foreach(Session::get('basket') as $product) {
            $images .= asset($product['photo']) . ',';
        }

        return response()->json([
            'images' => rtrim($images, ',')
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $basket = Session::get('basket') !== null ? Session::get('basket') : [];

        foreach($basket as $key => $product) {
            if ($product['id'] == $request->id) {
                unset($basket[$key]);
                break;
            }
        }
        Session::put('basket', array_values($basket));    
    }

    public function update(Request $request) 
    {
        $basket = Session::get('basket') !== null ? Session::get('basket') : [];

        foreach($basket as $key => $product) {
            if ($product['id'] == $request->id) {
                $basket[$key]['count'] = $request->count;
                break;
            }
        }
        Session::put('basket', array_values($basket));  
    }
}
