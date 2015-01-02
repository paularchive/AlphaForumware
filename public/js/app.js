$(document).ready(function ()
{

	$('.group-confirm-btn').click(function ()
	{
		$('#group_modal form').submit();
	});

	$('.category-confirm-btn').click(function ()
	{
		$('#category_modal form').submit();
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

});