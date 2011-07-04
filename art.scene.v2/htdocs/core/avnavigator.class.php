<?

class avNavigator
{
	var $template = '';

	function avNavigator($template = '')
	{
		$this->template = $template;
	}

	static function show($offset, $count, $ipp, $class, &$caller, $function, $step = false, $window = false)
	{

		$current_page = floor($offset / $ipp) + 1;
		$last =  floor(($count-1) / $ipp) + 1;

		if (!$step)
		{
			$step = 3;
			if ($last > 20) { $step = 5; $window = 2; }
			if ($last > 50) { $step = 10; $window = 2; }
			if ($last > 100) { $step = 20; $window = 4; }
			if ($last > 300) { $step = 30; $window = 5; }
			if ($last > 400) { $step = 40; $window = 6; }
			if ($last > 500) { $step = 50; $window = 6; }
			if ($last > 900) { $step = 100; $window = 7; }
			if ($last > 1300) { $step = 150; $window = 7; }
			if ($last > 1500) { $step = 200; $window = 7; }
		}

		if (!$window) $window = 2;

		
		$pages[0] = true;
		$pages[1] = true;
		$pages[$last] = true;

		for ($i = 1; $i <= $last; $i++)
		{
			if (!($i % $step)) { $pages[$i] = true; }
		}

		for ($i = $current_page - $window; $i < $current_page + $window + 1; $i++)
		{
			$pages[$i] = true;
		}


		$link = $caller->$function( ($current_page - 2) * $ipp );

		
		$out = '';

		if (1 == $current_page)
		{
			$out = '';
		}
		else
		{
			$out = "<a href='$link' class='$class'>&lt;&lt;</a>";
		}


		for ($i = 1; $i <= $last; $i++)
		{

			
			if (isset($pages[$i]) && isset($pages[$i-1]))
			{
				if ($i == $current_page)
				{
					$out .= " <b>$i</b>";
				}
				else
				{
					$link = $caller->$function(($i - 1) * $ipp);
					$out .= " <a href='$link'  class='$class'>$i</a>";
				}
			}
			elseif(isset($pages[$i]))
			{
				$link = $caller->$function(($i - 1) * $ipp);
				$out .= " &middot;&middot;&middot; <a href='$link'  class='$class'>$i</a>";
			}

		}

		$link = $caller->$function(($current_page ) * $ipp);

		if (($last == $current_page) || !$count)
		{
			$out .= '';
		}
		else
		{
			$out .= " <a href='$link'  class='$class'>&gt;&gt;</a>";
		}

		$out .= "&nbsp;[viso:&nbsp;$count]";
		
		return $out;
		
	}
}
?>