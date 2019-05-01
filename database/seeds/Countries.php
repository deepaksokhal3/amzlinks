<?php

use Illuminate\Database\Seeder;

class Countries extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		//
		$countries = [
			[
				'code' => 'ca',
				'country_name' => 'Canada',
				'flag' => 'flag-icon flag-icon-ca',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'code' => 'fr',
				'country_name' => 'France',
				'flag' => 'flag-icon flag-icon-fr',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'code' => 'de',
				'country_name' => 'Germany',
				'flag' => 'flag-icon flag-icon-de',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'code' => 'it',
				'country_name' => 'Italy',
				'flag' => 'flag-icon flag-icon-it',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'code' => 'es',
				'country_name' => 'Spain',
				'flag' => 'flag-icon flag-icon-es',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'code' => 'co.uk',
				'country_name' => 'Australia',
				'flag' => 'flag-icon flag-icon-au',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'code' => 'com.au',
				'country_name' => 'United Kingdom',
				'flag' => 'flag-icon flag-icon-gb',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'code' => 'com',
				'country_name' => 'United States',
				'flag' => 'flag-icon flag-icon-us',
				'created_at' => date('Y-m-d H:i:s'),
			],
		];

		DB::table('countries')->insert($countries);
	}
}
