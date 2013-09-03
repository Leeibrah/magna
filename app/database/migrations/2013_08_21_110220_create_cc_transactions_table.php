<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCcTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cc_transactions', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('order_id');
			$table->string('provider');
			$table->integer('number');
			$table->integer('ccv');
			$table->string('name');
			$table->date('expiry_date');
			$table->string('amount');
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
		Schema::drop('cc_transactions');
	}

}
