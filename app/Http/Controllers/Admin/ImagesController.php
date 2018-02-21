<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Image;
use App\FavoritedImages;
use App\UserHistory;
use App\Category;
use Illuminate\Support\Facades\Auth;


class ImagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:designer|administrator')->except('showAll');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'images';

        return view('admin.images.edit', compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = 'images';

        return view('admin.images.create', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $cat_id)
    {
        if (Auth::user()->hasRole('designer')){
            $cat = Category::where('user_id', Auth::user()->id)->first();
            if (!$cat || $cat_id != $cat->id) {
                return response()->json("Please create your category", 415);
            }
        }
        $type = $request->files->get('image')->getMimeType();

        $valid = $this->validateImage($type);
        $original_name = $request->files->get('image')->getClientOriginalName();
        if ($valid) {
            $path = public_path('upload');
            $extension = $request->files->get('image')->guessExtension();
            $name = $this->getRandomName() . '.' . $extension;
            
            $request->files->get('image')->move($path, $name);
           
            $img = new \Imagick(realpath("upload/$name"));

            $wd = $img->getImageWidth();

            if ($wd > 400) exec("convert upload/$name -resize x400 upload/thumbs/$name");
            else exec("convert upload/$name upload/thumbs/$name");
         
            $image = new Image;

            $image->name = $name;
            $image->user_id = \Auth::user()->id;
            $image->tags = '';
            $image->title = $original_name;
            $image->approved = 1;
            if ($cat_id == 'all') $image->cat_id = 0;
            else $image->cat_id = $cat_id;

            if ($image->save()) {
                $history = new UserHistory;

                $data = [
                    'name' => $image->title,
                ];
        
                $history->createFromTemplate('uploaded', Auth::user(), $data);

                return ['id' => $image->id, 'name' => $name]; 
            } 
            else return  response()->json("Error with Database", 412);
        }

      
        
        return response()->json("$original_name : Invalid image type. Acceptable: png, jpeg, svg, gif.", 415);

    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Image::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $image = Image::find($id);

        if ($image->approved) $image->approved = 0;

        else $image->approved = 1;

        $image->update();

        return $image;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $img = Image::find($id);
        
        $name = $img->name;

        $data = [
            'name' => $img->title,
        ];

        if ($img->destroy($id)) {
            exec("rm upload/$name");
            exec("rm upload/thumbs/$name");

            FavoritedImages::where('image_id', $id)->delete();

            $history = new UserHistory;

            $history->createFromTemplate('removed', Auth::user(), $data);
        }
        return 1;
    }

    public function showAll()
    {
        $page = 'images';

        return view('admin.images.show', compact('page'));
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

    private function getRandomName($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    
}
