<? 
/*

create table u_usage
(
	id int(11) unsigned auto_increment primary key,
	timehit timestamp(14) not null,
	ip char(30) not null,
	user char(40) not null,
	agent char(100) not null,
	page char(255) not null,
	referrer char(255) not null
);
		
*/

class usage
{
	var $startyear = '2001';
	var $tree = array();

	function usage($startyear = '2001')
	{
		global $g_db, $g_tpl;
		$this->startyear = $startyear;

		$this->db = & $g_db;
		//$this->tpl = & $g_tpl;
		$this->tpl = new avTemplate($GLOBALS['RELPATH']);

	}

	function get_years()
	{
		for ($y = $this->startyear; $y <= date('Y'); $y++)
		{
			$out[] = $y;
		}
		return $out;
	}


	function show_output()
	{
		global $stat, $year, $month, $day;
		
		isset($stat) || $stat = '';
		isset($year) || $year = date('Y');
		isset($month) || $month = date('m');
		
		$this->tpl->set_var('table_inner_name', 'usage_' . $stat);
		switch($stat)
		{
			case 'tree':
				return $this->show_tree_stat();
			case 'day':
				return $this->show_day_referers();
			case 'month':
				return $this->show_month();
			case 'year':
			case 'global':
			default: // year list // month list
				return $this->show_global();
		}
	}


	function show_month()
	{
		global $year, $month;

		$stat = $this->get_month($year, $month);

		// susirandam auksciausia ir prilyginam 100%
		$hits = 0;
		for ($i = 0; isset($stat[$i]); $i++)
		{
			$hits += $stat[$i]['visitors'];
		}

		// pereinam per visa menesi
		
		$list = array();
		$index = 0;
		for ($d = 0; $d < 31; $d++)
		{
			$day = $d + 1;
			$format = "$year.$month.$day";

			if (isset($stat[$index]) && ($stat[$index]['dayhit'] == $format) && ($stat[$index]['visitors'] > 0))
			{
				$list[$d] = $stat[$index];
				$list[$d]['day'] = $day;
				$list[$d]['percent'] = rnd2( 100*$list[$d]['visitors'] / $hits);
				$list[$d]['height'] = round($list[$d]['percent']*2);
				$index++;
			}
			else
			{
				$list[$d]['visitors'] = 0;
				$list[$d]['day'] = $day;
				$list[$d]['percent'] = 0;
				$list[$d]['height'] = 0;
			}
		}

		$this->tpl->set_var('stat_year', $year);
		$this->tpl->set_var('stat_month', $month);
		$this->tpl->set_var('total_hits', $hits);
		$this->tpl->set_loop('stat', $list);
		$this->tpl->set_loop('header', 'Lankomumas');

		$this->tpl->set_loop('stat_day', $list);

		if ($month - 1 < 1) { $prev_month = 12; } else { $prev_month = $month - 1; }
		if ($month - 1 < 1) { $prev_year = $year - 1; } else { $prev_year = $year; }
		$this->tpl->set_var('prev_month', $prev_month);
		$this->tpl->set_var('prev_year', $prev_year);

		if ($month + 1 > 12) { $next_month = 1; } else { $next_month = $month + 1; }
		if ($month + 1 > 12) { $next_year = $year + 1; } else { $next_year = $year; }
		$this->tpl->set_var('next_month', $next_month);
		$this->tpl->set_var('next_year', $next_year);


		$this->tpl->set_file('month_tpl', 'control/usage/tpl/month_stat.html', 1);

		

		return $this->tpl->process('temp', 'month_tpl', 1);

	}

	function get_month($year, $month)
	{
		$format = "$year.$month";
		return $this->db->get_result("SELECT COUNT(user) AS visitors,  DATE_FORMAT(timehit, '%Y.%m.%d') AS dayhit  
				FROM u_usage
				WHERE DATE_FORMAT(timehit, '%Y.%m') = '$format'
				GROUP BY DATE_FORMAT(timehit, '%Y.%m.%d')");
	}

	function show_day_referers()
	{
		global $year, $month, $day;

		isset($year) || $year = date('Y');
		isset($month) || $month = date('m');
		isset($day) || $day = 0;

		$stat = $this->get_referers($year, $month, $day);
		$this->tpl->set_loop('list', $stat);

		$this->tpl->set_file('stat_tpl', 'control/usage/tpl/referers_day.html', 1);

		return $this->tpl->process('temp', 'stat_tpl', 1);

	}

	function get_referers($year, $month, $day=0)
	{
		if ($day)
		{
			$format = "$year.$month.$day";
			$time = "DATE_FORMAT(timehit, '%Y.%m.%d') = '$format'";
		}
		else
		{
			$format = "$year.$month";
			$time = "DATE_FORMAT(timehit, '%Y.%m') = '$format'";
		}
	
		$this->tpl->set_var('format', $format);
		
		return $this->db->get_result("SELECT referrer, count(id) AS quantity
		FROM u_usage 
		WHERE LEFT(referrer, 4) = 'http' AND $time
		GROUP BY referrer
		ORDER BY quantity DESC");
	}

	function get_tree()
	{

		$this->tree = $this->db->get_result("
SELECT tp.id as id, fp.id as fpid, tp.timehit as timehit, tp.referrer as referrer, tp.page as page, tp.ip as ip, tp.user as user, DATE_FORMAT(tp.timehit,'%Y.%m.%d %H:%S') as hit
			FROM u_usage tp LEFT JOIN u_usage fp ON fp.page = tp.referrer
			WHERE  fp.id IS NULL OR (fp.user = tp.user AND fp.id!=tp.id AND fp.page!=fp.referrer AND fp.id < tp.id)
			GROUP BY tp.id
			ORDER BY tp.timehit
			");
	}

	function show_tree_stat()
	{
		exit;
		$this->get_tree();

		$this->tpl->set_file('tree_file', 'control/usage/tpl/tree_stat.html', 1);

		$this->tpl->set_var('header', 'Lankytojø narðymo keliai');

		for ($i = 0; isset($this->tree[$i]); $i++)
		{
			$this->tree[$i]['done'] = false;
			$this->tree[$i]['printed'] = false;
			$this->tree[$i]['sub'] = 0;
			$this->tree[$i]['parent'] = false;
		}

		for ($i = 0; isset($this->tree[$i]); $i++)
		{
			if (!$this->tree[$i]['done']) 
			{ 
				$this->tree[$i]['done'] = true;
				$this->traverse($i, 0); 
			}
		}
		

		for ($i = 0; isset($this->tree[$i]); $i++)
		{

			if (!$this->tree[$i]['printed'] && $this->tree[$i]['parent'] == '') 
			{
				
				$this->tree[$i]['printed'] = true;

				$this->tpl->set_var('tree', $this->tree[$i]);

				$this->tpl->process('tree_table', 'first_row', 0, 0, 1);

				//echo ' id='. $this->tree[$i]['id'] . ' ' . $this->tree[$i]['hit'] . " : " . $this->tree[$i]['ip'] . " // " . $this->tree[$i]['page'] ."<br>\n";

				$this->show_tree($i, 0);
			}
		}
		
		return $this->tpl->process('temp', 'tree_file');
	}

	function traverse($index, $sub)
	{
		for ($i = $index; isset($this->tree[$i]); $i++)
		{
			if (!$this->tree[$i]['done'] && $i!=$index && 
				$this->tree[$index]['page'] == $this->tree[$i]['referrer'] &&
				$this->tree[$index]['user'] == $this->tree[$i]['user'])
			{
				$this->tree[$i]['parent'] = $index;
				$this->tree[$i]['sub'] = $sub + 1;
				$this->tree[$i]['done'] = true;
				$this->traverse($i, $sub + 1);
			}
		}
	}

	function show_tree($index, $sub)
	{		

		for ($i = $index; isset($this->tree[$i]); $i++)
		{


			if (!$this->tree[$i]['printed'] && $i!=$index && 
				$index == $this->tree[$i]['parent'] && is_int($this->tree[$i]['parent']))
			{
				$this->tree[$i]['printed'] = true;
				$subas = array();
				for ($j=0; $j <= $sub; $j++)
				{
					$subas[$j]['id'] = $j;
				}

				$this->tpl->set_loop('sub', $subas);

				$this->tpl->set_var('tree', $this->tree[$i]);
				

				$this->tpl->process('tree_table', 'second_row', 1, 0, 1);

				
				//echo "- id=". $this->tree[$i]['id'] .' '. $this->tree[$i]['hit'] . " : " . $this->tree[$i]['ip'] . " // " . $this->tree[$i]['page'] ."<br>\n";

				$this->show_tree($i, $sub + 1);
			}
		}

	}

}


?>