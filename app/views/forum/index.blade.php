@extends('layouts.master')

@section('head')
	@parent
	<title>AlphaForumware :: Forum</title>
@stop

@section('content')

<div class="sixteen wide column">
	<div class="ui breadcrumb segment" style="width: 100%;">
		<div class="active section">Forum</div>
	</div>
</div>

@if(Auth::check() && Auth::user()->isAdmin())
	<div class="sixteen wide column">
		<a href="#" class="ui button" data-toggle="modal" data-target="#group_modal" data-backdrop="false">Add Group</a>
	</div>
@endif

<div class="sixteen wide column">
@foreach($groups as $group)
	<div class="ui blue inverted top attached segment">
		{{ $group->title }}
	</div>
	<div class="ui link divided items attached segment">
	@foreach($categories as $category)
		@if($category->group_id == $group->id)
		<a href="{{ URL::route('forum-category', $category->id) }}" class="item">
			<!--div class="ui tiny image">
					<img src="topic.jpg">
			</div-->
			<div class="content">
				<div class="header">{{ $category->title }}</div>
				<div class="description">
					<p>Description support isn't added yet!</p>
				 </div>
			</div>
		</a>
		@endif
	@endforeach
	</div>
@endforeach
</div>
@stop

@section('javascript')
	@parent
	<script type="text/javascript" src="/js/app.js"></script>
	@if(Session::has('modal'))
		<script type="text/javascript">
			$('{{ Session::get('modal') }}').modal({'backdrop': false}, 'show');
		</script>
	@endif

	@if(Session::has('group-edit') && Session::has('group-id'))
		<script type="text/javascript">
			$('#group_edit form').prop('action', "/forum/group/{{ Session::get('group-id') }}/edit");
			$('{{ Session::get('group-edit') }}').modal({'backdrop': false}, 'show');
		</script>
	@endif

	@if(Session::has('category-modal') && Session::has('group-id'))
		<script type="text/javascript">
			$('#category_modal form').prop('action', "/forum/category/{{ Session::get('group-id') }}/new");
			$('{{ Session::get('category-modal') }}').modal({'backdrop': false}, 'show');
		</script>
	@endif
@stop