@extends('layouts.master')

@section('head')
	@parent
	<title>Edit: {{ $thread->title }}</title>
@stop

@section('content')
	<ol class="breadcrumb">
		<li><a href="{{ URL::route('forum-home') }}">Forum</a></li>
		<li><a href="{{ URL::route('forum-category', $thread->category->id) }}">{{ $thread->category->title }}</a></li>
		<li class="active">Edit: {{ $thread->title }}</li>
	</ol>

	<h1>Edit: {{ $thread->title }}</h1>

	{{ Form::model($thread, array('route' => array('forum-edit-thread', $thread->id))) }}    

		{{ Form::openGroup('title', 'Title:') }}
	        {{ Form::text('title') }}
	    {{ Form::closeGroup() }}

	    {{ Form::openGroup('body', 'Body:') }}
	        {{ Form::textarea('body', null, array('rows' => '5')) }}
	    {{ Form::closeGroup() }}

	    <p>{{ Form::submit('Save Thread', array('class' => 'btn btn-primary')) }}<p>

    {{ Form::close() }}
@stop