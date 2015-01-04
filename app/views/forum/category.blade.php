@extends('layouts.master')

@section('head')
	@parent
	<title>Forum | {{ $category->title }}</title>
@stop

@section('content')

<div class="sixteen wide column">
	<div class="ui breadcrumb segment" style="width: 100%;">
		<a href="{{ URL::route('forum-home') }}" class="section">Forum</a>
		<i class="right chevron icon divider"></i>
		<a href="{{ URL::route('forum-home') }}" class="section">{{ $category->group->title }}</a>
		<i class="right chevron icon divider"></i>
		<div class="active section">{{ $category->title }}</div>
	</div>
</div>

<div class="sixteen wide column">
	<a href="{{ URL::route('forum-get-new-thread', $category->id) }}" class="ui fade animated orange button">
		<div class="visible content">Post a new topic</div>
		<div class="hidden content">
			<i class="right arrow icon"></i>
		</div>
	</a>
</div>

<div class="sixteen wide column">
	<div class="ui blue inverted top attached segment">
		{{ $category->title }}
	</div>
	<div class="ui link divided items attached segment">
	@foreach($threads as $thread)
		<a href="{{ URL::route('forum-thread', $thread->id) }}" class="item">
			<!--div class="ui tiny image">
					<img src="topic.jpg">
			</div-->
			<div class="content">
				<div class="header">{{ $thread->title }}</div>
				<div class="meta">
					<div class="created">
						<p>by <strong>{{ $thread->author()->first()->username }}</strong> &raquo; {{ $thread->created_at }}</p>
					</div>
				 </div>
			</div>
		</a>
	@endforeach
	</div>
</div>

@stop

@section('javascript')
	@parent
	<script type="text/javascript" src="/js/app.js"></script>

	@if(Session::has('category-edit') && Session::has('category-id'))
		<script type="text/javascript">
			$('#category_edit form').prop('action', "/forum/category/{{ Session::get('category-id') }}/edit");
			$('{{ Session::get('category-edit') }}').modal({'backdrop': false}, 'show');
		</script>
	@endif
@stop