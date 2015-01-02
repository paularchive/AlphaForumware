@extends('layouts.master')

@section('head')
	@parent
	<title>Register</title>
	<style type="text/css">
	input[type=submit] {
		width: 100%;
	}
	h1 {
		text-align: center;
	}
	p {
		text-align: center;
	}
	@media (min-width: 768px) {
		.content {
			width: 40%;
			margin: 0 auto 0;
		}
		input[type=submit] {
			width: 70%;
		}
	}
	</style>
@stop

@section('content')
	<div class="content">
		<h1>Register</h1>

		{{ Form::open([ 'route' => 'postCreate' ]) }}

		    {{ Form::openGroup('username', 'Username:') }}
		        {{ Form::text('username', null, array('placeholder' => 'AwesomeUsername55' )) }}
		    {{ Form::closeGroup() }}

		    {{ Form::openGroup('pass1', 'Password:') }}
		        {{ Form::password('pass1') }}
		    {{ Form::closeGroup() }}

		    {{ Form::openGroup('pass2', 'Confirm Password:') }}
		        {{ Form::password('pass2') }}
		    {{ Form::closeGroup() }}

		    <p>{{ Form::submit('Register', array('class' => 'btn btn-warning btn-lg')) }}</p>

		{{ Form::close() }}

	</div>


@stop