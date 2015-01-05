<?php

class ForumSubCategory extends BaseModel
{
	protected $table = 'forum_subcategories';

	public function category()
	{
		return $this->belongsTo('ForumCategory', 'group_id');
	}

	public function threads()
	{
		return $this->hasMany('ForumThread', 'category_id');
	}

	public function comments()
	{
		return $this->hasMany('ForumComment', 'category_id');
	}
}