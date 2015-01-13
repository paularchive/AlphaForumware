<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('install', function($table)
		{
			$table->increments('id');
			$table->string('install-step');
			$table->boolean('done')->default(0);
		});

		DB::table('install')
		->insert(['install-step' => 'db-connect']);
		DB::table('install')
		->insert(['install-step' => 'db-migrate']);
		DB::table('install')
		->insert(['install-step' => 'user-create']);
		DB::table('install')
		->insert(['install-step' => 'install-done']);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('install');
	}

}
