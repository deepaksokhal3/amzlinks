<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinationLinksTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('destination_links', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('tracking_link_id')->unsigned();
			$table->foreign('tracking_link_id')->references('id')->on('tracking_links')->onDelete('cascade');
			$table->string('destination_url', 700);
			$table->string('type')->nullable();
			$table->string('unique_url');
			$table->integer('percentage')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('destination_links');
	}
}
