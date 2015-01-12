@extends('layouts.install')

@section('head')
	@parent
	<title>Install Wizard &middot; Welcome</title>
@stop

@section('content')
<div class="sixteen wide column">
	<div class="ui four steps">
		<div class="active step">
			<div class="content">
				<div class="title">Welcome</div>
			</div>
		</div>
		<div class="disabled step">
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
			</a>
			<a class="item">
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
			<div class="ui top attached segment">
				Welcome
			</div>
			<div class="ui attached segment">
				We are happy that you are using this software. It is currently under development so we can't guarantee anything. We are going to help you installing this software, just follow the steps and you will be fine. Before you are even going to begin check if you have a database supported by laravel (MySQL, SQLITE, etc.)
			</div>
		</div>

		<div class="right aligned sixteen wide column">
			<a href="{{ URL::route('install.database') }}" class="ui button">Next</a>
		</div>
</div>

@stop

@section('javascript')
	@parent
@stop