<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Team;

class TeamController extends Controller
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
        $team = Team::offset($offset)
        ->limit($count)
        ->orderBy('created_at', 'desc')
        ->get();

        return json_encode([
            'team' => $team,
            'count' => Team::count(),
            'status' => 'Success',
        ]);
    }

    public function index()
    {
        $page = 'about';

        return view('admin.team.index', compact( 'page'));
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
        $type = $request->files->get('image')->getMimeType();

        if ($this->validateImage($type)) {
            $path = public_path('upload/team');
            $extension = $request->files->get('image')->guessExtension();
            $name = str_random(10) . '.png';            
            
            $request->files->get('image')->move($path, $name);

            $img = new \Imagick(realpath("upload/team/$name"));

            $wd = $img->getImageWidth();

            if ($wd > 400) exec("convert upload/team/$name -resize x400 upload/team/thumbs/$name");
            else exec("convert upload/team/$name upload/team/thumbs/$name");

            exec("convert clouds/cloud.png upload/team/thumbs/$name -gravity center -composite clouds/cloud.png -compose copyopacity -composite upload/team/thumbs/$name");
            exec("convert clouds/cloud-frame.png upload/team/thumbs/$name -geometry +30+10 -composite upload/team/thumbs/$name");

            $member = Team::create([
                'first_name'  => $request->firstName,
                'last_name'   => $request->lastName,
                'description' => $request->description,
                'image'       => $name,
            ]);

            return json_encode([
                'status' => 'success'
            ]);
        };

        return json_encode([
            'status' => 'error',
            'message' => 'Invalid image type. Acceptable: png, jpeg, svg, gif.'
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
        $member = Team::find($id);

        $status = false;

        if ($request->files->get('image')) {
            $type = $request->files->get('image')->getMimeType();

            if ($this->validateImage($type)) {
                $path = public_path('upload/team');
                $extension = $request->files->get('image')->guessExtension();
                $name = str_random(10) . '.png';            
                
                $request->files->get('image')->move($path, $name);

                $member->image = $name;

                $status = true;
            };

            if (!$status) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Invalid image type. Acceptable: png, jpeg, svg, gif.'
                ]);
            }
        }


        $member->update([
            'first_name'  => $request->firstName,
            'last_name'   => $request->lastName,
            'description' => $request->description,
            'image'       => $member->image,
        ]);

        return json_encode([
            'status' => 'success'
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
        $member = Team::find($id);

        $image = $member->image;

        if ($member->delete()) {

            exec("rm upload/team/$image");
            exec("rm upload/team/thumbs/$image");            

            return json_encode([
                'status' => 'success'
            ]);
        }

        return json_encode([
            'status' => 'error'
        ]);
    }

    private function validateImage($type) 
    {
        if ($type == 'image/png'     ||
            $type == 'image/gif'     ||
            $type == 'image/svg'     || 
            $type == 'image/svg+xml' || 
            $type == 'image/jpeg'    ||
            $type == 'image/jpg'
            ) return 1;
        return 0;
    }
}
