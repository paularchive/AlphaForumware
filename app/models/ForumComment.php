<?php

class ForumComment extends BaseModel
{
	protected $table = 'forum_comments';

	public function category()
	{
		return $this->belongsTo('ForumSubCategory');
	}

	public function subcategory()
	{
		return $this->belongsTo('ForumSubCategory', 'thread_id');
	}

	public function thread()
	{
		return $this->belongsTo('ForumThread', 'thread_id');
	}

	public function author()
	{
		return $this->belongsTo('User');
	}
}