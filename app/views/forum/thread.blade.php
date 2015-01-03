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
		@if(Auth::check() && Auth::user()->isAdmin() || Auth::check() && Auth::user()->id == $thread->author_id)
			<div class="dropdown pull-right">
				<button id="options-menu" type="button" class="btn btn-default btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options <span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="options-menu">
					<li><a href="{{ URL::route('forum-edit-thread', $thread->id) }}">Edit Thread</a></li>
					<li><a href="#" data-toggle="modal" data-target="#delete_modal" data-backdrop="false">Delete Thread</a></li>
				</ul>
			</div>
		@endif
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>{{ $thread->title }}<br><small>by <strong>{{ $author }}</strong> &raquo; <em>{{ date("d F Y",strtotime($thread->created_at)) }} at {{ date("g:ha",strtotime($thread->created_at)) }}</em></small></h4>
		</div>
		<div class="panel-body">
			{{ BBCode::parse($thread->body) }}
			@if($thread->updated_at != $thread->created_at)
			<br><small>Last edited by <strong>{{ $author }}</strong> on <em>{{ date("d F Y",strtotime($thread->updated_at)) }} at {{ date("g:ha",strtotime($thread->updated_at)) }}</em></small>
			@endif
		</div>
	</div>

	@foreach($thread->comments()->get() as $comment)
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h4 class="pull-left">Re: {{ $comment->thread->title }}<br><small>by <strong>{{ $comment->author->username }}</strong> &raquo; <em>{{ date("d F Y",strtotime($comment->created_at)) }} at {{ date("g:ha",strtotime($comment->created_at)) }}</em></small></h4>
				@if(Auth::check() && Auth::user()->isAdmin())
					<a href="{{ URL::route('forum-delete-comment', $comment->id) }}" class="btn btn-danger pull-right">Delete</a>
				@endif
			</div>
			<div class="panel-body">
				{{ BBCode::parse($comment->body) }}
				@if($comment->updated_at != $comment->created_at)
				<br><small>Last edited by <strong>{{ $comment->author->username }}</strong> on <em>{{ date("d F Y",strtotime($comment->updated_at)) }} at {{ date("g:ha",strtotime($comment->updated_at)) }}</em></small>
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