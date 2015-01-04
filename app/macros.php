<?php
HTML::macro('menu_active', function($route, $matchExact = false)
{
	if($matchExact && Request::is($route))
	{
		$active = ' active';
	}
	elseif(!$matchExact && (Request::is($route . '/*') || Request::is($route)))
	{
		$active = ' active';
	}
	else
	{
		$active = "";
	}

	return $active;
});