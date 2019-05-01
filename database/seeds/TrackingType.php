<?php

use Illuminate\Database\Seeder;

class TrackingType extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$data = [
			[
				'name' => 'Facebook Pixel',
				'icon' => 'fa fa-facebook text-primary',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'name' => 'Google Analytics',
				'icon' => 'fa fa-google text-danger',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'name' => 'Pinterest',
				'icon' => 'fa fa-pinterest text-danger',
				'created_at' => date('Y-m-d H:i:s'),
			],
		];
		DB::table('tracking_types')->insert($data);
	}
}
