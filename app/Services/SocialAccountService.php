<?php

namespace App\Services;
use App\Models\SocialAuth;
use App\Models\Subscriptions;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService {
	public function createOrGetUser(ProviderUser $providerUser) {
		$account = SocialAuth::whereProvider('facebook')
			->whereProviderUserId($providerUser->getId())
			->first();

		if ($account) {
			return $account->user;
		} else {

			$account = new SocialAuth([
				'provider_user_id' => $providerUser->getId(),
				'provider' => 'facebook',
			]);

			$user = User::whereEmail($providerUser->getEmail())->first();

			if (!$user) {
				$user = User::create([
					'email' => $providerUser->getEmail(),
					'name' => $providerUser->getName(),
					'password' => md5(rand(1, 10000)),
				]);
				Subscriptions::create(['user_id' => $user->id, 'name' => 'Free', 'stripe_plan' => 'plan_free', 'created_at' => date('Y-m-d H:i')]);
			}

			$account->user()->associate($user);
			$account->save();

			return $user;
		}
	}
}