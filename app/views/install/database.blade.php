@extends('layouts.install')

@section('head')
	@parent
	<title>Install Wizard &middot; Setup Database</title>
@stop

@section('content')
<div class="sixteen wide column">
	<div class="ui four steps">
		<a class="step" href="{{ URL::route('install.index') }}">
			<div class="content">
				<div class="title">Welcome</div>
			</div>
		</a>
		<div class="active step">
			<div class="content">
				<div class="title">Setup database</div>
			</div>
		</div>
		<div class="disabled step">
			<div class="content">
				<div class="title">Connect to database</div>
			</div>
		</div>
		<div class="disabled step">
			<div class="content">
				<div class="title">Create SuperUser</div>
			</div>
		</div>
	</div>
</div>

<div class="two column row">
	<div class="four wide column">
		<div class="ui vertical teal menu">
			<a class="active item">
				Welcome
				<div class="ui green label">done</div>
			</a>
			<a class="active item">
				Setup database
			</a>
			<a class="item">
				Connect to database
			</a>
			<a class="item">
				Create SuperUser
			</a>
		</div>
	</div>

	<div class="twelve wide column">
		{{ Form::open([ 'route' => 'install.database', 'class' => 'ui form']) }}
		<div class="ui top attached segment">
			Setup Database
		</div>
		<div class="ui attached segment">

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

			<div class="field{{ ($errors->has('host')) ? ' error' : '' }}">
				<label for="host">Host: </label>
				{{ Form::text('host', null, array('placeholder' => 'localhost' )) }}
			</div>

			<div class="field{{ ($errors->has('database')) ? ' error' : '' }}">
				<label for="database">Database: </label>
				{{ Form::text('database', null, array('placeholder' => 'forum' )) }}
			</div>

			<div class="field{{ ($errors->has('username')) ? ' error' : '' }}">
				<label for="username">Username: </label>
				{{ Form::text('username', null, array('placeholder' => 'root' )) }}
			</div>

			<div class="field{{ ($errors->has('password')) ? ' error' : '' }}">
				<label for="password">Password: </label>
				{{ Form::password('password') }}
			</div>


			{{ Form::close() }}
		</div>
	</div>

	<div class="right aligned sixteen wide column">
		<a href="#" class="ui button submit">Next</a>
	</div>

</div>

@stop

@section('javascript')
	@parent
	<script type="text/javascript">
	$('.submit').click(function(e) {
		e.preventDefault(true);
		$('form').submit();
	})
	</script>
@stop