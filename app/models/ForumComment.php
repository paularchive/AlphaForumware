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
		return $this->belongsTo('ForumSubCategory');
	}

	public function thread()
	{
		return $this->belongsTo('ForumThread');
	}

	public function author()
	{
		return $this->belongsTo('User');
	}
}