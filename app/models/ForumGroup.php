<?php

class ForumGroup extends BaseModel
{
	protected $table = 'forum_groups';

	public function categories()
	{
		return $this->hasMany('ForumCategory', 'group_id');
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