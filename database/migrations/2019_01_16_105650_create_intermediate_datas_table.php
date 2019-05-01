<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntermediateDatasTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('intermediate_datas', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('tracking_link_id')->unsigned();
			$table->foreign('tracking_link_id')->references('id')->on('tracking_links')->onDelete('cascade');
			$table->integer('destination_id')->nullable();
			$table->text('htmlString');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('intermediate_datas');
	}
}
