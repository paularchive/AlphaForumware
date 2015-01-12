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
	<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="/js/semantic.js"></script>
	@show
</head>
<body>

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
