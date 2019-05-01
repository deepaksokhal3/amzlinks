<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('oauths', function (Blueprint $table) {
			$table->increments('id');
			$table->string('access_token');
			$table->text('accountid', 20)->nullable();
			$table->text('refresh_token');
			$table->timestamps();
		});
		DB::table('oauths')->insert([
			'access_token' => 'ya29.GlyaBhYFyHRAUHyJgrqQY27XgzGM3_1kfgf7EKBe7JVjdm0bRBttSGSx_PYr4X4z1lLFKU4yzEdPVHjHbg91_6g9fnj0epcsMU5DVMoPjdxjxvnrBWCTa8q0STNxSQ',
			'refresh_token' => '{"access_token":"ya29.GlyaBhYFyHRAUHyJgrqQY27XgzGM3_1kfgf7EKBe7JVjdm0bRBttSGSx_PYr4X4z1lLFKU4yzEdPVHjHbg91_6g9fnj0epcsMU5DVMoPjdxjxvnrBWCTa8q0STNxSQ","expires_in":3600,"scope":"https:\/\/www.googleapis.com\/auth\/analytics.readonly https:\/\/www.googleapis.com\/auth\/webmasters.readonly","token_type":"Bearer","created":1548246934,"refresh_token":"1\/c4kROhAFCzebofaC_KBcXYBKTPVW4gVg9Gi9HHl7THs"}',
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('oauths');
	}
}
