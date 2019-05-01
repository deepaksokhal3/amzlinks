<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqPagesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('faq_pages', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('cat_id')->unsigned();
			$table->foreign('cat_id')->references('id')->on('faq_catagories')->onDelete('cascade');
			$table->string('title');
			$table->text('description');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('faq_pages');
	}
}
