<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$this->call('UsersTableSeeder');
		$this->call('OrdersTableSeeder');
		$this->call('Mpesa_transactionsTableSeeder');
		$this->call('LocationsTableSeeder');
		$this->call('ItemsTableSeeder');
		$this->call('Cc_transactionsTableSeeder');
		$this->call('PaymentsTableSeeder');
		$this->call('Order_totalsTableSeeder');
		$this->call('MerchantsTableSeeder');
	}

}