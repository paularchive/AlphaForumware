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
				<div class="ui indicating progress" id="progressbar">
					<div class="bar">
						<div class="progress"></div>
					</div>
					<div class="label">Installing...</div>
				</div>

				<div class="ui secondary segment" id="console">
				</div>
			</div>
		</div>

		<div class="right aligned sixteen wide column">
			<a href="#" class="ui button disabled submit">Next</a>
		</div>
</div>

@stop

@section('javascript')
	@parent
	<script type="text/javascript">
		$('#progressbar').progress({
			text: {
      			success: 'Instalation Complete!'
      		}
		});
	</script>
	</script>
	<script type="text/javascript">
	$.ajax({
		type: 'GET',
		url: '{{ URL::route('install.connection.migrateinstall') }}',
		dataType: 'json',
		beforeSend: function()
		{
			$('#console').append('<span><span style="color:orange;font-weight:bold;">[INIT]</span> Initializing the migration files...</span><br>');
			$('#progressbar').progress({
				percent: 5
			});
		},
		success: function (data)
		{
			if(data.progress !== 'error')
			{
				$('#console').append('<span>'+data.message+'</span><br>');
				console.log(data);
				$('#progressbar').progress({
  					percent: data.progress
				});

				$.ajax({
					type: 'GET',
					url: '{{ URL::route('install.connection.migrate') }}',
					dataType: 'json',
					beforeSend: function()
					{
						$('#console').append('<span><span style="color:orange;font-weight:bold;">[INIT]</span> Initializing migrating...</span><br>');
					},
					success: function(data)
					{
						if(data.progress !== 'error')
						{
							$('#console').append('<span>'+data.message+'</span><br>');
							console.log(data);
							$('#progressbar').progress({
								percent: data.progress
							});

							$.ajax({
								type: 'GET',
								url: '{{ URL::route('install.connection.seed') }}',
								dataType: 'json',
								beforeSend: function()
								{
									$('#console').append('<span><span style="color:orange;font-weight:bold;">[INIT]</span> Initializing database seeder...</span><br>');
								},
								success: function(data)
								{
									if(data.progress !== 'error')
									{
										$('#console').append('<span>'+data.message+'</span>')
										console.log(data);
										$('#progressbar').progress({
	  										percent: data.progress,
	  										text: {
	      										success: 'Instalation Complete!'
	      									}
										});
										$('.submit').removeClass('disabled');
									}
									else
									{
										$('#console').append('<span><span style="color:red;font-weight:bold;">[ERROR]</span> See description below.</span><br>');
										$('#console').append('<span>'+data.message+'</span>')
										$('#progressbar').progress({
											percent: 0
										});
										$('#progressbar').find('.label').text('An error occured!');
									}
								}
							});
						}
						else
						{
							$('#console').append('<span><span style="color:red;font-weight:bold;">[ERROR]</span> See description below.</span><br>');
							$('#console').append('<span>'+data.message+'</span>')
							$('#progressbar').progress({
								percent: 0
							});
							$('#progressbar').find('.label').text('An error occured!');
						}
					}
				});
			}
			else
			{
				$('#console').append('<span><span style="color:red;font-weight:bold;">[ERROR]</span> See description below.</span><br>');
				$('#console').append('<span>'+data.message+'</span>')
				$('#progressbar').progress({
					percent: 0,
				});
				$('#progressbar').find('.label').text('An error occured!');
			}
		}

	});
	</script>

@stop