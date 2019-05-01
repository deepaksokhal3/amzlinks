<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingLinksTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tracking_links', function (Blueprint $table) {
			$table->engine = "InnoDB";
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->integer('redirect_mode_id')->unsigned()->default(1);
			$table->foreign('redirect_mode_id')->references('id')->on('redirect_modes')->onDelete('cascade');

			$table->integer('campaign_id')->unsigned()->nullable();;
			$table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

			$table->integer('types')->unsigned();
			$table->foreign('types')->references('id')->on('url_types')->onDelete('cascade');
			$table->integer('user_subscription_id');
			$table->string('title');
			$table->string('marketplace')->nullable();
			$table->string('brand')->nullable();
			$table->string('min_price')->nullable();
			$table->string('max_price')->nullable();
			$table->string('storefront')->nullable();
			$table->string('quantity')->nullable();
			$table->string('asin')->nullable();
			$table->string('keyword')->nullable();
			$table->string('intermediate_page')->nullable();
			$table->string('uniqe_url');
			$table->boolean('hide_ref_url');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('tracking_links');
	}
}
