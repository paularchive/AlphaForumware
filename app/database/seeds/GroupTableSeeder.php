<?php

class GroupTableSeeder extends Seeder {

  public function run()
  {
    DB::table('groups')->delete();
    Sentry::getGroupProvider()->create(array(
      'name' => 'test',
      'permissions' => array('articlecategories.create' => 1,
                             'articlecategories.edit' => 1,
                             'articlecategories.delete' => 1,
                             'articles.create' => 1,
                             'articles.edit' => 1,
                             'articles.delete' => 1,
                             'news.create' => 1,
                             'news.edit' => 1,
                             'news.delete' => 1)
    ));
      
    Sentry::getGroupProvider()->create(array(
    	'name' => 'member',
    	'permissions' => array('users.edit' => 1,
                             'users.delete' => 1,
                             'lists.create' => 1,
                             'lists.edit' => 1,
    	                       'lists.delete' => 1)
    ));
    
    Sentry::getGroupProvider()->create(array(
    	'name' => 'admin',
      'permissions' => array('superuser' => 1))
    );

  }

}