<?php

namespace App\Services;

use App\LinkedSocialAccount;
use App\User;
use App\UserInvites;

class SocialAccountService
{
    const DEFAULT_EMAIL = 'default@defMail.mail';

    public function findOrCreate($providerUser, $provider)
    {
        $account = $this->getLinkedSocialAccountByProviderName($provider, $providerUser);

        if ($account) {
            return $account->user;
        }

        $user = $this->getUserByUserProvider($providerUser);

        if (!$user) {
            $email = $providerUser->getEmail();

            if ($email === null) {
                $email = self::DEFAULT_EMAIL;
            }

            if (UserInvites::where('email', $email)->first() === null) {
                return false;
            }

            $user = $this->createUser($providerUser);
        }


        $this->createUserAccount($user, $providerUser, $provider);

        return $user;
    }

    /**
     * @param $providerName
     * @param $providerUser
     * @return LinkedSocialAccount|null
     * @codeCoverageIgnore
     */
    public function getLinkedSocialAccountByProviderName($providerName, $providerUser)
    {
        return LinkedSocialAccount::where('provider_name', $providerName)
            ->where('provider_id', $providerUser->getId())
            ->first();
    }

    /**
     * @param $providerUser
     * @return User|null
     * @codeCoverageIgnore
     */
    public function getUserByUserProvider($providerUser)
    {
        return User::where('email', $providerUser->getEmail())->first();
    }

    /**
     * @param  $providerUser
     * @codeCoverageIgnore
     */
    public function createUser($providerUser)
    {
        $email = $providerUser->getEmail();

        if ($email === null) {
            $email = self::DEFAULT_EMAIL;
        }

        $invite = UserInvites::where('email', $email)->first();

        $user = User::create([
            'email' => $email,
            'name' => $providerUser->getName(),
            'password' => bcrypt(md5(rand(1, 100) . $providerUser->getName())),
            'activated' => 1,
            'verify_code' => ''
        ]);

        $user->settings()->create([
            'invited_by' => $invite->user_id,
            'invites' => 10,
            'avatar' => isset($providerUser->avatar) ? $providerUser->avatar : $providerUser->image['url']
            
        ]);

        $user->attachRole('consumer');

        return $user;
    }

    /**
     * @param User $user
     * @param $providerUser
     * @param $providerName
     * @return \Illuminate\Database\Eloquent\Model
     * @codeCoverageIgnore
     */
    public function createUserAccount(User $user, $providerUser, $providerName)
    {
        return $user->accounts()->create([
            'provider_id' => $providerUser->getId(),
            'provider_name' => $providerName,
        ]);
    }
}