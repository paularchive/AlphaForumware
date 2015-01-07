<?php

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class ForumSubCategory extends BaseModel implements SluggableInterface
{
	use SluggableTrait;

    protected $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
    );

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