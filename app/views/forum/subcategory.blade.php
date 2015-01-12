@extends('layouts.master')

@section('head')
	@parent
	<title>Forum | {{ $subcategory->title }}</title>
@stop

@section('content')

<div class="sixteen wide column">
	<div class="ui breadcrumb segment" style="width: 100%;">
		<a href="{{ URL::route('forum-home') }}" class="section">Forum</a>
		<i class="right chevron icon divider"></i>
		<a href="{{ URL::route('forum-category', $subcategory->category->slug) }}" class="section">{{ $subcategory->category->title }}</a>
		<i class="right chevron icon divider"></i>
		<div class="active section">{{ $subcategory->title }}</div>
	</div>
</div>

@if(Sentry::check())
<div class="sixteen wide column">
	<a href="{{ URL::route('forum-get-new-thread', $subcategory->slug) }}" class="ui fade animated orange button">
		<div class="visible content">Post a new topic</div>
		<div class="hidden content">
			<i class="right arrow icon"></i>
		</div>
	</a>
</div>
@endif

<div class="sixteen wide column">
	<div class="ui blue inverted top attached segment">
		{{ $subcategory->title }}
	</div>
	<div class="ui link divided items attached segment">
	@foreach($threads as $thread)
		<a href="{{ URL::route('forum-thread', $thread->slug) }}" class="item">
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