@extends('layouts.master')

@section('head')
	@parent
	<title>Forum | {{ $category->title }}</title>
@stop

@section('content')

<ol class="breadcrumb">
	<li><a href="{{ URL::route('forum-home') }}">Forum</a></li>
	<li class="active">{{ $category->title }}</li>
</ol>

<div class="panel panel-primary">
	<div class="panel-heading">
		@if(Auth::check() && Auth::user()->isAdmin())
		<div class="clearfix">
			<h3 class="panel-title pull-left">{{ $category->title }}</h3>
			<a href="{{ URL::route('forum-get-new-thread', $category->id) }}" class="label label-success pull-right">New Tread</a>
			<a href="#" data-toggle="popover" id="{{ $category->id }}" class="label label-danger pull-right delete-category">Delete</a>
		</div>
		@elseif(Auth::check())
		<div class="clearfix">
			<h3 class="panel-title pull-left">{{ $category->title }}</h3>
			<a href="{{ URL::route('forum-get-new-thread', $category->id) }}" class="label label-success pull-right">New Tread</a>
		</div>
		@else
			<h3 class="panel-title">{{ $category->title }}</h3>
		@endif
	</div>
	<div class="list-group">
	@foreach($threads as $thread)
		<a href="{{ URL::route('forum-thread', $thread->id) }}" class="list-group-item group_delete">{{ $thread->title }}</a>
	@endforeach
	</div>
</div>

@if(Auth::check() && Auth::user()->isAdmin())
<div class="modal fade" id="category_delete" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Delete Category</h4>
			</div>
			<div class="modal-body">
				<h3>Are you shure you want to delete this category?</h3>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a href="#" class="btn btn-primary" id="btn_delete_category">Delete</a>
			</div>
		</div>
	</div>
</div>
@endif

@stop

@section('javascript')
	@parent
	<script type="text/javascript" src="/js/app.js"></script>
@stop