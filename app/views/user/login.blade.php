@extends('layouts.master')

@section('head')
	@parent
	<title>Login</title>
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
			<h1>Log In</h1>

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

			{{ Form::open([ 'route' => 'user.login' ]) }}

				<div class="field{{ ($errors->has('email')) ? ' error' : '' }}">
					<label for="email">Username: </label>
					{{ Form::text('email', null, array('placeholder' => 'someone@example.com' )) }}
				</div>

				<div class="field{{ ($errors->has('pass1')) ? ' error' : '' }}">
					<label for="pass1">Password: </label>
					{{ Form::password('pass1') }}
				</div>
				
				<div class="inline field">
					<div class="ui checkbox">
						{{ Form::checkbox('remember'); }}
						<label>Remember me</label>
					</div>
				</div>

			    <p id="submitbtn">{{ Form::submit('Log In', array('class' => 'ui button blue')) }}</p>

			{{ Form::close() }}

		</div>
	</div>
@stop

@section('javascript')
	@parent
	<script type="text/javascript">
		$('.ui.checkbox').each(function() {
			$(this).checkbox();
		});
	</script>
@stop
