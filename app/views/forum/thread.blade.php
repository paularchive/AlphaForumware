@extends('layouts.master')

@section('head')
	@parent
	<title>Forum | {{ $thread->title }}</title>
@stop

@section('content')
	<ol class="breadcrumb">
		<li><a href="{{ URL::route('forum-home') }}">Forum</a></li>
		<li><a href="{{ URL::route('forum-category', $thread->category_id) }}">{{ $thread->category->title }}</a></li>
		<li class="active">{{ $thread->title }}</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading clearfix">
			<h4 class="pull-left">{{ $thread->title }}<br><small>by: {{ $author }} on {{ $thread->created_at }}</small></h4>
			@if(Auth::check() && Auth::user()->isAdmin)
				<a href="{{ URL::route('forum-delete-thread', $thread->id) }}" class="btn btn-danger pull-right">Delete</a>
			@endif
		</div>
		<div class="panel-body">
			{{ BBCode::parse($thread->body) }}
		</div>
	</div>

	@foreach($thread->comments()->get() as $comment)
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h4 class="pull-left">Re: {{ $comment->thread->title }}<br><small>by: {{ $comment->author->username }} on {{ $comment->created_at }}</small></h4>
				@if(Auth::check() && Auth::user()->isAdmin())
					<a href="{{ URL::route('forum-delete-comment', $comment->id) }}" class="btn btn-danger pull-right">Delete</a>
				@endif
			</div>
			<div class="panel-body">
				{{ BBCode::parse($comment->body) }}
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
@stop