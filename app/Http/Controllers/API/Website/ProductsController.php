<?php

namespace App\Http\Controllers\API\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductsController extends Controller
{
    public function getAllByCount($count, $offset)
    {
        $products = Product::offset($offset)
            ->limit($count)
            ->get()
            ->map(function ($product, $key) {
                $product->num = $key + 1;

                return $product;
            });


        return response()->json([
            'products' => $products,
            'count'  => Product::offset($offset)->limit($count)->count(),
            'status' => 'OK'
        ]);
    }

    public function getProductsByTypeAndCount($type, $count, $offset) 
    {
        $products = Product::where('type', $type)
            ->offset($offset)
            ->limit($count)
            ->get()
            ->map(function ($product, $key) {
                $product->num = $key + 1;

                return $product;
            });


        return response()->json([
            'products' => $products,
            'count'  => Product::where('type', $type)->offset($offset)->limit($count)->count(),
            'status' => 'OK'
        ]);
    }
}
