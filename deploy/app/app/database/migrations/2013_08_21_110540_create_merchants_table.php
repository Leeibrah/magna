<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMerchantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchants', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('url');
			$table->string('about');
			$table->string('logo');
			$table->integer('orders_count');
			$table->string('orders_worth');
			$table->text('notes');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('merchants');
	}

}
