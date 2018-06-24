<?php

namespace App\Http\Controllers\API\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Team;

class TeamController extends Controller
{
    public function getTeamMembers($count, $offset)
    {
        $data = [];

        $query = Team::offset($offset)
            ->limit($count)
            ->orderBy('created_at', 'desc');

        $team = $query->get()
            ->map(function ($member, $key) use (&$data) {
                $member->num = $key + 1;

                return $member;
            });

        return response()->json([
            'bulletins' => $team,
            'count'  => $query->count(),
            'status' => 'OK'
        ]);
    }
}
