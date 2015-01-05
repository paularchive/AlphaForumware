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
		<div class="active section">{{ $category->title }}</div>
	</div>
</div>

@if(Auth::check())
<div class="sixteen wide column">
	<a href="#" class="ui purple button">Add subcategory</a>
</div>
@endif

<div class="sixteen wide column">
	<div class="ui blue inverted top attached segment">
		{{ $category->title }}
	</div>
	<div class="ui link divided items attached segment">
	@foreach($subcategories as $subcategory)
		<a href="{{ URL::route('forum-sub-category', $subcategory->slug) }}" class="item">
			<div class="content">
				<div class="header">{{ $subcategory->title }}</div>
				<div class="description">
					<p>Description support isn't added yet!</p>
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