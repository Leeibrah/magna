<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMpesaTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mpesa_transactions', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('order_id');
			$table->string('ipn_id');
			$table->string('ipn_orig');
			$table->string('ipn_dest');
			$table->string('ipn_tstamp');
			$table->string('ipn_text');
			$table->string('ipn_user');
			$table->string('ipn_pass');
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
		Schema::drop('mpesa_transactions');
	}

}
