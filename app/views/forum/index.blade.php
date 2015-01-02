@extends('layouts.master')

@section('head')
	@parent
	<title>AlphaForumware :: Forum</title>
	<style type="text/css">
	#delete_modal .modal-content{

		border: 0;
		border-radius: 0;
	}
	#delete_modal h3 {
		margin: 0;
		text-align: center;
	}
	#delete_modal .delete-confirm-btn {
		float: right;
		text-decoration: none;
		display: inline-block;
		padding: 6px 12px;
		text-align: center;
		cursor: pointer;
		border: 0;
		color: #fff;
		background-color: #d9534f;
		width: 50%;
	}
	#delete_modal .delete-confirm-btn:hover {
		background-color:#c9302c;
	}
	#delete_modal .delete-cancel-btn {
		text-decoration: none;
		display: inline-block;
		padding: 6px 12px;
		text-align: center;
		cursor: pointer;
		border: 0;
		color: #333;
		background-color: #fff;
		width: 50%;
	}
	#delete_modal .delete-cancel-btn:hover {
		background-color:#e6e6e6;
	}
	#group_modal .modal-content{

		border: 0;
		border-radius: 0;
	}
	#group_modal .modal-body {
		padding: 15px 15px 0;
	}
	#group_modal h3 {
		margin: 0;
		text-align: center;
	}
	#group_modal .group-confirm-btn {
		float: right;
		text-decoration: none;
		display: inline-block;
		padding: 6px 12px;
		text-align: center;
		cursor: pointer;
		border: 0;
		color: #fff;
		background-color: #337ab7;
		width: 50%;
	}
	#group_modal .group-confirm-btn:hover {
		background-color:#286090;
	}
	#group_modal .group-cancel-btn {
		text-decoration: none;
		display: inline-block;
		padding: 6px 12px;
		text-align: center;
		cursor: pointer;
		border: 0;
		color: #333;
		background-color: #fff;
		width: 50%;
	}
	#group_modal .group-cancel-btn:hover {
		background-color:#e6e6e6;
	}
	#category_modal .modal-content{

		border: 0;
		border-radius: 0;
	}
	#category_modal .modal-body {
		padding: 15px 15px 0;
	}
	#category_modal h3 {
		margin: 0;
		text-align: center;
	}
	#category_modal .category-confirm-btn {
		float: right;
		text-decoration: none;
		display: inline-block;
		padding: 6px 12px;
		text-align: center;
		cursor: pointer;
		border: 0;
		color: #fff;
		background-color: #337ab7;
		width: 50%;
	}
	#category_modal .category-confirm-btn:hover {
		background-color:#286090;
	}
	#category_modal .category-cancel-btn {
		text-decoration: none;
		display: inline-block;
		padding: 6px 12px;
		text-align: center;
		cursor: pointer;
		border: 0;
		color: #333;
		background-color: #fff;
		width: 50%;
	}
	#category_modal .category-cancel-btn:hover {
		background-color:#e6e6e6;
	}
	</style>
@stop

@section('content')

<ol class="breadcrumb">
	<li class="active">Forum</li>
	@if(Auth::check() && Auth::user()->isAdmin())
		<a href="#" class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#group_modal" data-backdrop="false">Add Group</a>
	@endif
</ol>



@foreach($groups as $group)
	<div class="panel panel-primary">
		<div class="panel-heading">
			@if(Auth::check() && Auth::user()->isAdmin())
			<div class="clearfix">
				<h3 class="panel-title pull-left">{{ $group->title }}</h3>
				<div class="dropdown pull-right">
					<button id="options-menu" type="button" class="btn btn-default btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options <span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu" aria-labelledby="options-menu">
						<li><a href="#" data-toggle="modal" data-target="#category_modal" data-backdrop="false" data-function="new.category" data-id="{{ $group->id }}">New Category</a></li>
						<li><a href="#" data-toggle="modal" data-target="#category_edit" data-backdrop="false" data-function="edit.category" data-id="{{ $group->id }}">Edit Category</a></li>
						<li><a href="#" data-toggle="modal" data-target="#delete_modal" data-backdrop="false" data-function="delete.btn" data-id="{{ $group->id }}" data-what="group">Delete Group</a></li>
					</ul>
				</div>
			</div>
			@else
				<h3 class="panel-title">{{ $group->title }}</h3>
			@endif
		</div>
		<div class="list-group">
		@foreach($categories as $category)
			@if($category->group_id == $group->id)
				<a href="{{ URL::route('forum-category', $category->id) }}" class="list-group-item group_delete">{{ $category->title }}</a>
			@endif
		@endforeach
		</div>
	</div>
@endforeach

@if(Auth::check() && Auth::user()->isAdmin())
<div class="modal fade" id="group_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body">
				
				{{ Form::open([ 'route' => 'forum-store-group' ]) }}

				    {{ Form::openGroup('group_name', 'Group Name:') }}
				        {{ Form::text('group_name') }}
				    {{ Form::closeGroup() }}

				{{ Form::close() }}

			</div>
			<button type="button" class="group-cancel-btn" data-dismiss="modal">Cancel</button>
			<button type="button" class="group-confirm-btn" id="category_submit">Add Group</button>
		</div>
	</div>
</div>

<div class="modal fade" id="category_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body">
				
				{{ Form::open() }}

				    {{ Form::openGroup('category_name', 'Category Name:') }}
				        {{ Form::text('category_name') }}
				    {{ Form::closeGroup() }}

				{{ Form::close() }}

			</div>
			<button type="button" class="category-cancel-btn" data-dismiss="modal">Cancel</button>
			<button type="button" class="category-confirm-btn" id="category_submit">Add Category</button>
		</div>
	</div>
</div>

<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body">
				<h3>Are you shure?</h3>
			</div>
			<button class="delete-cancel-btn" type="button" data-dismiss="modal">Cancel</button>
			<a class="delete-confirm-btn">Confirm</a>
		</div>
	</div>
</div>
@endif

@stop

@section('javascript')
	@parent
	<script type="text/javascript" src="/js/app.js"></script>
	@if(Session::has('modal'))
		<script type="text/javascript">
			$('{{ Session::get('modal') }}').modal({'backdrop': false}, 'show');
		</script>
	@endif

	@if(Session::has('category-modal') && Session::has('group-id'))
		<script type="text/javascript">
			$('#category_modal form').prop('action', "/forum/category/{{ Session::get('group-id') }}/new");
			$('{{ Session::get('category-modal') }}').modal({'backdrop': false}, 'show');
		</script>
	@endif
@stop