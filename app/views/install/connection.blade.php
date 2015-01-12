@extends('layouts.install')

@section('head')
	@parent
	<title>Install Wizard &middot; Connection</title>
@stop

@section('content')
<div class="sixteen wide column">
	<div class="ui four steps">
		<a class="step" href="{{ URL::route('install.index') }}">
			<div class="content">
				<div class="title">Welcome</div>
			</div>
		</a>
		<a class="step" href="{{ URL::route('install.database') }}">
			<div class="content">
				<div class="title">Setup database</div>
			</div>
		</a>
		<div class="active step">
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
			<a class="active item" href="{{ URL::route('install.index') }}">
				Welcome
			</a>
			<a class="active item" href="{{ URL::route('install.database') }}">
				Setup database
			</a>
			<a class="active item">
				Connect to database
			</a>
			<a class="item">
				Create SuperUser
			</a>
		</div>
	</div>

		<div class="twelve wide column">
			<div class="ui top attached segment">
				Database Connection
			</div>
			<div class="ui attached segment">
				<div class="ui indicating progress" id="example4">
					<div class="bar">
						<div class="progress"></div>
					</div>
					<div class="label">Installing...</div>
				</div>
			</div>
		</div>

		<div class="right aligned sixteen wide column">
			<a href="#" class="ui button">Next</a>
		</div>
</div>

@stop

@section('javascript')
	@parent
	<script type="text/javascript">
	$.ajax({
		type: 'GET',
		url: '{{ URL::route('install.connection.migrateinstall') }}',
		dataType: 'json',
		beforeSend: function()
		{
			console.log('[INIT] installing migration table...');
			$('#example4').progress({
				percent: 5
			});
		},
		success: function (data)
		{
			if(data.progress !== 'error')
			{
				console.log(data.message);
				console.log(data);
				$('#example4').progress({
  					percent: data.progress
				});

				$.ajax({
					type: 'GET',
					url: '{{ URL::route('install.connection.migrate') }}',
					dataType: 'json',
					beforeSend: function()
					{
						console.log('[INIT] installing migrating...');
					},
					success: function(data)
					{
						if(data.progress !== 'error')
						{
							console.log(data.message);
							console.log(data);
							$('#example4').progress({
								percent: data.progress
							});

							$.ajax({
								type: 'GET',
								url: '{{ URL::route('install.connection.seed') }}',
								dataType: 'json',
								beforeSend: function()
								{
									console.log('[INIT] installing seeder...');
								},
								success: function(data)
								{
									console.log(data.message)
									console.log(data);
									$('#example4').progress({
  										percent: data.progress
									});
								}
							});
						}
						else
						{
							console.log('[Error] See description below.');
							console.log(data)
						}
					}
				});
			}
			else
			{
				console.log('[Error] See description below.');
				console.log(data)
			}
		}

	});
	</script>

@stop