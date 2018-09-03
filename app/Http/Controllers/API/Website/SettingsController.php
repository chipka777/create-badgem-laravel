<?php

namespace App\Http\Controllers\API\Website;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class SettingsController extends Controller
{
    public function changeAge(Request $request)
    {
        if (Auth::user()->settings === null) {
            Auth::user()->settings()->create([
                'age' => Carbon::createFromFormat('m-d-Y', $request->date)->format('m-d-Y')
            ]);
        } else {
            Auth::user()->settings()->update([
                'age' => Carbon::createFromFormat('m-d-Y', $request->date)->format('m-d-Y')
            ]);
        }

        return response()->json([
            'age' => Carbon::createFromFormat('m-d-Y', $request->date)->age,
            'status' => 'OK'
        ]);
    }

    public function changeName(Request $request)
    {
        Auth::user()->update([
            'name' => $request->name
        ]);


        return response()->json([
            'name' => $request->name,
            'status' => 'OK'
        ]);
    }

    public function changeBio(Request $request)
    {
        if (Auth::user()->settings === null) {
            Auth::user()->settings()->create([
                'bio' => $request->bio
            ]);
        } else {
            Auth::user()->settings()->update([
                'bio' => $request->bio
            ]);
        }

        return response()->json([
            'bio' => $request->bio,
            'croppBio' => str_limit($request->bio, 100, '...'),          
            'status' => 'OK'
        ]);
    }

    public function changeAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|mimes:jpeg,jpg,png,gif|dimensions:max_width=600,max_height=600',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }
        $path = public_path('upload/avatars/');
        $extension = $request->files->get('avatar')->guessExtension();
        $name = md5(time()) . '.png';            
        
        $request->files->get('avatar')->move($path, $name);

        if (Auth::user()->settings === null) {
            Auth::user()->settings()->create([
                'avatar' => $name
            ]);
        } else {
            Auth::user()->settings()->update([
                'avatar' => $name
            ]);
        }

        return response()->json([
            'avatar' => $name,
            'status' => 'OK'
        ]);
    }
}
