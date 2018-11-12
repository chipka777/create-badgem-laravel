<?php

namespace App\Http\Controllers\Auth;

use App\Services\SocialAccountService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Exception;
use Socialite;

class SocialLoginController extends Controller
{
    /**
     * Redirect the user to the needed authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information
     *
     * @param SocialAccountService $accountService
     * @param $provider
     * @return Response
     */
    public function handleProviderCallback(SocialAccountService $accountService, $provider)
    {
        try {
            $user = Socialite::with($provider)->user();
        } catch (Exception $e) {
            return redirect('/login');
        }

        $authUser = $accountService->findOrCreate(
            $user,
            $provider
        );

        if ($authUser === false) {
            return redirect('/login')->with('error', 'You must receive an invitation to register.');
        }

        auth()->login($authUser, true);

        return redirect()->to('/')->with('from', 'social');
    }
}