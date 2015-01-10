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
		<a href="{{ URL::route('forum-category', $thread->category->slug) }}" class="section">{{ $thread->category->title }}</a>
		<i class="right chevron icon divider"></i>
		<a href="{{ URL::route('forum-sub-category', $thread->subcategory->slug) }}" class="section">{{ $thread->subcategory->title }}</a>
		<i class="right chevron icon divider"></i>
		<div class="active section">{{ $thread->title }}</div>
	</div>
</div>

<div class="row">
	<div class="six wide column">
		<a href="{{ URL::route('forum-new-comment', $thread->slug) }}" class="ui vertical animated teal button">
			<div class="visible content">Reply</div>
			<div class="hidden content">
				<i class="reply icon"></i>
			</div>
		</a>
	</div>
	@if(Auth::check())
		@if(Auth::user()->isAdmin() || Auth::user()->id == $thread->author_id)
		<div class="right aligned ten wide column">
			<div class="ui buttons">
				<a href="{{ URL::route('forum-edit-thread', $thread->slug) }}" class="ui button">Edit</a>
				<div class="or"></div>
				<div class="ui negative button">Delete</div>
			</div>
		</div>
		@endif
	@endif
</div>

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
		<div class="eight column row">
			<div class="left floated column">
			<h4>Re: {{ $comment->thread->title }}</h4><small>by <strong>{{ $comment->author->username }}</strong> &raquo; <em>{{ $comment->created_at }}</em></small>
			</div>
			@if(Auth::check() && Auth::user()->isAdmin() || Auth::check() && Auth::user()->id == $thread->author_id)
			<div class="right floated column">
				<div class="ui top right pointing dropdown black basic icon button" data-trigger="hover">
						<i class="fa fa-bars"></i>
					<div class="menu">
						<a href="{{ URL::action('ForumController@nedReply', array('topic' => $thread->slug, 'edit' => $comment->id)); }}" class="item">Edit</a>
						<a href="{{ URL::action('ForumController@nedReply', array('topic' => $thread->slug, 'delete' => $comment->id)); }}" class="item">Delete</a>
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>
	<div class="ui attached segment">
		<p>{{ BBCode::parse($comment->body) }}</p>
		@if($comment->updated_at != $comment->created_at)
		<div class="ui bottom left attached label">Last edited by {{ $comment->author->username }} on <em>{{ $comment->updated_at }}</em></div>
		@endif
	</div>
</div>
@endforeach

<div class="sixteen wide column">
	<a href="{{ URL::route('forum-new-comment', $thread->slug) }}" class="ui vertical animated teal button">
		<div class="visible content">Reply</div>
		<div class="hidden content">
			<i class="reply icon"></i>
		</div>
	</a>
</div>

@stop