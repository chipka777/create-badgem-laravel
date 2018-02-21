<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Image;
use App\FavoritedImages;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UserHistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:designer|administrator')->except('changePasswordShow','changePassword');
    }

    public function index()
    {
        $page = 'profile';
        $user = Auth::user();        
        $meta = $user->meta;
        
        $meta->image_count = Image::where('user_id', $user->id)->count();

        $meta->favorite_add = 0;

        $images = Image::where('user_id', $user->id)->get()->each(function ($item) use ($meta) {
            $meta->favorite_add += $item->favorited;
        });

        $meta->favorited_count = FavoritedImages::where('user_id', $user->id)->count();

        return view('admin.profile.index', compact('page','user','meta', 'histories'));
    }

   

    public function edit()
    {
        $page = 'profile';
        $user = Auth::user();        
        $meta = $user->meta;
        
        return view('admin.profile.edit', compact('page','user','meta'));        
    }

    public function store(Request $request) 
    {
        $user = Auth::user();

        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',            
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->email, 'email')
            ],
            'avatar' => 'image|mimes:jpg,png,gif,jpeg'
        ]);

        $userData = $request->only('name', 'email');
        $metaData = $request->except('name', 'email', '_token');

        if ($request->files->get('avatar')) {
            $path = public_path('upload/avatars/');
            $extension = $request->files->get('avatar')->guessExtension();
            $name = $this->getRandomName() . '.' . $extension;
            
            $request->files->get('avatar')->move($path, $name);
            $metaData['avatar'] = '/upload/avatars/' . $name;
        }

        $user->update($userData);
        $user->meta()->update($metaData);

        $history = new UserHistory;

        $history->createFromTemplate('edited-profile', $user);

        return back()->with('success', 'Profile successfully updated');
    }

    public function changePasswordShow()
    {
        $page = 'profile';
        
        return view('admin.profile.change-password', compact('page'));    
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'cur_password' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (Hash::check($request->cur_password , $user->password)) {
            $user->password = bcrypt($request->password);

            $user->save();

            return back()->with('success', 'Password changed successfully');
        } 
        return back()->withErrors(['password' => 'Invalid current password']);
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
