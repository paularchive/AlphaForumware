<?php

class ForumController extends BaseController {

	/**
	 * The Forum Home
	 *
	 * @return Response
	 */
	public function index()
	{
		$categories = ForumCategory::all();
		$subcategories = ForumSubCategory::all();
		
		return View::make('forum.index')->with('categories', $categories)->with('subcategories', $subcategories);
	}

	/**
	 * Show a category.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function category($slug)
	{
		$category = ForumCategory::findBySlug($slug);
		if($category == null)
			return Redirect::route('forum-home')->with('fail', "That category doesn't exist");
		
		$subcategories = $category->subcategories()->get();
		return View::make('forum.category')->with('category', $category)->with('subcategories', $subcategories);
	}


	/**
	 * Show a subcategory.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function subcategory($slug)
	{
		$subcategory = ForumSubCategory::findBySlug($slug);
		if($subcategory == null)
			return Redirect::route('forum-home')->with('fail', "That subcategory doesn't exist");
		
		$threads = $subcategory->threads()->get();
		return View::make('forum.subcategory')->with('subcategory', $subcategory)->with('threads', $threads);
	}


	/**
	 * Show a topic.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function topic($slug)
	{
		$topic = ForumThread::findBySlug($slug);
		if($topic == null)
			return Redirect::route('forum-home')->with('fail', "That topic doesn't exist.");

		$author = $topic->author()->first()->username;
		return View::make('forum.thread')->with('thread', $topic)->with('author', $author);
	}

	/**
	 * Store a new group.
	 *
	 * @return Response
	 */
	public function storeGroup()
	{
		$validate = Validator::make(Input::all(), array(
			'group_name' => 'required|unique:forum_categories,title'
		));

		if($validate->fails())
			return Redirect::route('forum-home')->withInput()->withErrors($validate)->with('adderror', '#group_modal');
		else
		{
			$group = new ForumCategory;
			$group->title = Input::get('group_name');
			$group->author_id = Auth::user()->id;

			if($group->save())
				return Redirect::route('forum-home')->with('success', 'The group was created.');
			else
				return Redirect::route('forum-home')->with('fail', 'An error occured while saving the new group. Please try again.');
		}
	}

	public function editGroup($id)
	{
		if(Request::ajax())
		{
			return Response::json(array('group' => ForumGroup::find($id)));
		}

		$rules = array(
			'group_name_edit' => 'required|unique:forum_groups,title'
		);

		$messages = array(
			'required' => 'Please fill in the group name!',
			'unique' => 'That name has already been taken!'
		);

		$validate = Validator::make(Input::all(), $rules, $messages);

		if($validate->fails())
		{
			return Redirect::route('forum-home')->withInput()->withErrors($validate)->with('group-edit', '#group_edit')->with('group-id', $id);
		}
		else
		{
			$group = ForumGroup::find($id);
			$group->title = Input::get('group_name_edit');
			$group->author_id = Auth::user()->id;

			if($group->save())
				return Redirect::route('forum-home')->with('success', 'The group is edited.');
			else
				return Redirect::route('forum-home')->with('fail', 'An error occured while editing the group. Please try again.');
		}
	}

	/**
	 * Delete a group.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteGroup($id)
	{
		$group = ForumGroup::find($id);
		if($group == null)
			return Redirect::route('forum-home')->with('fail', 'That group doesn\'t exist.');
		
		$categories = $group->categories();
		$threads = $group->threads();
		$comments = $group->comments();

		$delCa = true;
		$delT = true;
		$delCo = true;

		if($categories->count() > 0)
			$delCa = $categories->delete();

		if($threads->count() > 0)
			$delT = $threads->delete();

		if($comments->count() > 0)
			$delCo = $comments->delete();

		if($delCa && $delT && $delCo && $group->delete())
			return Redirect::route('forum-home')->with('success', 'The group was deleted.');
		else
			return Redirect::route('forum-home')->with('fail', 'An error occured while deleting the group.');
	}

	public function storeCategory($slug)
	{
		$category = ForumCategory::findBySlug($slug);
			if($category == null)
				return Redirect::route('forum-home')->with('fail', "That category doesn't exist");

		$validate = Validator::make(Input::all(), array(
			'category_name' => 'required'
		));

		if($validate->fails())
			return Redirect::route('forum-category', $category->slug)->withInput()->withErrors($validate)->with('adderror', '#dummydata');
		else
		{

			$subcategory = new ForumSubCategory;
			$subcategory->title = Input::get('category_name');
			$subcategory->author_id = Auth::user()->id;
			$subcategory->group_id = $category->id;

			if($subcategory->save())
				return Redirect::route('forum-category', $category->slug)->with('success', 'The subcategory was created.');
			else
				return Redirect::route('forum-category', $category->slug)->with('fail', 'An error occured while saving the new subcategory. Please try again.');		}
	}

	public function editCategory($id)
	{
		if(Request::ajax())
		{
			return Response::json(array('category' => ForumCategory::find($id)));
		}

		$rules = array(
			'category_name_edit' => 'required|unique:forum_categories,title'
		);

		$messages = array(
			'required' => 'Please fill in the category name!',
			'unique' => 'That name has already been taken!'
		);

		$validate = Validator::make(Input::all(), $rules, $messages);

		if($validate->fails())
		{
			return Redirect::route('forum-category', $id)->withInput()->withErrors($validate)->with('category-edit', '#category_edit')->with('category-id', $id);
		}
		else
		{
			$group = ForumCategory::find($id);
			$group->title = Input::get('category_name_edit');
			$group->author_id = Auth::user()->id;

			if($group->save())
				return Redirect::route('forum-category', $id)->with('success', 'The category is edited.');
			else
				return Redirect::route('forum-category', $id)->with('fail', 'An error occured while editing the category. Please try again.');
		}
	}


	public function deleteCategory($id)
	{
		$category = ForumCategory::find($id);
		if($category == null)
			return Redirect::route('forum-home')->with('fail', 'That category doesn\'t exist.');
		
		$threads = $category->threads();
		$comments = $category->comments();

		$delT = true;
		$delCo = true;

		if($threads->count() > 0)
			$delT = $threads->delete();

		if($comments->count() > 0)
			$delCo = $comments->delete();

		if($delT && $delCo && $category->delete())
			return Redirect::route('forum-home')->with('success', 'The category was deleted.');
		else
			return Redirect::route('forum-home')->with('fail', 'An error occured while deleting the category.');
	}

	public function newThread($slug)
	{
		$subcategory = ForumSubCategory::findBySlug($slug);
		return View::make('forum.newthread')->with('subcategory', $subcategory);
	}

	public function storeThread($slug)
	{
		$subcategory = ForumSubCategory::findBySlug($slug);
		if($subcategory == null)
			return Redirect::route('forum-get-new-thread', $subcategory->slug)->with('fail', 'You posted to an invalid category.');

		$validate = Validator::make(Input::all(), array(
			'title' => 'required|min:3|max:225',
			'body' => 'required|min:10|max:65000'
		));

		if($validate->fails())
			return Redirect::route('forum-get-new-thread', $subcategory->slug)->withInput()->withErrors($validate)->with('fail', 'Your input doesn\'t match the requirements.');
		else
		{
			$thread = new ForumThread;
			$thread->title = Input::get('title');
			$thread->body = Input::get('body');
			$thread->category_id = $subcategory->id;
			$thread->group_id = $subcategory->group_id;
			$thread->author_id = Auth::user()->id;

			if($thread->save())
			{
				return Redirect::route('forum-thread', $thread->slug)->with('success', 'Your thread has been saved.');
			}
			else
			{
				return Redirect::route('forum-get-new-thread', $subcategory->slug)->with('fail', 'An error occured while saving your thread.')->withInput();
			}
		}
	}

	public function editThread($slug)
	{
		$thread = ForumThread::findBySlug($slug);
		if($thread == null)
				return Redirect::route('forum-home')->with('fail', 'The thread you are trying to edit does not exist!');
		if(Auth::user()->id == $thread->author_id || Auth::user()->isAdmin())
		{
			if(Request::isMethod('get'))
				return View::make('forum.editthread')->with('thread', $thread);

			elseif(Request::isMethod('post'))
			{
				$validate = Validator::make(Input::all(), array(
					'title' => 'required|min:3|max:225',
					'body' => 'required|min:10|max:65000'
				));

				if($validate->fails())
					return Redirect::route('forum-edit-thread', $thread->slug)->withInput()->withErrors($validate)->with('fail', 'Your input doesn\'t match the requirements.');
				else
				{
					$thread->title = Input::get('title');
					$thread->body = Input::get('body');

					if($thread->save())
					{
						return Redirect::route('forum-thread', $thread->slug)->with('success', 'Your thread has been saved.');
					}
					else
					{
						return Redirect::route('forum-edit-thread', $thread->slug)->with('fail', 'An error occured while saving your thread.')->withInput();
					}
				}
			}
		}
		else
			return Redirect::route('forum-thread', $thead->slug)->with('fail', 'You do not own this thread! If you beleave this is a server error contact one of the Staff Members.');
	}

	public function deleteThread($slug)
	{
		$thread = ForumThread::findBySlug($slug);
		if($thread == null)
			Redirect::route('forum-home')->with('fail', "That thread doesn't exist");
		
		if(Auth::user()->id == $thread->author_id || Auth::user()->isAdmin())
		{
			$category_slug = $thread->subcategory->slug;
			$comments = $thread->comments;
			if($comments->count() > 0)
			{
				if($comments->delete() && $thread->delete())
					return Redirect::route('forum-category', $category_slug)->with('success', "The thread has been deleted.");
				else
					return Redirect::route('forum-category', $category_slug)->with('fail', "An error occured while deleting the thread.");
			}
			else
			{
				if($thread->delete())
					return Redirect::route('forum-category', $category_slug)->with('success', "The thread has been deleted.");
				else
					return Redirect::route('forum-category', $category_slug)->with('fail', "An error occured while deleting the thread.");
			}
		}
		else
			return Redirect::route('forum-thread', $thread->slug)->with('fail', 'You do not own this thread! If you beleave this is a server error contact one of the Staff Members.');
	}

	public function nedReply($slug)
	{
		$topic = ForumThread::findBySlug($slug);
		if($topic == null)
			return Redirect::route('forum-home')->with('fail', "That topic does't exist.");

		if(Input::get('edit')) //We got a edit request so let's load the edit view
		{
			$reply = ForumComment::find(Input::get('edit'));
			if($reply == null)
					return Redirect::route('forum-home')->with('fail', 'The comment you are trying to edit does not exist!');

			if(Auth::user()->id == $reply->author_id || Auth::user()->isAdmin())
				return View::make('forum.editcomment')->with('reply', $reply);
			else
				return Redirect::route('forum-thread', $topic->id)->with('fail', 'You do not own this comment! If you beleave this is a server error contact one of the Staff Members.');
		}
		elseif(Input::get('delete')) //We got a delete request so let's delete it
		{
			$reply = ForumComment::find(Input::get('delete'));
			if($reply == null)
				return Redirect::route('forum-home')->with('fail', 'The comment you are trying to edit does not exist!');
			
			if(Auth::user()->id == $reply->author_id || Auth::user()->isAdmin())
			{
				if($reply->delete())
					return Redirect::route('forum-thread', $topic->slug)->with('info', "The comment is deleted.");
				else
					return Redirect::route('forum-thread', $topic->slug)->with('fail', "An error occured while deleting the comment!");
			}
			else
				return Redirect::route('forum-thread', $topic->slug)->with('fail', 'You do not own this comment! If you beleave this is a server error contact one of the Staff Members.');
		}
		else //We didn't got a edit or delete request so load the new comment view
			return View::make('forum.newcomment')->with('topic', $topic);
	}

	public function storeReply($slug)
	{
		$topic = ForumThread::findBySlug($slug);
		if($topic == null)
			return Redirect::route('forum-home')->with('fail', "That topic does't exist.");
	
		if(Input::get('edit')) //We got a edit request so lets edit the requested comment
		{
			$reply = ForumComment::find(Input::get('edit'));
			if($reply == null)
					return Redirect::route('forum-home')->with('fail', 'The comment you are trying to edit does not exist!');

			elseif(Auth::user()->id == $reply->author_id || Auth::user()->isAdmin())
			{
				$validate = Validator::make(Input::all(), array(
					'body' => 'required|min:10|max:65000'
				));

				if($validate->fails())
					return Redirect::action('ForumController@nedReply', array('edit' => Input::get('edit')))->withInput()->withErrors($validate);
				else
				{
					$reply->body = Input::get('body');

					if($reply->save())
					{
						return Redirect::route('forum-thread', $topic->slug)->with('success', 'Your comment has been saved.');
					}
					else
					{
						return Redirect::action('ForumController@nedReply', array('edit' => Input::get('edit')))->withInput();
					}
				}
			}
			else
				return Redirect::route('forum-thread', $topic->slug)->with('fail', 'You do not own this comment! If you beleave this is a server error contact one of the Staff Members.');
		}
		else //We didn't got a edit request so store a new comment
		{	
			$validate = Validator::make(Input::all(), array(
				'body' => 'required|min:5'
			));

			if($validate->fails())
			{
				return Redirect::route('forum-new-comment', $slug)->withInput()->withErrors($validate)->with('fail', "Please fill in the form correctly!");
			}
			else
			{
				$comment = new ForumComment();
				$comment->body = Input::get('body');
				$comment->author_id = Auth::user()->id;
				$comment->thread_id = $topic->id;
				$comment->category_id = $topic->subcategory->id;
				$comment->group_id = $topic->category->id;

				if($comment->save())
					return Redirect::route('forum-thread', $topic->slug)->with('success', "Your comment is saved successfully.");
				else
					return Redirect::route('forum-thread', $topic->slug)->with('fail', "An error occured while saving your comment. Please try again!");
			}
		}
	}
}
