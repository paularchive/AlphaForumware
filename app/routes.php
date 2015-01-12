<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('uses' => 'HomeController@hello', 'as' => 'home'));

Route::group(array('prefix' => 'forum'), function()
{
	Route::get('/', array('uses' => 'ForumController@index', 'as' => 'forum-home'));
	Route::get('category/{slug}', array('uses' => 'ForumController@category', 'as' => 'forum-category'));
	Route::get('subcategory/{slug}', array('uses' => 'ForumController@subcategory', 'as' => 'forum-sub-category'));
	Route::get('topic/{slug}', array('uses' => 'ForumController@topic', 'as' => 'forum-thread'));

	Route::group(array('before' => 'admin'), function()
	{
		Route::get('category/{slug}/delete', array('uses' => 'ForumController@deleteGroup', 'as' => 'forum-delete-group'));
		Route::get('subcategory/{slug}/delete', array('uses' => 'ForumController@deleteCategory', 'as' => 'forum-delete-category'));
		Route::get('subcategory/{slug}/edit', array('uses' => 'ForumController@editCategory', 'as' => 'forum-edit-category'));
		Route::get('category/{slug}/edit', array('uses' => 'ForumController@editGroup', 'as' => 'forum-edit-group'));

		Route::group(array('before' => 'csrf'), function()
		{
			Route::post('subcategory/{$slug}/edit', array('uses' => 'ForumController@editCategory', 'as' => 'forum-edit-category'));
			Route::post('category/new', array('uses' => 'ForumController@storeGroup', 'as' => 'forum-store-group'));
			Route::post('category/{$slug}/edit', array('uses' => 'ForumController@editGroup', 'as' => 'forum-edit-group'));
			Route::post('category/{slug}/newsubcat', array('uses' => 'ForumController@storeCategory', 'as' => 'forum-store-category'));
		});
	});
	Route::group(array('before' => 'auth'), function()
	{
		Route::get('subcategory/{slug}/newtopic', array('uses' => 'ForumController@newThread', 'as' => 'forum-get-new-thread'));
		Route::get('topic/{slug}/edit', array('uses' => 'ForumController@editThread', 'as' => 'forum-edit-thread'));
		Route::get('topic/{slug}/delete', array('uses' => 'ForumController@deleteThread', 'as' => 'forum-delete-thread'));
		Route::get('topic/{slug}/reply', array('uses' => 'ForumController@nedReply', 'as' => 'forum-new-comment'));
	
		Route::group(array('before' => 'csrf'), function()
		{
			Route::post('subcategory/{slug}/newtopic', array('uses' => 'ForumController@storeThread', 'as' => 'forum-store-thread'));
			Route::post('topic/{slug}/edit', array('uses' => 'ForumController@editThread', 'as' => 'forum-edit-thread'));
			Route::post('topic/{slug}/reply', array('uses' => 'ForumController@storeReply', 'as' => 'forum-store-comment'));
		});
	});
});


//User handling
Route::group(array('prefix' => 'user', 'before' => 'guest'), function()
{
	Route::get('register', array('uses' => 'UserController@getRegister', 'as' => 'user.register'));
	Route::get('login', array('uses' => 'UserController@getLogin', 'as' => 'user.login'));

	Route::group(array('before' => 'csrf'), function()
	{
		Route::post('register', array('uses' => 'UserController@postRegister', 'as' => 'user.register'));
		Route::post('login', array('uses' => 'UserController@postLogin', 'as' => 'user.login'));
	});
});

Route::group(array('before' => 'auth'), function()
{
	Route::get('/user/logout', array('uses' => 'UserController@getLogout', 'as' => 'user.logout'));
});

Route::group(array('prefix' => 'install'), function()
{
	Route::get('/', ['uses' => 'InstallController@index', 'as' => 'install.index']);
	Route::get('database', ['uses' => 'InstallController@database', 'as' => 'install.database']);
	Route::get('connection', ['uses' => 'InstallController@connection', 'as' => 'install.connection']);
	Route::post('database', ['uses' => 'InstallController@database', 'as' => 'install.database']);
	Route::post('connection', ['uses' => 'InstallController@connection', 'as' => 'install.connection']);
	Route::get('connection/migrateinstall', ['uses' => 'InstallController@migrateInstall', 'as' => 'install.connection.migrateinstall']);
	Route::get('connection/migrate', ['uses' => 'InstallController@migrate', 'as' => 'install.connection.migrate']);
	Route::get('connection/seed', ['uses' => 'InstallController@seed', 'as' => 'install.connection.seed']);
});