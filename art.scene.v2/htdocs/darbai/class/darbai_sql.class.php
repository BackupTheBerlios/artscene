<?

/* 
* darbø rodymo selektai
*/

class darbai_sql 
{
	var $version = '$Id: darbai_sql.class.php,v 1.9 2006/02/05 15:20:08 pukomuko Exp $';
	var $db;
	
	function darbai_sql(&$db)
	{
		$this->db =& $db;
	}


	function get_category_lookup()
	{

		$list = $this->get_simple_category_list();
		
		$ret = array();
		for($i = 0; isset($list[$i]); $i++)
		{
			$ret[ $list[$i]['id']  ]  = $list[$i]['name'];
		}

		return $ret;

	}
	function get_simple_category_list()
	{
		return $this->db->get_result("SELECT *
				FROM avworkcategory
				ORDER BY sort_number");
	}

	/**
	* kai rodom kategorijos darbø sàraðà - virðuje parodoma kategorijos info
	*/
	function get_category_info($id)
	{
		return $this->db->get_array("SELECT * FROM avworkcategory WHERE id=$id");
	}

	/**
	* kiek darbø yra su nurodytais parametrais.
	* dabar reikia perkelti
	*/
	function get_full_list_count($category = false, $search = false, $user = false)
	{
		$where = "";
		if ($category && ('favourites' != $category)) {$where .= " AND category_id = '$category' "; }
		if ($user && ('favourites' != $category)) {$where .= " AND submiter = '$user' "; }
		if ($search) { $where .= " AND (w.subject LIKE '%$search%' OR w.info LIKE '%$search%') "; }
		if ('favourites' != $category)
		{
			$tmp = $this->db->get_array("SELECT COUNT(*) as count FROM avworks_stat w WHERE id!=0 $where" );
		}
		else
		{
			$tmp = $this->db->get_array("SELECT COUNT(w.id) as count FROM avworks w LEFT JOIN avworkvotes v ON (v.work_id=w.id)  WHERE v.user_id='$user' AND v.mark=5 $where" );

		}
		return $tmp['count'];
	}

	function get_full_list($category = false, $offset = 0, $count = 1000000, $search = false, $order = false, $user = false, $near = false, $work_info = false)
	{

		$kryptis = 'DESC';
		$zenklas = '<';

		if ($near == 'back') {
			$kryptis = 'ASC';
			$zenklas = '>';
		}

		$near_where = "";
		switch ($order)
		{
			case 'mark': $order = " vote_avg $kryptis, id $kryptis ";
						 $near_where = " AND vote_avg $zenklas $work_info[avgmark] AND w.work_id != $work_info[id]"; break;
			case 'summark': $order = " vote_sum $kryptis, avgmark $kryptis, id $kryptis "; 
							$near_where = " AND vote_sum $zenklas $work_info[summark] AND w.work_id != $work_info[id]"; break;
			case 'views': $order = " w.views $kryptis, id $kryptis "; 
						  $near_where = " AND views $zenklas $work_info[views] AND w.work_id != $work_info[id] "; break;
			case 'date':
			default: $order = " id $kryptis ";
					 $near_where = " AND w.work_id $zenklas $work_info[id] ";
		}
		$limit = " LIMIT $offset, $count ";
		$where = "";
		$group = "";
		$join = "";


		if (isset($GLOBALS['delete_view'])) { $where .= " AND DATE_ADD(w.posted, INTERVAL 7 DAY) < NOW() "; }

		if ('favourites' == $category) 
		{ 
			$where .= " AND v.user_id='$user' AND v.mark=5 "; 
			$group = " GROUP BY w.work_id ";
			$join = "LEFT JOIN avworkvotes v ON (w.work_id = v.work_id)";
		} elseif ($category) 
		{ 
			$where .= " AND w.category_id = $category "; 
		}

		if ($user && ('favourites' != $category) ) { $where .= " AND w.submiter = '$user' "; }
		if ($search) { $where .= " AND (w.subject LIKE '%$search%' OR w.info LIKE '%$search%') "; }

		$ts = getmicrotime();
		

		if (!$near) $near_where = '';
		
		$statement = "SELECT w.work_id AS id, w.subject AS subject, w.info AS info, w.file AS file, w.thumbnail AS thumbnail, w.posted, w.category_id, w.views, ROUND((w.file_size / 1024)) AS filesize, color,
			w.submiter AS user_id, w.submiter_name AS nick, w.category_name AS category,
			vote_count AS votes,  vote_sum AS summark, vote_avg AS avgmark, comment_count AS comments

			FROM avworks_stat w $join
			WHERE 1=1  $where  $near_where
			$group
			ORDER BY $order
			$limit";

		$result = $this->db->get_result( $statement );
		//$result = $this->db->cached_select('works', $statement, array('avworks', 'avworkvotes', 'u_users','avworkcategory'), 6000);
		if (isset($GLOBALS['bench'])) { echo "<br>checkpoint0: " . round((getmicrotime() - $ts), 2);}	

		
		if (isset($GLOBALS['delete_view']))
		{
			$out = array();
			for ($i = 0; isset($result[$i]); $i++)
			{
				if ($result[$i]['avgmark'] < -1) { $out[] = $result[$i]; }
			}

			$result = $out;
		}

		return $result;
	}


	/**
	* jei cia mano darbas - negaliu balsuoti
	*/
	function own_work($id)
	{
		global $g_user_id;
		$this->db->query("SELECT * FROM avworks WHERE submiter='$g_user_id' AND id='$id' LIMIT 1");
		return $this->db->not_empty();
	}

	/**
	* gal jau balsavo
	*/
	function has_voted_on($id, $my_vote = false)
	{
		global $g_user_id;
		$my_vote = 0;
		$result = $this->db->get_array("SELECT mark FROM avworkvotes WHERE user_id='$g_user_id' AND work_id='$id' LIMIT 1");
		if (!$result) return false;
		$my_vote = $result['mark'];
		return true;
	}

	/**
	* pasiþymim, kad ivyko darbo perþiûra
	* á stat lentelæ ateis per kità darbo perþiûrà
	*/
	function register_view($id)
	{
		$this->db->query("UPDATE LOW_PRIORITY avworks SET views=views+1 WHERE id='$id'");
		$this->db->query("UPDATE LOW_PRIORITY avworks_stat SET views=views+1 WHERE work_id='$id'");
	}

	/**
	* komentaru sarasas
	*/
	function get_comments($pid)
	{
		return $this->db->get_result("SELECT c.subject AS subject, u.username AS username, user_id, c.info AS info, DATE_FORMAT(posted, '%Y.%m.%d %H:%i') AS posted
			FROM avcomments c, u_users u
			WHERE c.parent_id='$pid' AND c.user_id=u.id AND c.table_name='avworks'
			ORDER BY posted ASC, c.id ASC");
	}

	/**
	* balsavimu sarasas
	*/
	function get_voting($pid)
	{
		return $this->db->get_result("SELECT u.username AS username, user_id, mark, DATE_FORMAT(posted, '%Y.%m.%d&nbsp;%H:%i') AS posted, IF(DATE_ADD(v.posted, INTERVAL 7 DAY) > NOW(), 'dark', 'light') AS class
			FROM avworkvotes v, u_users u
			WHERE v.work_id='$pid' AND v.user_id=u.id
			ORDER BY posted ASC, v.id ASC");
	}
	
	/**
	* informacija apie darba
	*/
	function get_info($id)
	{
		return $this->db->get_array("SELECT w.id AS id, subject, color, w.submiter AS user_id, w.file, w.thumbnail, DATE_FORMAT(posted, '%Y.%m.%d') AS posted, w.info AS info, u.username AS username,ROUND((file_size / 1024)) AS filesize, wc.name AS category, category_id, score, views
			FROM avworks w, u_users u, avworkcategory wc
			WHERE w.id='$id' AND w.submiter=u.id AND w.category_id=wc.id");
	}

	/**
	* keðuota darbo informacija
	*/
	function get_work_stat_info($id)
	{
		return $this->db->get_array("SELECT *, ROUND((file_size / 1024)) AS filesize FROM avworks_stat WHERE work_id='$id'");

	}

	/**
	* patikrinam ar tikrose lentelëse kas nors pasikeitë ir tada updatinam stat lentelæ
	*/
	function update_work_stat($work, $info, $ws_info, $comment_count, &$voting)
	{
		$update = false;

		if ($info['subject'] != $ws_info['subject']) $update = true;
		if ($info['info'] != $ws_info['info']) $update = true;
		if ($info['thumbnail'] != $ws_info['thumbnail']) $update = true;
		if ($info['file'] != $ws_info['file']) $update = true;
		if ($info['views'] != $ws_info['views']) $update = true;
		if ($info['color'] != $ws_info['color']) $update = true;
		if ($info['username'] != $ws_info['submiter_name']) $update = true;
		if ($info['category'] != $ws_info['category_name']) $update = true;
		if ($info['category_id'] != $ws_info['category_id']) $update = true;

		if ($ws_info['comment_count'] != $comment_count) $update = true;

		if ($ws_info['vote_count'] != count($voting)) $update = true;

		$count = count($voting);
		$sum = 0;
		for($i = 0; isset($voting[$i]); $i++) $sum += $voting[$i]['mark'];
		$count ? $avg = round($sum / $count, 1) : $avg = 0;
		if ($ws_info['vote_sum'] != $sum) $update = true;
		if ($ws_info['vote_avg'] != $avg) $update = true;
		
		$info['votes'] = $count;
		$info['summark'] = $sum;
		$info['avgmark'] = $avg;

		$text = addslashes($info['info']);
		$subject = addslashes($info['subject']);

		if ($update) 
		{
			$this->db->query("UPDATE avworks_stat 
			SET subject='$subject', info='$text', thumbnail='$info[thumbnail]', file='$info[file]', views='$info[views]', color='$info[color]', submiter_name='$info[username]', category_name='$info[category]', category_id='$info[category_id]', comment_count=$comment_count, vote_count=$count, vote_sum=$sum, vote_avg=$avg			
			WHERE work_id='$work'");
		}

		return $info;
	}
}

?>