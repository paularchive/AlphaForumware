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

@if(Auth::check())
<div class="row">
	<div class="eight wide column">
		<a href="{{ URL::route('forum-new-comment', $thread->slug) }}" class="ui vertical animated teal button">
			<div class="visible content">Reply</div>
			<div class="hidden content">
				<i class="reply icon"></i>
			</div>
		</a>
	</div>
	@if(Auth::user()->isAdmin() || Auth::user()->id == $thread->author_id)
	<div class="right aligned eight wide column">
		<div class="ui buttons">
			<a href="{{ URL::route('forum-edit-thread', $thread->slug) }}" class="ui button">Edit</a>
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
<div class="sixteen wide column" id="thread-comment">
	<div class="ui top attached segment thread-title">
		<div class="eight column row">
			<div class="left floated column">
			<h4>Re: {{ $comment->thread->title }}</h4><small>by <strong>{{ $comment->author->username }}</strong> &raquo; <em>{{ $comment->created_at }}</em></small>
			</div>
			@if(Auth::check() && Auth::user()->isAdmin() || Auth::check() && Auth::user()->id == $thread->author_id)
			<div class="right floated column">
				<div class="ui dropdown" data-trigger="click">
					<span id="dropdown-toggle" style="opacity:0.5">
						<i class="fa fa-bars"></i>
					</span>
					<div class="menu">
						<a href="{{ URL::route('forum-edit-comment', $comment->id) }}" class="item">Edit</a>
						<a href="{{ URL::route('forum-delete-comment', $comment->id) }}" class="item">Delete</a>
					</div>
				</div>
			</div>
			<!--div class="dropdown pull-right">
				<button id="options-menu" type="button" class="btn btn-default btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options <span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="options-menu">
					<li><a href="{{ URL::route('forum-edit-comment', $comment->id) }}">Edit Comment</a></li>
					<li><a href="{{ URL::route('forum-delete-comment', $comment->id) }}">Delete Comment</a></li>
				</ul>
			</div-->
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

@if(Auth::check())
<div class="sixteen wide column">
	<a href="{{ URL::route('forum-new-comment', $thread->id) }}" class="ui vertical animated teal button">
		<div class="visible content">Reply</div>
		<div class="hidden content">
			<i class="reply icon"></i>
		</div>
	</a>
</div>
@endif

	@if(Auth::check() && Auth::user()->isAdmin() || Auth::check() && Auth::user()->id == $thread->id)
	<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body">
					<h3>Are you shure?</h3>
				</div>
				<button class="delete-cancel-btn" type="button" data-dismiss="modal">Cancel</button>
				<a href="{{ URL::route('forum-delete-thread', $thread->slug) }}" class="delete-confirm-btn">Confirm</a>
			</div>
		</div>
	</div>
	@endif
@stop

@section('javascript')
	@parent
	<script type="text/javascript">
	$('#thread-comment').each(function() {
		$(this).hover(function() {
			$(this).find('.ui.dropdown #dropdown-toggle').animate({opacity: '1'});
		}, function() {
			$(this).find('.ui.dropdown #dropdown-toggle').animate({opacity: '0.5'});
		});
	});
	</script>
@stop