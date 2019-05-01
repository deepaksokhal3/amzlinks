<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksLogsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('links_logs', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->integer('tracking_links_id')->unsigned();
			$table->foreign('tracking_links_id')->references('id')->on('tracking_links')->onDelete('cascade');

			$table->integer('destination_links_id')->unsigned();
			$table->foreign('destination_links_id')->references('id')->on('destination_links')->onDelete('cascade');

			$table->integer('link_position')->nullable();

			$table->integer('clicks')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('links_logs');
	}
}
