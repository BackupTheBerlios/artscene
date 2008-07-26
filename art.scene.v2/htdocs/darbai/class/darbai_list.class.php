<?
//js, 2004.08.05

//!! darbai
//! userside sarasai pirmame psulapyje

include_once($RELPATH . $COREPATH . 'avcolumn.class.php');
include_once($RELPATH . $COREPATH . 'avnavigator.class.php');

class darbai_list extends avColumn
{
	var $version = '$Id: darbai_list.class.php,v 1.5 2008/07/26 21:12:02 pukomuko Exp $';

	var $table = 'avworks';

	var $result = '';
	var $error = '';
	var $flash_category = 6;
	var $thumb_x = 120;
	var $thumb_y = 90;

	function darbai_list()
	{
		avColumn::constructor();
	}


	function get_index_new($limit = 8)
	{
		return $this->db->get_result("SELECT w.id AS id, subject, w.submiter AS user_id, w.thumbnail, DATE_FORMAT(posted, '%Y.%m.%d') AS posted, DATE_FORMAT(posted, '%a, %d %b %Y %H:%i:%s GMT') AS posted_rfc, u.username AS username, wc.name AS category, category_id, w.info
			FROM avworks w, u_users u, avworkcategory wc
			WHERE w.submiter=u.id AND w.category_id=wc.id
			ORDER BY posted DESC, id DESC LIMIT $limit");
	}

	function get_index_new_user($user, $limit = 10)
	{
		return $this->db->get_result("SELECT w.id AS id, subject, w.submiter AS user_id, w.thumbnail, DATE_FORMAT(posted, '%Y.%m.%d') AS posted, DATE_FORMAT(posted, '%a, %d %b %Y %H:%i:%s GMT') AS posted_rfc, u.username AS username, wc.name AS category, category_id, w.info
			FROM avworks w, u_users u, avworkcategory wc
			WHERE w.submiter=u.id AND w.category_id=wc.id AND u.id = '$user'
			ORDER BY posted DESC, id DESC LIMIT $limit");
	}

	function get_top($limit = 4)
	{
/*		$statement = "SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, w.submiter AS user_id, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username, wc.name AS category, category_id, thumbnail
			FROM avworkvotes v, avworks w, u_users u, avworkcategory wc
			WHERE v.work_id=w.id AND u.id=w.submiter AND w.category_id=wc.id AND
				DATE_SUB( NOW(), INTERVAL 7 DAY ) < v.posted
			GROUP BY w.id
			ORDER BY summark DESC, avgmark DESC, w.score DESC
			LIMIT $limit
		";
*/
		// plusam plusam optimizuojam /tm
		$statement = "SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
				w.id AS id, subject, w.submiter AS user_id, 
				DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted, 
				u.username AS username, wc.name AS category, category_id, thumbnail
			FROM avworkvotes v
				LEFT JOIN avworks w ON v.work_id=w.id 
				LEFT JOIN u_users u ON u.id=w.submiter
				LEFT JOIN avworkcategory wc ON w.category_id=wc.id
			WHERE DATE_SUB( NOW(), INTERVAL 7 DAY ) < v.posted
			GROUP BY w.id
			ORDER BY summark DESC, avgmark DESC, w.score DESC
			LIMIT $limit
		";
		
		$result = $this->db->cached_select('top', $statement, array('avworkvotes', 'avworks', 'u_users', 'avworkcategory'), 12000);
		
		$out = array();
		for ($i = 0; isset($result[$i]); $i++)
		{
			isset($result[$i]['avgmark']) || $result[$i]['avgmark'] = 0;
			isset($result[$i]['summark']) || $result[$i]['summark'] = 0;
			$result[$i]['avgmark'] = round($result[$i]['avgmark'], 1);
		}	

		return $result;
	}

	function show_index_new()
	{
		$this->tpl->set_var('works_thumbs_url', $this->ini->read_var('avworks', 'thumbnails_url'));

		$list = $this->get_index_new();
		$this->tpl->set_file('darbai_temp', 'darbai/tpl/index_new.html');

		$this->tpl->set_loop('list', $list);

		return $this->tpl->process('out', 'darbai_temp', 2);

	}

	function show_rss_new()
	{
		$list = $this->get_index_new(10);
		$this->tpl->set_file('xml', 'darbai/tpl/rss-new.xml');
		$this->tpl->set_loop('list', $list);

		header('Content-type: text/xml');
		echo $this->tpl->process('out', 'xml', 2);
		exit;
	}

	function show_rss_new_user()
	{
		global $user, $g_usr;

		empty($user) && die ("ERROR");

		$list = $this->get_index_new_user($user);
		$info = $g_usr->get_info($user);

		$this->tpl->set_file('xml', 'darbai/tpl/rss-user.xml');
		$this->tpl->set_loop('list', $list);
		$this->tpl->set_var('info', $info);

		header('Content-type: text/xml');
		echo $this->tpl->process('out', 'xml', 2);
		exit;
	}


	function show_index_top()
	{
		$this->tpl->set_var('works_thumbs_url', $this->ini->read_var('avworks', 'thumbnails_url'));

		$list = $this->get_top(5);

		$this->tpl->set_file('darbai_temp', 'darbai/tpl/index_top.html');

		$this->tpl->set_loop('list', $list);

		return $this->tpl->process('out', 'darbai_temp', 2);

	}

	function show_top_xml()
	{
		$list = $this->get_top(10);
		$this->tpl->set_file('xml', 'darbai/tpl/exporttop.xml');
		$this->tpl->set_loop('list', $list);

		echo $this->tpl->process('out', 'xml', 2);
		exit;
	}

	function get_fresh_works($count)
	{
/*		$sql = "SELECT w.id AS id, w.subject, w.submiter AS user_id, w.thumbnail, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted, u.username AS username, DATE_FORMAT(max(c.posted), '%Y.%m.%d %H:%i') as last_post
			FROM avcomments c, avworks w, u_users u
			WHERE c.table_name='avworks' AND w.id=c.parent_id AND w.submiter=u.id
			GROUP BY w.id
			ORDER BY last_post DESC 
			LIMIT $count"; */
		// optimizuojam optimizuojam, nemiegam /tm
		$sql = "SELECT w.id AS id, w.subject, w.submiter AS user_id, w.thumbnail, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted, u.username AS username, DATE_FORMAT(max(c.posted), '%Y.%m.%d %H:%i') as last_post
			FROM avcomments c
				RIGHT JOIN avworks w ON c.parent_id=w.id AND c.table_name='avworks'
				LEFT JOIN u_users u ON u.id=w.submiter
			GROUP BY w.id
			ORDER BY last_post DESC 
			LIMIT $count";



		return $this->db->cached_select('comments', $sql, array('avworks', 'u_users','avcomments'), 6000);
	}

	function show_fresh_works()
	{
		global $g_ini;

		$list = $this->get_fresh_works($g_ini->read_var('avworks', 'fresh_count'));

		$this->tpl->set_loop('list', $list);

		$this->tpl->set_file('temp', 'darbai/tpl/fresh_list.html', 1);

		return $this->tpl->process('', 'temp', 1);
	}
}

?>
