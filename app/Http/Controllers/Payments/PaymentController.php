<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function handleCallbackGet(Request $request)
    {
        $string = $request->all();
        file_put_contents('paymentGet.txt', 'GET: ' . http_build_query($string));
    }

    public function handleCallbackPost(Request $request)
    {
        $string = $request->all();
        file_put_contents('paymentPost.txt', 'POST: ' . http_build_query($string));
    }
    
    public function handleCallbackGet1($url = 'node.chase-barnes.com/payment')
    {
        $fields = [
            "eth_address" => "0x1E116fD224b9185dB17DC47AC32CA30A141F67aC",
            "amount" => "1", 
            "description" => "Test request"
        ];
		$data_string = json_encode($fields);        

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data_string); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		); 
        $response = curl_exec($ch);

        curl_close($ch);
        echo $response;
        file_put_contents('paymentPost.txt', 'POST: ' . $response);

        //var_dump($response);

    }

    public function testPayment(Request $request)
    {
        $basket = Session::get('basket') !== null ? Session::get('basket') : [];
        $url = 'node.chase-barnes.com/payment';

        $amount = 0;

        foreach($basket as $product) {
            $amount += $product['price'] * $product['count'];
        }

        $orderId = str_random(5);

        $fields = [
            "eth_address" => $request->ethaddres,
            "amount" => $amount * 100, 
            "description" => "Order ID : $orderId"
        ];
		$data_string = json_encode($fields);        

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data_string); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		); 
        $response = curl_exec($ch);

        curl_close($ch);
        echo $response;
    }
}
