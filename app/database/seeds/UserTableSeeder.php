<?php

class UserTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('users')->delete();
	    $user = Sentry::createUser(array(
	    	'username'  => 'admin',
	        'email'     => 'admin@admin.com',
	        'password'  => 'admin',
	        'activated' => true,
	    ));

	    // Find the group using the group id
	    $adminGroup = Sentry::findGroupByName('admin');

	    // Assign the group to the user
	    $user->addGroup($adminGroup);
	}
}