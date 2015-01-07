<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumSubCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forum_subcategories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('slug')->nullable();
			$table->integer('group_id');
			$table->integer('author_id');
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
		Schema::drop('forum_subcategories');
	}

}
