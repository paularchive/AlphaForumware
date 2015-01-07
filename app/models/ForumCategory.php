<?php

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class ForumCategory extends BaseModel implements SluggableInterface
{
	use SluggableTrait;

    protected $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
    );
    
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