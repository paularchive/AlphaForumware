@extends('layouts.master')

@section('head')
	@parent
	<title>Login</title>
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
		<h1>Login</h1>

		{{ Form::open([ 'route' => 'postLogin' ]) }}

		    {{ Form::openGroup('username', 'Username:') }}
		        {{ Form::text('username') }}
		    {{ Form::closeGroup() }}

		    {{ Form::openGroup('pass1', 'Password:') }}
		        {{ Form::password('pass1') }}
		    {{ Form::closeGroup() }}

		    <p>{{ Form::submit('Login', array('class' => 'btn btn-primary btn-lg')) }}<p>

		{{ Form::close() }}
	</div>
@stop
