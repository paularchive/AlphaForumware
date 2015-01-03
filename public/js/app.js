$(document).ready(function ()
{

	$('.group-confirm-btn').click(function ()
	{
		$('#group_modal form').submit();
	});

	$('.group-edit-confirm-btn').click(function ()
	{
		$('#group_edit form').submit();
	});

	$('.category-confirm-btn').click(function ()
	{
		$('#category_modal form').submit();
	});

	$('.category-edit-confirm-btn').click(function ()
	{
		$('#category_edit form').submit();
	});

	$('[data-function="new.category"]').click(function ()
	{
		var id = $(this).attr('data-id');
		$('#category_modal form').prop('action', '/forum/category/'+id+'/new');
	});

	$('[data-function="delete.btn"]').click(function()
	{
		var id = $(this).attr('data-id');
		var what = $(this).attr('data-what');
		$('#delete_modal a').prop('href', '/forum/'+what+'/'+id+'/delete');
		console.log('launched');
	});

	$('[data-function="edit.group"]').click(function(e) 
	{
		e.preventDefault(true);
		var id = $(this).attr('data-id');
		$.ajax({
			url: '/forum/group/'+id+'/edit',
			type: 'GET',
			success: function(data) {
			console.log(data);
				$('#group_edit form').prop('action', "/forum/group/"+id+"/edit");
				$('#group_name_edit').val(data.group.title);
				$('#group_edit').modal({'backdrop': false}, 'show');
			}
		});
   });

	$('[data-function="edit.category"]').click(function(e) 
	{
		e.preventDefault(true);
		var id = $(this).attr('data-id');
		$.ajax({
			url: '/forum/category/'+id+'/edit',
			type: 'GET',
			success: function(data) {
			console.log(data);
				$('#category_edit form').prop('action', "/forum/category/"+id+"/edit");
				$('#category_name_edit').val(data.category.title);
				$('#category_edit').modal({'backdrop': false}, 'show');
			}
		});
   });

});