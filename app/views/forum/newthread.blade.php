@extends('layouts.master')

@section('head')
	@parent
	<title>New Thread</title>
@stop

@section('content')
	<ol class="breadcrumb">
		<li><a href="{{ URL::route('forum-home') }}">Forum</a></li>
		<li><a href="{{ URL::route('forum-category', $category->id) }}">{{ $category->title }}</a></li>
		<li class="active">New Thread</li>
	</ol>

	<h1>New Thread</h1>

	<form method="post" action="{{ URL::route('forum-store-thread', $id) }}">
		<div class="form-group">
			<label for="title">Title: </label>
			<input type="text" class="form-control" name="title" id="title">
		</div>
		<div class="form-group">
			<label for="body">Body: </label>
			<textarea class="form-control" name="body" id="body"></textarea>
		</div>
		{{ Form::token() }}
		<div class="form-group">
			<input type="submit" class="btn btn-primary" value="Save Thread">
		</div>
	</form>
@stop