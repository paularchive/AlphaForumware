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
		<div data-func="addcategory" class="ui purple button">Add category</div>
	</div>
@endif

<div class="sixteen wide column">
@foreach($categories as $category)
	<div class="ui blue inverted top attached segment">
		<a href="{{ URL::route('forum-category', $category->slug) }}">{{ $category->title }}</a>
	</div>
	<div class="ui link divided items attached segment">
	@foreach($subcategories as $subcategory)
		@if($subcategory->group_id == $category->id)
		<a href="{{ URL::route('forum-sub-category', $subcategory->slug) }}" class="item">
			<!--div class="ui tiny image">
					<img src="topic.jpg">
			</div-->
			<div class="content">
				<div class="header">{{ $subcategory->title }}</div>
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
	<script type="text/javascript">
	$('[data-func="addcategory"]').each(function() {
		$(this).popup({
			html 	: 	'{{ Form::open([ 'route' => 'forum-store-group', 'class' => 'ui form' ]) }}'+
							'<div class="field{{ ($errors->has('group_name')) ? ' error' : '' }}">'+
								'<div class="ui action input">'+
									'{{ Form::text('group_name', null, array('placeholder' => 'Category Name' )) }}'+
									'<div class="ui button" onclick="$(this).parent().parent().parent().submit()">Add</div>'+
								'</div>'+
							@if($errors->has('group_name'))
								'<div class="ui pointing label">{{ $errors->first('group_name') }}</div>'+
							'</div>'+
							@else
							'</div>'+
							@endif
						'</form>',
			on		: 'click',
			position: 'right center'
		});

		@if(Session::has('adderror'))
		$(this).popup('show');
		@endif
	});
	</script>

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