<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function handleCallback(Request $request)
    {
        var_dump($request->all());
    }
}
