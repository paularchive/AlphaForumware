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

	$('.delete-btn').each(function()
	{
		var _this = $(this);
		var id = $(this).attr('data-id');
		var what = $(this).attr('data-what');
		$(this).popover({placement: 'left', html: true, content: '<p>Are you shure?</p><a href="/forum/'+what+'/'+id+'/delete" class="btn btn-warning btn-sm">Confirm</a>'});
		$(this).popover();
		$(this).on('click', function(e)
		{
			e.preventDefault(true);
		});
	});

});