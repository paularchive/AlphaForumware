<?php

class ForumThread extends BaseModel
{
	protected $table = 'forum_threads';

	public function category()
	{
		return $this->belongsTo('ForumCategory');
	}

	public function subcategory()
	{
		return $this->belongsTo('ForumSubCategory', 'category_id');
	}

	public function comments()
	{
		return $this->hasMany('ForumComment', 'thread_id');
	}

	public function author()
	{
		return $this->belongsTo('User', 'author_id');
	}
}