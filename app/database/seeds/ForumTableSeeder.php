<?php

class ForumTableSeeder extends Seeder
{
	public function run()
	{
		ForumGroup::create(array(
			'title' => 'General Discussion',
			'author_id' => 1
		));

		ForumCategory::create(array(
			'group_id' => 1,
			'title' => 'Test Category 1',
			'author_id' => 1
		));

		ForumCategory::create(array(
			'group_id' => 1,
			'title' => 'Test Category 2',
			'author_id' => 1
		));
	}
}