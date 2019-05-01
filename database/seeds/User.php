<?php

use Illuminate\Database\Seeder;

class User extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$data = [
			[
				'name' => 'Admin',
				'email' => 'admin@gmail.com',
				'role' => 'admin',
				'password' => bcrypt('admin@123'),
				'is_active' => 1,
			],

		];
		DB::table('users')->insert($data);
	}
}
