@extends('layouts.master')

@section('head')
	@parent
	<title>Register</title>
	<style type="text/css">
	.ui.grid > [class*="two column"].row > .column {
		width: 100% !important;
	}
	input[type=submit] {
		width: 100%;
	}
	h1 {
		text-align: center;
	}
	#submitbtn {
		text-align: center;
	}
	@media (min-width: 768px) {
		.ui.grid > [class*="two column"].row > .column {
			width: 50% !important;
		}
		input[type=submit] {
			width: 70%;
		}
	}
	</style>
@stop

@section('content')

	<div class="ui two column centered row">
		<div class="ui column form{{ ($errors->has()) ? ' error' : '' }}">
			<h1>Sign Up</h1>

			@if($errors->has())
				<div class="ui error message">
					<div class="header">There where some errors while submitting your information</div>
					
					<ul class="list">
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
					</ul>
				</div>
			@endif

			{{ Form::open([ 'route' => 'user.register' ]) }}

				<div class="field{{ ($errors->has('username')) ? ' error' : '' }}">
					<label for="username">Username: </label>
					{{ Form::text('username', null, array('placeholder' => 'AwesomeUsername55' )) }}
				</div>

				<div class="field{{ ($errors->has('email')) ? ' error' : '' }}">
					<label for="email">Email: </label>
					{{ Form::text('email', null, array('placeholder' => 'something@example.com' )) }}
				</div>

				<div class="field{{ ($errors->has('pass1')) ? ' error' : '' }}">
					<label for="pass1">Password: </label>
					{{ Form::password('pass1') }}
				</div>

				<div class="field{{ ($errors->has('pass2')) ? ' error' : '' }}">
					<label for="pass2">Confirm Password: </label>
					{{ Form::password('pass2') }}
				</div>

			    <p id="submitbtn">{{ Form::submit('Sign Up', array('class' => 'ui button blue')) }}</p>

			{{ Form::close() }}

		</div>
	</div>

@stop