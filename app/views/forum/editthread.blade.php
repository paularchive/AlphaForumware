@extends('layouts.master')

@section('head')
	@parent
	<title>Edit: {{ $thread->title }}</title>
@stop

@section('content')
	<ol class="breadcrumb">
		<li><a href="{{ URL::route('forum-home') }}">Forum</a></li>
		<li><a href="{{ URL::route('forum-category', $thread->category->id) }}">{{ $thread->category->title }}</a></li>
		<li class="active">Edit: {{ $thread->title }}</li>
	</ol>

	<h1>Edit: {{ $thread->title }}</h1>

	{{ Form::model($thread, array('route' => array('forum-edit-thread', $thread->id), 'id' => 'postform')) }}    

		{{ Form::openGroup('title', 'Title:') }}
	        {{ Form::text('title') }}
	    {{ Form::closeGroup() }}

		<div class="btn-toolbar" style="margin-bottom: 5px;">
			<div class="btn-group">
				<button type="button" class="btn btn-default" onclick="bbstyle(0)" title="Bold"><i class="fa fa-bold"></i></button>
				<button type="button" class="btn btn-default" onclick="bbstyle(2)" title="Italic"><i class="fa fa-italic"></i></button>
				<button type="button" class="btn btn-default" onclick="bbstyle(4)" title="Underline"><i class="fa fa-underline"></i></button>
			</div>
			
			<div class="btn-group">
				<button type="button" class="btn btn-default" onclick="bbstyle(10)" title="Unordered list"><i class="fa fa-list-ul"></i></button>
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Ordered list"><i class="fa fa-list-ol"></i> <span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#" onclick="bbstyle(12)">Alphabetic</a></li>
						<li><a href="#" onclick="bbstyle(20)">Numberic</a></li>
					</ul>
				</div>
				<button type="button" class="btn btn-default" onclick="bbstyle(-1)" title="List item">[*]</button>
			</div>
			
			<!--select name="addbbcode20" onchange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]');this.form.addbbcode20.selectedIndex = 2;" title="Font size: [size=85]small text[/size]">
				<option value="50">Tiny</option>
				<option value="85">Small</option>
				<option value="100" selected="selected">Normal</option>
				<option value="150">Large</option>	
				<option value="200">Huge</option>
				
			</select Size doesn't work yet -->

			<div class="btn-group">
				<button type="button" class="btn btn-default" onclick="bbstyle(16)" title="Link"><i class="fa fa-link"></i></button>
				<button type="button" class="btn btn-default" onclick="bbstyle(14)" title="Image"><i class="fa fa-picture-o"></i></button>
				<button type="button" class="btn btn-default" onclick="bbstyle(18)" title="Youtube"><i class="fa fa-youtube-play"></i></button>
			</div>
			
			<div class="btn-group">
				<button type="button" class="btn btn-default" onclick="bbstyle(6)" title="Quote"><i class="fa fa-quote-left"></i></button>
				<button type="button" class="btn btn-default" onclick="bbstyle(8)" title="Code"><i class="fa fa-code"></i></button>
			</div>
		</div>

	    {{ Form::openGroup('body') }}
	        {{ Form::textarea('body', null, array('rows' => '5')) }}
	    {{ Form::closeGroup() }}

	    <p>{{ Form::submit('Save Thread', array('class' => 'btn btn-primary')) }}<p>

    {{ Form::close() }}
@stop

@section('javascript')
	@parent
	<script type="text/javascript">
	// <![CDATA[
		var form_name = 'postform';
		var text_name = 'body';
		var load_draft = false;
		var upload = false;

		// Define the bbCode tags
		var bbcode = new Array();
		var bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=a]','[/list]','[img]','[/img]','[url]','[/url]', '[youtube]', '[/youtube]', '[list=1]','[/list]');
		var imageTag = false;

	// ]]>
	</script>

	<script type="text/javascript" src="/js/editor.js"></script>

	<script type="text/javascript">
	$('.btn-group button').each(function() {
		$(this).tooltip({placement: 'top', container: 'body'});
	});
	</script>
@stop