<!doctype html>
<html lang="en">
<head>
	@section('head')
	<!-- Standard Meta -->
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<link rel="stylesheet" href="/css/semantic.css">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/main.css">
	<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="/js/semantic.js"></script>
	@show
</head>
<body>
	
	<div class="ui static large menu page grid">
		<div class="container">
			<a class="item{{ HTML::menu_active('/', true) }}" href="{{ URL::route('home') }}">
				<i class="home icon"></i> Home
			</a>
			<a class="item{{ HTML::menu_active('forum') }}" href="{{ URL::route('forum-home') }}">
				<i class="comments icon"></i> Forum
			</a>1
			<div class="right menu">
				@if(Sentry::check())
				<div class="ui dropdown item" data-trigger="hover">
					{{ Sentry::getUser()->username }} <i class="dropdown icon"></i>
					<div class="menu">
						<div class="header">
					    	<i class="fa fa-user"></i> 
					    	User Options
					    </div>
					    <div class="divider"></div>
						<a class="item">Edit Profile</a>
						<a href="{{ URL::route('getLogout') }}" class="item">Logout</a>
					</div>
				</div>
				@else
				<div class="item">
					<a href="{{ URL::route('getCreate') }}" class="ui primary button{{ HTML::menu_active('user/create') }}">Sign Up</a>
					<a href="{{ URL::route('getLogin') }}" class="ui button{{ HTML::menu_active('user/login') }}">Log In</a>
				</div>
				@endif
			</div>
		</div>
	</div>

	<main class="ui page grid">
		@if(Session::has('message'))
		<div class="sixteen wide column" style="padding:0;">
			<div class="ui{{ (Session::has('msg.type')) ? ' '.Session::get('msg.type').' ' : ' ' }} message msg">
				<div class="content">
					<div class="header">{{ Session::get('msg.header') }}</div>
					<p>{{ Session::get('msg.message') }}</p>
				</div>
			</div>
		</div>
		@endif

		@yield('content')
	</main>
	
	@section('javascript')
	<script>
	$('.ui.dropdown[data-trigger]').each(function()
	{
		var trigger = $(this).attr('data-trigger');
		$(this).dropdown({on: trigger});
	});
	</script>
	<script type="text/javascript">
	$('.msg').each(function()
	{
		var messagebox = $(this)
		setTimeout(function() {
      		messagebox.transition({
			    animation  : 'fade down',
			    onComplete : function() {
			    	messagebox.parent().remove();
			    }
			});
		}, 5000);
	});
	console.log('{{ Session::get('loginRedirect') }}');
	</script>
	@show
</body>
</html>
