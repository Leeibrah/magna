<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function(Blueprint $table) {
			$table->increments('id');
			$table->string('session_id');
			$table->string('ip_address');
			$table->string('user_id');
			$table->string('order_id');
			$table->string('md5');
			$table->integer('merchant_id');
			$table->string('item_id');
			$table->string('name');
			$table->integer('quantity');
			$table->string('link');
			$table->string('image');
			$table->string('designer');
			$table->string('color');
			$table->integer('size');
			$table->string('package');
			$table->string('print_on_demand');
			$table->string('front_logo');
			$table->string('custom_back_number');
			$table->string('custom_back_name');
			$table->string('part_number');
			$table->string('price_usd');
			$table->string('price_ksh');
			$table->string('status');
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
		Schema::drop('items');
	}

}
