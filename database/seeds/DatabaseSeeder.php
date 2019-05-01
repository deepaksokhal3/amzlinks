<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {
		$this->call(User::class);
		$this->call(Countries::class);
		$this->call(RedirectMode::class);
		$this->call(TrackingType::class);
		$this->call(Subscription::class);
		$this->call(SubscriptionTypes::class);
		$this->call(UrlTypes::class);

	}
}
