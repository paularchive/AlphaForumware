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
		$(this).popover({placement: 'left', html: true, content: '<p>Are you shure?</p><a href="/forum/'+what+'/'+id+'/delete" class="btn btn-warning btn-sm">Confirm</a><button class="btn btn-default delete-btn-close btn-sm">Cancel</button>'});
		$(this).popover();
		$(this).on('click', function(e)
		{
			e.preventDefault(true);
		});

		$('.delete-btn-close').each(function()
		{
			$(this).click(function()
			{
			console.log('True');
			$(_this).popover('destroy');
			alert(_this);
			});
		});
	});

});