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
		$this->call('Cc_transactionsTableSeeder');
		$this->call('PaymentsTableSeeder');
		$this->call('ItemsTableSeeder');
		$this->call('OrdersTableSeeder');
		$this->call('MerchantsTableSeeder');
		$this->call('LocationsTableSeeder');
		$this->call('Order_totalsTableSeeder');
		$this->call('M_tsTableSeeder');
	}

}