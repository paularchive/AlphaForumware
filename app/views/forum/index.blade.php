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
		<div data-func="modal" data-target="#newcat" class="ui purple button">Add category</div>
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

@if(Auth::check() && Auth::user()->isAdmin())
<div class="ui modal" id="newcat">
	<i class="close icon"></i>
	<div class="header">
		Modal Title
	</div>
	<div class="content">
		<div class="image">
		An image can appear on left or an icon
		</div>
		<div class="description">
		A description can appear on the right
		</div>
	</div>
	<div class="actions">
		<div class="ui button">Cancel</div>
		<div class="ui button">OK</div>
	</div>
</div>
@endif

@section('javascript')
	@parent
	<script type="text/javascript" src="/js/app.js"></script>
	<script type="text/javascript">
	$('[data-func]').each(function() {
		var func= $(this).attr('data-func');
		var target = $(this).attr('data-target');
		if(func == 'modal') {
			$(this).popup({
    			title   : 'Popup Title',
    			html 	: 	'{{ Form::open([ 'route' => 'forum-store-group', 'class' => 'ui form' ]) }}'+
    						'<div class="field">'+
							'<label for="category">Category name: </label>'+
							'{{ Form::text('group_name') }}'+
							'</div>'+
							'{{ Form::submit('Submit', array('class' => 'ui button small')) }}'+
    						'</form>',
    			on		: 'click'
  			});
		}
	});
	</script>
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