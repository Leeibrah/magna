<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('users')->truncate();

		$users = array(
			'email' => 't@t.com',
            'password' => Hash::make('t')
		);

		// Uncomment the below to run the seeder
		// DB::table('users')->insert($users);
	}

}
