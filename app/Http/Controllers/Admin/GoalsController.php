<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Goal;

class GoalsController extends Controller
{
    public function __construct() 
    {
        $this->middleware('role:administrator');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getByCount($count, $offset)
    {
        $goals = Goal::offset($offset)
        ->limit($count)
        ->orderBy('created_at', 'desc')
        ->get();

        return json_encode([
            'faq' => $goals,
            'count' => Goal::count(),
            'status' => 'Success',
        ]);
    }

    public function index()
    {
        $page = 'about';

        return view('admin.goals.index', compact( 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Goal::create($request->all())) {
            return json_encode([
                'status' => 'success'
            ]);
        }

        return json_encode([
            'status' => 'error'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $goal = Goal::find($id);

        if ($goal->update($request->all())) {
            return json_encode([
                'status' => 'success'
            ]);
        }

        return json_encode([
            'status' => 'error'
        ]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Goal::find($id)->delete()) {
            return json_encode([
                'status' => 'success'
            ]);
        }

        return json_encode([
            'status' => 'error'
        ]);

    }
}
