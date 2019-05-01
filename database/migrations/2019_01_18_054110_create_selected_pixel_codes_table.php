<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectedPixelCodesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('selected_pixel_codes', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('tracking_link_id')->unsigned();
			$table->foreign('tracking_link_id')->references('id')->on('tracking_links')->onDelete('cascade');
			$table->integer('tracking_code_id')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('selected_pixel_codes');
	}
}
