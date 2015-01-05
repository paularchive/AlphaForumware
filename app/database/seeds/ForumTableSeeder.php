<?php

class ForumTableSeeder extends Seeder
{
	public function run()
	{
		ForumCategory::create(array(
			'title' => 'General Discussion',
			'author_id' => 1
		));

		ForumSubCategory::create(array(
			'group_id' => 1,
			'title' => 'Test Category 1',
			'author_id' => 1
		));

		ForumSubCategory::create(array(
			'group_id' => 1,
			'title' => 'Test Category 2',
			'author_id' => 1
		));
	}
}