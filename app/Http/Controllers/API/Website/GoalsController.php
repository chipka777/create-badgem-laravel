<?php

namespace App\Http\Controllers\API\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Goal;

class GoalsController extends Controller
{
    public function getGoals($count, $offset)
    {
        $data = [];

        $query = Goal::offset($offset)
            ->limit($count)
            ->orderBy('created_at', 'desc');
        $goals = $query->get()
            ->each(function ($goal, $key) use (&$data) {
                $data[$key] = [
                    'data' => $goal->name,
                    'extra' => $goal->description,
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
