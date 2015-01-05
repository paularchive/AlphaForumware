@extends('layouts.master')

@section('head')
	@parent
	<title>Edit: {{ $thread->title }}</title>
@stop

@section('content')
<div class="sixteen wide column">
	<div class="ui breadcrumb segment" style="width: 100%;">
		<a href="{{ URL::route('forum-home') }}" class="section">Forum</a>
		<i class="right chevron icon divider"></i>
		<a href="{{ URL::route('forum-category', $thread->category->slug) }}" class="section">{{ $thread->category->title }}</a>
		<i class="right chevron icon divider"></i>
		<a href="{{ URL::route('forum-sub-category', $thread->subcategory->slug) }}" class="section">{{ $thread->subcategory->title }}</a>
		<i class="right chevron icon divider"></i>
		<div class="active section">Edit &raquo; {{ $thread->title }}</div>
	</div>
</div>
<div class="sixteen wide column">
	<div class="ui column form{{ ($errors->has()) ? ' error' : '' }}">
		<h1>Edit &raquo; {{ $thread->title }}</h1>

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

		{{ Form::model($thread, array('route' => array('forum-edit-thread', $thread->slug), 'id' => 'postform')) }}    

			<div class="field{{ ($errors->has('title')) ? ' error' : '' }}">
				<label for="username">Subject: </label>
				{{ Form::text('title') }}
			</div>

			<div class="btn-toolbar" style="margin-bottom: 5px;">
				<div class="ui icon buttons">
					<button type="button" class="ui button" onclick="bbstyle(0)" title="Bold"><i class="fa fa-bold"></i></button>
					<button type="button" class="ui button" onclick="bbstyle(2)" title="Italic"><i class="fa fa-italic"></i></button>
					<button type="button" class="ui button" onclick="bbstyle(4)" title="Underline"><i class="fa fa-underline"></i></button>
				</div>
				
				<div class="ui icon buttons">
					<button type="button" class="ui button" onclick="bbstyle(10)" title="Unordered list"><i class="fa fa-list-ul"></i></button>
					<div class="ui dropdown button" data-trigger="hover">
						<div title="Ordered list">
							<i class="fa fa-list-ol"></i> <i class="dropdown icon"></i>
						</div>
						<div class="menu">
							<div class="item" onclick="bbstyle(12)">Alphabetic</div>
							<div class="item" onclick="bbstyle(20)">Numberic</div>
						</div>
					</div>
					<button type="button" class="ui button" onclick="bbstyle(-1)" title="List item">[*]</button>
				</div>
				
				<!--select name="addbbcode20" onchange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]');this.form.addbbcode20.selectedIndex = 2;" title="Font size: [size=85]small text[/size]">
					<option value="50">Tiny</option>
					<option value="85">Small</option>
					<option value="100" selected="selected">Normal</option>
					<option value="150">Large</option>	
					<option value="200">Huge</option>
					
				</select Size doesn't work yet -->

				<div class="ui icon buttons">
					<button type="button" class="ui button" onclick="bbstyle(16)" title="Link"><i class="fa fa-link"></i></button>
					<button type="button" class="ui button" onclick="bbstyle(14)" title="Image"><i class="fa fa-picture-o"></i></button>
					<button type="button" class="ui button" onclick="bbstyle(18)" title="Youtube"><i class="fa fa-youtube-play"></i></button>
				</div>
				
				<div class="ui icon buttons">
					<button type="button" class="ui button" onclick="bbstyle(6)" title="Quote"><i class="fa fa-quote-left"></i></button>
					<button type="button" class="ui button" onclick="bbstyle(8)" title="Code"><i class="fa fa-code"></i></button>
				</div>
			</div>

			<div class="field{{ ($errors->has('body')) ? ' error' : '' }}">
				{{ Form::textarea('body', null, array('rows' => '5')) }}
			</div>

		    <p>{{ Form::submit('Save Topic', array('class' => 'ui button green')) }}</p>

		{{ Form::close() }}

	</div>
</div>
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