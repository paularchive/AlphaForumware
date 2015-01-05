<?php

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class ForumThread extends BaseModel implements SluggableInterface
{
	use SluggableTrait;

    protected $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
    );

	protected $table = 'forum_threads';

	public function category()
	{
		return $this->belongsTo('ForumCategory', 'group_id');
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