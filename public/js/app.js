$(document).ready(function ()
{
	$('#form_submit').click(function ()
	{
		$('#target_form').submit();
	});

	$('#category_submit').click(function ()
	{
		$('#category_form').submit();
	});

	$('.new_category').click(function (event)
	{
		var id = event.target.id;
		var pieces = id.split('-');
		$('#category_form').prop('action', '/forum/category/'+pieces[2]+'/new');
	});

	$('.delete_group').click(function (event)
	{
		$('#btn_delete_group').prop('href', '/forum/group/'+event.target.id+'/delete');
	});
	
	$('.delete_category').click(function(event)
	{
		$('#btn_delete_category').prop('href', '/forum/category/'+event.target.id+'/delete');
	});
});