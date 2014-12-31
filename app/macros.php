<?php
HTML::macro('menu_active', function($route, $matchExact = false)
{
	if($matchExact && Request::is($route))
	{
		$active = ' class="active"';
	}
	elseif(!$matchExact && (Request::is($route . '/*') || Request::is($route)))
	{
		$active = ' class="active"';
	}
	else
	{
		$active = "";
	}

	return $active;
});