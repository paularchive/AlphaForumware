<?php

class ForumController extends BaseController {

	/**
	 * The Forum Home
	 *
	 * @return Response
	 */
	public function index()
	{
		$groups = ForumGroup::all();
		$categories = ForumCategory::all();
		
		return View::make('forum.index')->with('groups', $groups)->with('categories', $categories);
	}


	/**
	 * Show a category.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function category($id)
	{
		$category = ForumCategory::find($id);
		if($category == null)
		{
			return Redirect::route('forum-home')->with('fail', 'That category doesn\'t exist');
		}
		$threads = $category->threads()->get();
		return View::make('forum.category')->with('category', $category)->with('threads', $threads);
	}


	/**
	 * Show a thread.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function thread($id)
	{
		$thread = ForumThread::find($id);
		if($thread == null)
		{
			return Redirect::route('forum-home')->with('fail', "That thread doesn't exist.");
		}

		$author = $thread->author()->first()->username;
		return View::make('forum.thread')->with('thread', $thread)->with('author', $author);
	}

	/**
	 * Store a new group.
	 *
	 * @return Response
	 */
	public function storeGroup()
	{
		$validate = Validator::make(Input::all(), array(
			'group_name' => 'required|unique:forum_groups,title'
		));
		if($validate->fails())
		{
			return Redirect::route('forum-home')->withInput()->withErrors($validate)->with('modal', '#group_form');
		}
		else
		{
			$group = new ForumGroup;
			$group->title = Input::get('group_name');
			$group->author_id = Auth::user()->id;

			if($group->save())
			{
				return Redirect::route('forum-home')->with('success', 'The group was created.');
			}
			else
			{
				return Redirect::route('forum-home')->with('fail', 'An error occured while saving the new group. Please try again.');
			}
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
		{
			return Redirect::route('forum-home')->with('fail', 'That group doesn\'t exist.');
		}
		
		$categories = $group->categories();
		$threads = $group->threads();
		$comments = $group->comments();

		$delCa = true;
		$delT = true;
		$delCo = true;

		if($categories->count() > 0)
		{
			$delCa = $categories->delete();
		}
		if($threads->count() > 0)
		{
			$delT = $threads->delete();
		}
		if($comments->count() > 0)
		{
			$delCo = $comments->delete();
		}

		if($delCa && $delT && $delCo && $group->delete())
		{
			return Redirect::route('forum-home')->with('success', 'The group was deleted.');
		}
		else
		{
			return Redirect::route('forum-home')->with('fail', 'An error occured while deleting the group.');
		}
	}

	public function storeCategory($id)
	{
		$validate = Validator::make(Input::all(), array(
			'category_name' => 'required|unique:forum_categories,title'
		));
		if($validate->fails())
		{
			return Redirect::route('forum-home')->withInput()->withErrors($validate)->with('category-modal', '#category_modal')->with('group-id', $id);
		}
		else
		{
			$group = ForumGroup::find($id);
			if($group == null)
			{
				return Redirect::route('forum-home')->with('fail', 'That group doesn\'t exist');
			}

			$category = new ForumCategory;
			$category->title = Input::get('category_name');
			$category->author_id = Auth::user()->id;
			$category->group_id = $id;

			if($category->save())
			{
				return Redirect::route('forum-home')->with('success', 'The category was created.');
			}
			else
			{
				return Redirect::route('forum-home')->with('fail', 'An error occured while saving the new category. Please try again.');
			}
		}
	}

	public function deleteCategory($id)
	{
		$category = ForumCategory::find($id);
		if($category == null)
		{
			return Redirect::route('forum-home')->with('fail', 'That category doesn\'t exist.');
		}
		
		$threads = $category->threads();
		$comments = $category->comments();

		$delT = true;
		$delCo = true;

		if($threads->count() > 0)
		{
			$delT = $threads->delete();
		}
		if($comments->count() > 0)
		{
			$delCo = $comments->delete();
		}

		if($delT && $delCo && $category->delete())
		{
			return Redirect::route('forum-home')->with('success', 'The category was deleted.');
		}
		else
		{
			return Redirect::route('forum-home')->with('fail', 'An error occured while deleting the category.');
		}
	}

	public function newThread($id)
	{
		$category = ForumCategory::find($id);
		return View::make('forum.newthread')->with('id', $id)->with('category', $category);
	}

	public function storeThread($id)
	{
		$category = ForumCategory::find($id);
		if($category == null)
		{
			return Redirect::route('forum-get-new-thread')->with('fail', 'You posted to an invalid category.');
		}

		$validate = Validator::make(Input::all(), array(
			'title' => 'required|min:3|max:225',
			'body' => 'required|min:10|max:65000'
		));

		if($validate->fails())
		{
			return Redirect::route('forum-get-new-thread')->withInput()->withErrors($validate)->with('fail', 'Your input doesn\'t match the requirements.');
		}
		else
		{
			$thread = new ForumThread;
			$thread->title = Input::get('title');
			$thread->body = Input::get('body');
			$thread->category_id = $id;
			$thread->group_id = $category->group_id;
			$thread->author_id = Auth::user()->id;

			if($thread->save())
			{
				return Redirect::route('forum-thread', $thread->id)->with('success', 'Your thread has been saved.');
			}
			else
			{
				return Redirect::route('forum-get-new-thread', $id)->with('fail', 'An error occured while saving your thread.')->withInput();
			}
		}
	}

	public function deleteThread()
	{
		$thread = ForumThread::find($id);
		if($thread == null)
		{
			return Redirect::route('forum-home')->with('fail', "That thread doesn't exist");
		}
		$category_id = $thread->category_id;
		$comments = $thread->comments;
		if($comments->count() > 0)
		{
			if($comments->delete() && $thread->delete())
			{
				Redirect::route('forum_category', $category_id)->with('success', "The thread has been deleted.");
			}
			else
			{
				Redirect::route('forum_category', $category_id)->with('fail', "An error occured while deleting the thread.");
			}
		}
		else
		{
			if($thread->delete())
			{
				Redirect::route('forum_category', $category_id)->with('success', "The thread has been deleted.");
			}
			else
			{
				Redirect::route('forum_category', $category_id)->with('fail', "An error occured while deleting the thread.");
			}
		}
	}
}
