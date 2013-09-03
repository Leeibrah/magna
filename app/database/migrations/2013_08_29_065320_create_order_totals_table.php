<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderTotalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_totals', function(Blueprint $table) {
			$table->increments('id');
			$table->string('order_id');
			$table->string('sub_total');
			$table->string('custom_import');
			$table->string('shipping');
			$table->string('vat');
			$table->string('total');
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
		Schema::drop('order_totals');
	}

}
