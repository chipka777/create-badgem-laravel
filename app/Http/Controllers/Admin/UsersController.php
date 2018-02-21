<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserHistory;
use App\UserNotification;
use App\Image;
use App\FavoritedImages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator')->except('showProfile');

    }
    public function index()
    {
        $page = 'users';
        
        $users = User::paginate(15);

        return view('admin.users', compact('page', 'users'));
    }

    

    public function showProfile($id)
    {
        $page = 'profile';
        $user = User::find($id);        
        $meta = $user->meta;

        $meta->image_count = Image::where('user_id', $user->id)->count();

        $meta->favorite_add = 0;

        $images = Image::where('user_id', $user->id)->get()->each(function ($item) use ($meta) {
            $meta->favorite_add += $item->favorited;
        });

        $meta->favorited_count = FavoritedImages::where('user_id', $user->id)->count();

        return view('admin.profile.index', compact('page','user','meta'));
    }

    public function edit($id)
    {
        $page = 'profile';
        $user = User::find($id);        
        $meta = $user->meta;
        
        return view('admin.profile.edit', compact('page','user','meta'));        
    }

    public function store(Request $request, $id) 
    {
        $user = User::find($id);

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

    public function sendInvite(Request $request)
    {
        $user = User::find($request->id);

        if ($user->invite_code != NULL && !$request->resend) {
            return json_encode(['status' => 'repeat', 'message' => 'You have already sent an invitation to this user. Please refresh page.']);
        }

        $user->invite_code = strtoupper(str_random(40));

        if ($user->save()) {
            Mail::send('emails.inviteDesigner',['user' => $user], function ($m) use($user) {
                $m->from('administrator@badgem.com', 'Badgem ');
    
                $m->to($user->email, $user->name)->subject('Invite code');
            });

            if (Mail::failures()) {
                $user->invite_code = NULL;
                $user->save();

                return json_encode(['status' => 'error', 'message' => 'The invitation was not sent, the problem with sending the email']);                
            }

        
            $notification = new UserNotification;
            
            $notification->send($user, 'Designer Invite', 'You were invited as a designer, please check your email');

            return json_encode(['status' => 'success', 'message' => 'Invitation was successfully sent']);                
        }

        return json_encode(['status' => 'error', 'message' => 'The invitation was not sent, the problem with database']);                
    }

    
}

