<?php

use Illuminate\Database\Seeder;

class SubscriptionTypes extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$data = [
			[
				'title' => 'Free',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'title' => 'Essential',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'title' => 'Professional',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'title' => 'Business',
				'created_at' => date('Y-m-d H:i:s'),
			],
		];
		DB::table('subscription_types')->insert($data);
	}
}
