<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMTsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_ts', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('order_id');
			$table->string('ipn_id');
			$table->string('orig');
			$table->string('dest');
			$table->string('tstamp');
			$table->string('text');
			$table->string('customer_id');
			$table->string('user');
			$table->string('pass');
			$table->string('routemethod_id');
			$table->string('routemethod_name');
			$table->string('mpesa_code');
			$table->string('mpesa_acc');
			$table->string('mpesa_msisdn');
			$table->string('mpesa_trx_date');
			$table->string('mpesa_trx_time');
			$table->string('mpesa_amt');
			$table->string('mpesa_sender');
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
		Schema::drop('m_ts');
	}

}
