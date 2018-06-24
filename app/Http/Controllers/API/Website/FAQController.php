<?php

namespace App\Http\Controllers\API\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Faq;

class FAQController extends Controller
{
    public function getByCount($count, $offset)
    {
        $data = [];

        $query = Faq::offset($offset)
            ->limit($count)
            ->orderBy('created_at', 'desc');
        $faqs = $query->get()
            ->each(function ($faq, $key) use (&$data) {
                $data[$key] = [
                    'data' => $faq->question,
                    'extra' => $faq->answer,
                    'num' => $key +1,
                ];
            });

        return response()->json([
            'bulletins' => $data,
            'count'  => $query->count(),
            'status' => 'OK'
        ]);
    }
}
