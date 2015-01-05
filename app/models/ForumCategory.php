<?php

class ForumCategory extends BaseModel
{
	protected $table = 'forum_categories';

	public function subcategories()
	{
		return $this->hasMany('ForumSubCategory', 'group_id');
	}

	public function threads()
	{
		return $this->hasMany('ForumThread', 'group_id');
	}

	public function comments()
	{
		return $this->hasMany('ForumComment', 'group_id');
	}

	public function author()
	{
		return $this->belongsTo('User');
	}
}