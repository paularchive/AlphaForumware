@extends('layouts.master')

@section('head')
	@parent
	<title>Forum | {{ $thread->title }}</title>
@stop

@section('content')
<div class="sixteen wide column">
	<div class="ui breadcrumb segment" style="width: 100%;">
		<a href="{{ URL::route('forum-home') }}" class="section">Forum</a>
		<i class="right chevron icon divider"></i>
		<a href="{{ URL::route('forum-home') }}" class="section">{{ $thread->group->title }}</a>
		<i class="right chevron icon divider"></i>
		<a href="{{ URL::route('forum-category', $thread->category->id) }}" class="section">{{ $thread->category->title }}</a>
		<i class="right chevron icon divider"></i>
		<div class="active section">{{ $thread->title }}</div>
	</div>
</div>

@if(Auth::check())
<div class="row">
	<div class="eight wide column">
		<a href="#" class="ui vertical animated teal button">
			<div class="hidden content">Reply</div>
			<div class="visible content">
				<i class="reply icon"></i>
			</div>
		</a>
	</div>
	@if(Auth::user()->isAdmin() || Auth::user()->id == $thread->author_id)
	<div class="right aligned eight wide column">
		<div class="ui buttons">
			<a href="{{ URL::route('forum-edit-thread', $thread->id) }}" class="ui button">Edit</a>
			<div class="or"></div>
			<div class="ui negative button">Delete</div>
		</div>
	</div>
	@endif
</div>
@endif

<div class="sixteen wide column">
	<div class="ui top attached segment thread-title">
		<h4>{{ $thread->title }}</h4><small>by <strong>{{ $author }}</strong> &raquo; <em>{{ $thread->created_at }}</em></small>
	</div>
	<div class="ui attached segment">
		<p>{{ BBCode::parse($thread->body) }}</p>
		@if($thread->updated_at != $thread->created_at)
		<div class="ui bottom left attached label">Last edited by {{ $author }} on <em>{{ $thread->updated_at }}</em></div>
		@endif
	</div>
</div>

@foreach($thread->comments()->get() as $comment)
<div class="sixteen wide column">
	<div class="ui top attached segment thread-title">
		<h4>Re: {{ $comment->thread->title }}</h4><small>by <strong>{{ $comment->author->username }}</strong> &raquo; <em>{{ $comment->created_at }}</em></small>
		@if(Auth::check() && Auth::user()->isAdmin() || Auth::check() && Auth::user()->id == $thread->author_id)
			<!--div class="dropdown pull-right">
				<button id="options-menu" type="button" class="btn btn-default btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options <span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="options-menu">
					<li><a href="{{ URL::route('forum-edit-comment', $comment->id) }}">Edit Comment</a></li>
					<li><a href="{{ URL::route('forum-delete-comment', $comment->id) }}">Delete Comment</a></li>
				</ul>
			</div-->
		@endif
	</div>
	<div class="ui attached segment">
		<p>{{ BBCode::parse($comment->body) }}</p>
		@if($comment->updated_at != $comment->comment)
		<div class="ui bottom left attached label">Last edited by {{ $comment->author->username }} on <em>{{ $comment->updated_at }}</em></div>
		@endif
	</div>
</div>
@endforeach

	@if(Auth::check())
		<form method="post" action="{{ URL::route('forum-store-comment', $thread->id) }}">
			<div class="form-group">
				<label for="body">Comment: </label>
				<textarea class="form-control" name="body" id="body"></textarea>
			</div>
			{{ Form::token() }}
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Submit Comment">
			</div>
		</form>
	@endif

	@if(Auth::check() && Auth::user()->isAdmin() || Auth::check() && Auth::user()->id == $thread->id)
	<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body">
					<h3>Are you shure?</h3>
				</div>
				<button class="delete-cancel-btn" type="button" data-dismiss="modal">Cancel</button>
				<a href="{{ URL::route('forum-delete-thread', $thread->id) }}" class="delete-confirm-btn">Confirm</a>
			</div>
		</div>
	</div>
	@endif
@stop