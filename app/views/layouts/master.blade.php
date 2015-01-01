<!doctype html>
<html lang="en">
<head>
	@section('head')
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/style.css">
	@show
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="{{ URL::route('home') }}" class="navbar-brand">Forum (Laravel 4.2)</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li{{ HTML::menu_active('/', true) }}><a href="{{ URL::route('home') }}">Home</a></li>
					<li{{ HTML::menu_active('forum') }}><a href="{{ URL::route('forum-home') }}">Forum</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if(!Auth::check())
						<li{{ HTML::menu_active('user/create') }}><a href="{{ URL::route('getCreate') }}">Register</a></li>
						<li{{ HTML::menu_active('user/login') }}><a href="{{ URL::route('getLogin') }}">Login</a></li>
					@else
						<li><a href="{{ URL::route('getLogout') }}">Logout</a></li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		@if(Session::has('success'))
			<div class="alert alert-success">{{ Session::get('success') }}</div>
		@elseif(Session::has('info'))
			<div class="alert alert-info">{{ Session::get('info') }}</div>
		@elseif(Session::has('fail'))
			<div class="alert alert-danger">{{ Session::get('fail') }}</div>
		@endif

		@yield('content')
	</div>
	
	@section('javascript')
	<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript">
	$('.alert').each(function()
	{
		$(this).delay(10000).fadeOut('fast', function() {$(this).remove();});
	});
	</script>
	@show
</body>
</html>
