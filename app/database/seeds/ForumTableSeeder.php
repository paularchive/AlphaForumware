<?php

class ForumTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('forum_categories')->delete();
		DB::table('forum_subcategories')->delete();
		DB::table('forum_threads')->delete();

		ForumCategory::create(array(
			'title' => 'General Discussion',
			'slug' => 'general-discussion',
			'author_id' => 1
		));

		ForumSubCategory::create(array(
			'group_id' => 1,
			'title' => 'Test Category 1',
			'slug' => 'test-category-1',
			'author_id' => 1
		));

		ForumSubCategory::create(array(
			'group_id' => 1,
			'title' => 'Test Category 2',
			'slug' => 'test-category-2',
			'author_id' => 1
		));

		ForumThread::create(array(
			'group_id' => 1,
			'title' => 'Introduction',
			'slug' => 'introduction',
			'body' => 'We are happy that you are using this software!',
			'author_id' => 1,
			'category_id' => 1,
		));

		ForumThread::create(array(
			'group_id' => 1,
			'title' => 'Test Topic',
			'slug' => 'test-topic',
			'body' => "You can just delete this topic it's just for testing",
			'author_id' => 1,
			'category_id' => 2,
		));
	}
}