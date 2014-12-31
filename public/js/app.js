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

	$('.delete-group').hover(function (event) //Load the popover propities onhover (don't know another way atm)
	{
		$('.delete-group').popover({placement: 'top', trigger: 'focus', html: true, content: '<p>Are you shure?</p><a href="/forum/group/'+event.target.id+'/delete" class="btn btn-warning btn-sm">Confirm</a>'});
	});
	
	$('.delete-category').hover(function(event)
	{
		$('.delete-category').popover({placement: 'top', trigger: 'focus', html: true, content: '<p>Are you shure?</p><a href="/forum/category/'+event.target.id+'/delete" class="btn btn-warning btn-sm">Confirm</a>'});
	});
});