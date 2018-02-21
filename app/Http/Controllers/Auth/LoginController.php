<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $validator = $this->validateLogin($request->all());

        if ($validator->fails()) {
            $this->incrementLoginAttempts($request);
            
            return json_encode(['status' => 'ERROR', 'errors' => $validator->errors()->first()]);
        }

        if ($this->attemptLogin($request) ) {
            return json_encode(['status' => 'OK']);
        }

        return json_encode(['status' => 'ERROR', 'errors' => trans('auth.failed')]);
        

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        /*if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }*/

    }

    public function validateLogin($request) {
        return Validator::make($request, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
    }

}
