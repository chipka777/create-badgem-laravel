<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Video;

class VideoController extends Controller
{
    const PUBLIC_DIR = 'upload/videos/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'videos';

        return view('admin.video.index', compact('page'));
    }

    public function getByCount($count, $offset)
    {
        $videos = Video::offset($offset)
            ->limit($count)
            ->orderBy('created_at', 'desc')
            ->get();

        return json_encode([
            'videos' => $videos,
            'count' => Video::count(),
            'status' => 'Success',
        ]);
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
        $thumbnail = false;
        
        if(is_string($request->thumbnail)){
            $rules = 'required|string';
        } else {
            $thumbnail = true;
            $rules = 'required|mimes:jpeg,jpg,png,gif';
        }
        $validator = Validator::make($request->all(), [
            'thumbnail' => $rules,
            'name'  => 'required|string|max:255',
            'video_id' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        if (!$thumbnail) {
            $thumbnail = $this->getThumbnailByApi($request->video_id);

            if ($thumbnail === false) {
                return response()->json([
                    'message' => 'Could not get the thumbnail using API, please upload manually',
                ], 422);
            }
        } else {
            $thumbnail = $this->saveImage($request);
        }

        Video::create([
            'name' => $request->name,
            'video_id' => $request->video_id,
            'thumbnail' => $thumbnail
        ]);

        return response()->json([
            'success' => true
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
        $thumbnail = false;

        if(is_string($request->thumbnail)){
            $rules = 'required|string';
        } else {
            $thumbnail = true;
            $rules = 'required|mimes:jpeg,jpg,png,gif';
        }
        $validator = Validator::make($request->all(), [
            'thumbnail' => $rules,
            'name'  => 'required|string|max:255',
            'video_id' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }
        $video = Video::find($id);
        $delete = false;

        if (!$thumbnail && $request->thumbnail === 'api') {
            $thumbnail = $this->getThumbnailByApi($request->video_id);

            if ($thumbnail === false) {
                return response()->json([
                    'message' => 'Could not get the thumbnail using API, please upload manually',
                ], 422);
            } else {
                $delete = true;
            }
        } elseif ($thumbnail === true) {
            $thumbnail = $this->saveImage($request);
            $delete = true;            
        } else {
            $thumbnail = $video->thumbnail;
        }

        $path = $this::PUBLIC_DIR . basename($video->thumbnail);

        $video->update([
            'name' => $request->name,
            'video_id' => $request->video_id,
            'thumbnail' => $thumbnail
        ]);

        if ($delete) {
            exec("rm $path");            
        }

        return response()->json([
            'success' => true
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
        $video = Video::find($id);
        $path = $this::PUBLIC_DIR . basename($video->thumbnail);

        exec("rm $path");
        $video->delete();

        return response()->json([
            'success' => true
        ]);
    }

    private function getThumbnailByApi($videoID) 
    {
        $hqSource = "https://img.youtube.com/vi/$videoID/hqdefault.jpg";
        $mqSource = "https://img.youtube.com/vi/$videoID/mqdefault.jpg";
        $source = "https://img.youtube.com/vi/$videoID/default.jpg";     
        
        $name = 'upload/videos/' . md5(time() . $videoID) . '.png';

        try {
            if (copy($hqSource, $name)) {
                return asset($name);
            }

            if (copy($mqSource, $name)) {
                return asset($name);
            }

            if (copy($source, $name)) {
                return asset($name);
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    private function saveImage($request)
    {
        $path = public_path($this::PUBLIC_DIR);
        $name = md5(time()) . '.png';            
        
        $request->files->get('thumbnail')->move($path, $name);
        
        $img = new \Imagick(realpath($this::PUBLIC_DIR . $name));

        $wd = $img->getImageWidth();

        if ($wd > 400) {
            exec("convert " . $this::PUBLIC_DIR . "$name -resize x400 " . $this::PUBLIC_DIR . "$name");
        } 

        return asset($this::PUBLIC_DIR . $name);
    }
}
