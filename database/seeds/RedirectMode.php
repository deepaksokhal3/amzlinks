<?php

use Illuminate\Database\Seeder;

class RedirectMode extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$data = [
			[
				'name' => 'Sequential',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'name' => 'Weighted',
				'created_at' => date('Y-m-d H:i:s'),
			],
			[
				'name' => 'Random',
				'created_at' => date('Y-m-d H:i:s'),
			],
		];
		DB::table('redirect_modes')->insert($data);
	}
}
