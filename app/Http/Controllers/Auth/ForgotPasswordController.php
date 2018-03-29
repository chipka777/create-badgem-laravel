<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function recovery(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return json_encode(['status' => 'ERROR', 'errors' => $validator->errors()->first()]);
        }

        $email = $request->email;

        $user = User::where('email', $email)->first();

        if ($user !== null) {
            $password = str_random(10);

            $user->update([
                'password' => bcrypt($password)
            ]);

            Mail::send('emails.forgotPassword',['password' => $password], function ($m) use($user) {
                $m->from('support@badgem.com', 'Badgem ');
    
                $m->to($user->email, $user->name)->subject('New password');
            });
        }else {
            return json_encode([
                'status' => 'ERROR',
                'errors' => 'A user with such an email address does not exist'
            ]);
        }

        return json_encode(['status' => 'OK']);
    }
}
