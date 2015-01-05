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
	Route::get('/category/{id}', array('uses' => 'ForumController@category', 'as' => 'forum-category'));
	Route::get('/subcategory/{id}', array('uses' => 'ForumController@subcategory', 'as' => 'forum-sub-category'));
	Route::get('/thread/{id}', array('uses' => 'ForumController@thread', 'as' => 'forum-thread'));

	Route::group(array('before' => 'admin'), function()
	{
		Route::get('/group/{id}/delete', array('uses' => 'ForumController@deleteGroup', 'as' => 'forum-delete-group'));
		Route::get('/category/{id}/delete', array('uses' => 'ForumController@deleteCategory', 'as' => 'forum-delete-category'));
		Route::get('/category/{id}/edit', array('uses' => 'ForumController@editCategory', 'as' => 'forum-edit-category'));
		Route::get('/comment/{id}/delete', array('uses' => 'ForumController@deleteComment', 'as' => 'forum-delete-comment'));
		Route::get('/comment/{id}/edit', array('uses' => 'ForumController@editComment', 'as' => 'forum-edit-comment'));
		Route::get('/group/{id}/edit', array('uses' => 'ForumController@editGroup', 'as' => 'forum-edit-group'));

		Route::group(array('before' => 'csrf'), function()
		{
			Route::post('/category/{id}/new', array('uses' => 'ForumController@storeCategory', 'as' => 'forum-store-category'));
			Route::post('/category/{id}/edit', array('uses' => 'ForumController@editCategory', 'as' => 'forum-edit-category'));
			Route::post('/comment/{id}/edit', array('uses' => 'ForumController@editComment', 'as' => 'forum-edit-comment'));
			Route::post('/group', array('uses' => 'ForumController@storeGroup', 'as' => 'forum-store-group'));
			Route::post('/group/{id}/edit', array('uses' => 'ForumController@editGroup', 'as' => 'forum-edit-group'));
		});
	});
	Route::group(array('before' => 'auth'), function()
	{
		Route::get('/thread/{id}/new', array('uses' => 'ForumController@newThread', 'as' => 'forum-get-new-thread'));
		Route::get('/thread/{id}/edit', array('uses' => 'ForumController@editThread', 'as' => 'forum-edit-thread'));
		Route::get('/thread/{id}/delete', array('uses' => 'ForumController@deleteThread', 'as' => 'forum-delete-thread'));
	
		Route::group(array('before' => 'csrf'), function()
		{
			Route::post('/thread/{id}/new', array('uses' => 'ForumController@storeThread', 'as' => 'forum-store-thread'));
			Route::post('/thread/{id}/edit', array('uses' => 'ForumController@editThread', 'as' => 'forum-edit-thread'));
			Route::post('/comment/{id}/new', array('uses' => 'ForumController@storeComment', 'as' => 'forum-store-comment'));
		});
	});
});

Route::group(array('before' => 'guest'), function()
{
	Route::get('/user/create', array('uses' => 'UserController@getCreate', 'as' => 'getCreate'));
	Route::get('/user/login', array('uses' => 'UserController@getLogin', 'as' => 'getLogin'));

	Route::group(array('before' => 'csrf'), function()
	{
		Route::post('user/create', array('uses' => 'UserController@postCreate', 'as' => 'postCreate'));
		Route::post('/user/login', array('uses' => 'UserController@postLogin', 'as' => 'postLogin'));
	});
});

Route::group(array('before' => 'auth'), function()
{
	Route::get('/user/logout', array('uses' => 'UserController@getLogout', 'as' => 'getLogout'));
});