<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Mail;
use App\User;
use App\UserInvites;
use App\UserMeta;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',            
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'invite_code' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data, $invite)
    {
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'verify_code' => strtoupper(str_random(40)),
        ]);
        $user->settings()->create([
            'invited_by' => $invite->user_id,
            'invites' => 10
        ]);

        $user->meta()->create([
            'user_id' => $user->id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'], 
        ]);

        $user->attachRole('consumer');

        return $user;
    }
    
    public function register(Request $request) {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return json_encode(['status' => 'ERROR', 'errors' => $validator->errors()->first()]);
        }

        $userInvite = UserInvites::where('email', $request->email)
            ->where('code', $request->invite_code)
            ->first();

        if ($userInvite === null) {
            return json_encode(['status' => 'ERROR', 'errors' => 'Invalid invitation code']);            
        }

        $user = $this->create($request->all(), $userInvite);

        UserInvites::where('email', $request->email)
            ->where('code', $request->invite_code)
            ->delete();

        session(['user' => $user]);

        $this->sendActivationMail($user);

        // Sending email, sms or doing anything you want
        //$this->activationService->sendActivationMail($user);

        return json_encode(['status' => 'OK']);
    }

    public function sendActivationMail($user) {
        Mail::send('emails.registerCode',['user' => $user], function ($m) use($user) {
                $m->from('register@badgem.com', 'Badgem ');
    
                $m->to($user->email, $user->name)->subject('Register code');
        });
    }

    public function activate(Request $request) {
        $code = $request->code;
        $user = session('user');

        if ($code == $user->verify_code) {
            $user->activated = 1;
            $user->save();
            session()->pull('user');
        } else {
            return json_encode(['status' => 'ERROR']);
        }

        return json_encode(['status' => 'OK']);
      
    }
}
