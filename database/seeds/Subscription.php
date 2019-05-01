<?php

use Illuminate\Database\Seeder;

class Subscription extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$data = [
			[
				'user_id' => 1,
				'fee' => '0.00',
				'sub_type_id' => 0,
				'currency' => 'USD',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'user_id' => 1,
				'fee' => '9.99',
				'sub_type_id' => 1,
				'currency' => 'USD',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'user_id' => 1,
				'fee' => '19.99',
				'sub_type_id' => 2,
				'currency' => 'USD',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'user_id' => 1,
				'fee' => '49.99',
				'sub_type_id' => 3,
				'currency' => 'USD',
				'created_at' => date('Y-m-d H:i:s'),
			],
		];
		DB::table('subscriptions')->insert($data);
	}
}
