<?
/*

CREATE TABLE avworkvotes (
   id int(11) unsigned NOT NULL auto_increment,
   mark tinyint NOT NULL,
   user_id int(11) unsigned DEFAULT '0' NOT NULL,
   work_id int(11) unsigned DEFAULT '0' NOT NULL,

   posted datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,

   PRIMARY KEY (id)
);

*/


//!! darbai
//! userside
include_once($RELPATH . $COREPATH . 'avcolumn.class.php');
include_once($RELPATH . $COREPATH . 'avnavigator.class.php');


class darbai extends avColumn
{

	var $table = 'avworks';

	var $result = '';
	var $error = '';
	var $flash_category = 6;



	function darbai()
	{
		avColumn::constructor();
	}


	function get_simple_category_list()
	{
		return $this->db->get_result("SELECT *
				FROM avworkcategory
				ORDER BY sort_number");
	}

	function get_category_info($id)
	{
		return $this->db->get_array("SELECT * FROM avworkcategory WHERE id=$id");
	}



	function show_list()
	{
		global $menuname, $category, $search, $user, $order, $count, $offset, $g_usr, $g_user_id;

		$this->tpl->set_file('list_tpl', 'darbai/tpl/list.html', 1);
		isset($menuname) || $menuname = 'works_list';
		isset($category) || $category = false;
		isset($search) || $search = '';
		isset($order) || $order = false;
		isset($user) || $user = false;
		isset($offset) || $offset = 0;
		isset($count) || $count = 3;


		$count_sel[] = array('text'=>'8', 'value'=>'2');
		$count_sel[] = array('text'=>'12', 'value'=>'3');
		$count_sel[] = array('text'=>'16', 'value'=>'4');
		$count_sel[] = array('text'=>'20', 'value'=>'5');

		$sort_sel[] = array('text'=>'datà', 'value'=>'date');
		$sort_sel[] = array('text'=>'pavadinimà', 'value'=>'subject');
		$sort_sel[] = array('text'=>'kategorijà', 'value'=>'category');
		$sort_sel[] = array('text'=>'dalyvá', 'value'=>'user');
		$sort_sel[] = array('text'=>'perþiûras', 'value'=>'views');
		$sort_sel[] = array('text'=>'balus', 'value'=>'summark');
		$sort_sel[] = array('text'=>'vid. balà', 'value'=>'mark');
		$sort_sel[] = array('text'=>'taðkus', 'value'=>'score');

		
		
		$this->tpl->set_var('count_sel', html_build_select('count', $count_sel, 'value', 'text', $count, 'inputfield'));

		$this->tpl->set_var('sort_sel', html_build_select('order', $sort_sel, 'value', 'text', $order, 'inputfield'));

		$this->tpl->set_var('order', $order);
		$this->tpl->set_var('count', $count);
		$this->tpl->set_var('menuname', $menuname);
		$this->tpl->set_var('category', $category);
		$this->tpl->set_var('search', $search);
		$this->tpl->set_var('order', $order);
		$this->tpl->set_var('user', $user);
		$this->tpl->set_var('count', $count);

		switch ($menuname)
		{
			case 'works_user':
				isset($user) || redirect('/');
				$category = false;

				$count_sel = array();
				$count_sel[] = array('text'=>'6', 'value'=>'2');
				$count_sel[] = array('text'=>'9', 'value'=>'3');
				$count_sel[] = array('text'=>'12', 'value'=>'4');
				$count_sel[] = array('text'=>'15', 'value'=>'5');
				$this->tpl->set_var('count_sel', html_build_select('count', $count_sel, 'value', 'text', $count, 'inputfield'));


				$info = $g_usr->get_user_info($user);
				$this->tpl->set_var('page_title', $info['username']);
				$this->tpl->set_var('title', '');
				$this->tpl->set_var('category_info_info', 'dalyvio <b>'.$info['username'].'</b> darbø sàraðas<br>');
				$this->tpl->set_var('category', $info);
				$this->tpl->set_var('navigator', avNavigator::show($offset, $this->get_full_list_count($category, $search, $user), $count * 3, 'navigator_link', &$this, 'works_list_self_link'));
				$list = $this->get_full_list($category, $offset, $count * 3, $search, $order, $user);
				
				if ($user == $g_user_id) 
				{
					$show_delete = 1;
				}
				else
				{
					$show_delete = 0;
				}

				if (in_array($g_usr->group_id, array(1, 4)))
				{
					$show_delete = 1;
				}

				$this->tpl->set_var('list_block', $this->show_list_items('user_item', &$list, 3, $show_delete));

				break;

			case 'works_favourites':
				isset($user) || redirect('/');
				$category = false;

				$count_sel = array();
				$count_sel[] = array('text'=>'6', 'value'=>'2');
				$count_sel[] = array('text'=>'9', 'value'=>'3');
				$count_sel[] = array('text'=>'12', 'value'=>'4');
				$count_sel[] = array('text'=>'15', 'value'=>'5');
				$this->tpl->set_var('count_sel', html_build_select('count', $count_sel, 'value', 'text', $count, 'inputfield'));

				$info = $g_usr->get_user_info($user);
				$this->tpl->set_var('page_title', $info['username']);
				$this->tpl->set_var('title', '');
				$this->tpl->set_var('category_info_info', 'dalyviui <b>'.$info['username'].'</b> labiausiai patikusiø darbø sàraðas<br>');

				$this->tpl->set_var('category', $info);

				$list = $this->get_full_list('favourites', $offset, $count * 3, $search, $order, $user);

				$this->tpl->set_var('navigator', avNavigator::show($offset, $this->get_full_list_count('favourites', $search, $user), $count * 3, 'navigator_link', &$this, 'works_list_self_link'));
				
				$this->tpl->set_var('list_block', $this->show_list_items('fav_item', &$list, 3));

				break;

			case 'works_category':
				isset($category) || redirect('/');
				$info = $this->get_category_info($category);
				$this->tpl->set_var('page_title', $info['name']);
				$this->tpl->set_var('title', $info['name']);
				$this->tpl->set_var('category_info_info', $info['info'].'<br>');
				$this->tpl->set_var('category', $info);
				$this->tpl->set_var('navigator', avNavigator::show($offset, $this->get_full_list_count($category, $search), $count * 4, 'navigator_link', &$this, 'works_list_self_link'));
				$list = $this->get_full_list($category, $offset, $count * 4, $search, $order, $user);
				
				$this->tpl->set_var('list_block', $this->show_list_items('category_item', &$list, 4));
				
			break;

			default:
				$this->tpl->set_var('page_title', 'visi darbai');
				$this->tpl->set_var('title', 'visi darbai');
				$this->tpl->set_var('category_info_info', '');
				$this->tpl->set_var('navigator', avNavigator::show($offset, $this->get_full_list_count($category, $search), $count * 4, 'navigator_link', &$this, 'works_list_self_link'));

				$list = $this->get_full_list($category, $offset, $count * 4, $search, $order, $user);
				
				$this->tpl->set_var('list_block', $this->show_list_items('norm_item', &$list, 4));

		}

		return $this->tpl->process('out', 'list_tpl', 1);
	}

	function get_full_list_count($category = false, $search = false, $user = false)
	{
		$where = "";
		if ($category && ('favourites' != $category)) {$where .= " AND category_id = $category "; }
		if ($user && ('favourites' != $category)) {$where .= " AND submiter = $user "; }
		if ($search) { $where .= " AND (w.subject LIKE '%$search%' OR w.info LIKE '%$search%') "; }
		if ('favourites' != $category)
		{
			$tmp = $this->db->get_array("SELECT COUNT(*) as count FROM avworks w WHERE id!=0 $where" );
		}
		else
		{
			$tmp = $this->db->get_array("SELECT COUNT(w.id) as count FROM avworks w LEFT JOIN avworkvotes v ON (v.work_id=w.id)  WHERE v.user_id=$user AND v.mark=5 $where" );

		}
		return $tmp['count'];
	}

	
	function get_full_list($category = false, $offset = 0, $count = 1000000, $search = false, $order = false, $user = false, $full_info = true)
	{

		
		switch ($order)
		{
			case 'subject': $order = ' w.subject '; break;
			case 'category': $order = ' w.category_id, id DESC '; break;
			case 'user': $order = ' w.submiter,  id DESC '; break;
			case 'mark': $order = ' avgmark DESC, w.score DESC, id DESC '; break;
			case 'summark': $order = ' summark DESC, avgmark DESC, w.score DESC, id DESC '; break;
			case 'score': $order = ' w.score DESC, id DESC '; break;
			case 'views': $order = ' w.views DESC, id DESC '; break;
			case 'date':
			default: $order = ' id DESC ';
		}
		$limit = " LIMIT $offset, $count ";
		$where = "";
		if (isset($GLOBALS['delete_view'])) { $where .= " AND DATE_ADD(w.posted, INTERVAL 7 DAY) < NOW() "; }
		if ('favourites' == $category) { $where .= " AND v.user_id=$user AND v.mark=5 "; } else
		if ($category) { $where .= " AND w.category_id = $category "; }

		if ($user && ('favourites' != $category) ) { $where .= " AND w.submiter = $user "; }
		if ($search) { $where .= " AND (w.subject LIKE '%$search%' OR w.info LIKE '%$search%') "; }

		$ts = getmicrotime();
		$cat_lookup = $this->get_category_lookup();

		
		$statement = "SELECT w.id AS id, w.subject AS subject, w.info AS info, w.file AS file, w.thumbnail AS thumbnail, w.posted, w.category_id, w.views, ROUND((w.file_size / 1024)) AS filesize, score, color,
			w.submiter AS user_id, u.username AS nick,
			COUNT(v.id) AS votes,  SUM(v.mark) AS summark, AVG(v.mark) AS avgmark 

			FROM avworks w LEFT JOIN avworkvotes v ON (w.id = v.work_id), 
				 u_users u
			WHERE w.submiter=u.id  $where  
			GROUP BY w.id
			ORDER BY $order
			$limit";

/*
		$statement = "SELECT w.id AS id, w.subject AS subject, w.info AS info, w.file AS file, w.thumbnail AS thumbnail, w.posted, w.category_id, w.views, ROUND((w.file_size / 1024)) AS filesize, score, color,
			w.submiter AS user_id,
			u.username AS nick,
			COUNT(v.id) AS votes,  SUM(v.mark) AS summark, AVG(v.mark) AS avgmark 

			FROM avworks w LEFT JOIN avworkvotes v ON (w.id = v.work_id), u_users u
			WHERE w.submiter=u.id  $where  
			GROUP BY w.id
			ORDER BY $order
			$limit";
//*/

/*
		$statement = "SELECT w.id AS id, w.subject AS subject, w.info AS info, w.file AS file, w.thumbnail AS thumbnail, w.posted, w.category_id, w.views, ROUND((w.file_size / 1024)) AS filesize, score, color,
			w.submiter AS user_id, 
			w.category_id,			

			COUNT(v.id) AS votes,  SUM(v.mark) AS summark, AVG(v.mark) AS avgmark 

			FROM avworks w LEFT JOIN avworkvotes v ON (w.id = v.work_id)
			WHERE 1=1 $where  
			GROUP BY w.id
			ORDER BY $order
			$limit";
		
//*/
		
		//$result = $this->db->get_result( $statement );
		$result = $this->db->cached_select('works', $statement, array('avworks', 'avworkvotes', 'u_users','avworkcategory'), 6000);
		if (isset($GLOBALS['bench'])) { echo "<br>checkpoint0: " . round((getmicrotime() - $ts), 2);}	

		
		// pasiimam visu komentaru skaiciu ir po to perbegam padarom antra masyva su parenid->comments
		$ts = getmicrotime();
		if ($full_info)
		{
			$st2 = "SELECT parent_id AS parent, COUNT(id) AS comments
						FROM avcomments WHERE table_name='avworks'
						GROUP BY parent_id";
			$comments = $this->db->cached_select('workcomments', $st2, array('avcomments', 'avworks'), 6000);

			$comtable = array();

			for($i = 0; isset($comments[$i]); $i++)
			{
				$comtable[ $comments[$i]['parent'] ] = $comments[$i]['comments'];
			}
		}
		if (isset($GLOBALS['bench'])) { echo "<br>checkpoint1: " . round((getmicrotime() - $ts),2);}	

		$ts = getmicrotime();
		for ($i = 0; isset($result[$i]); $i++)
		{
			if ($full_info && isset($comtable[ $result[$i]['id'] ]))
			{
				$result[$i]['comments'] = $comtable[ $result[$i]['id'] ];
			}
			else
			{
				$result[$i]['comments'] = 0;
			}
			isset($result[$i]['avgmark']) || $result[$i]['avgmark'] = 0;
			isset($result[$i]['summark']) || $result[$i]['summark'] = 0;

			$result[$i]['avgmark'] = round($result[$i]['avgmark'], 1);
			$result[$i]['category'] = $cat_lookup[$result[$i]['category_id']];
		}
		if (isset($GLOBALS['bench'])) { echo "<br>checkpoint2: " . round((getmicrotime() - $ts),2);}		
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


	
	function recalculate_score($id)
	{
		$tmp = $this->db->get_array("SELECT COUNT(id) AS votes, SUM(mark) AS summark, AVG(mark) AS avgmark
						FROM avworkvotes WHERE work_id=$id");
		isset($tmp['summark']) || $tmp['summark'] = 0;
		isset($tmp['avgmark']) || $tmp['avgmark'] = 0;
		
		$tmp2 = $this->db->get_array("SELECT views FROM avworks WHERE id=$id");

		$this->db->query('UPDATE LOW_PRIORITY avworks SET score = '. round($tmp['summark']*10 + $tmp2['views']/10 + $tmp['votes']*10). " WHERE id=$id");
		

		$out['votes'] = $tmp['votes'];
		$out['avgmark'] = $tmp['avgmark'];
		return $out;
	}

	function works_list_self_link($offset)
	{
		global $menuname, $category, $search, $user, $order, $count;
		
		if (!empty($user))
		{
			$out = "page.userinfo";
		}
		else
		{
			$out = "page." . $this->ini->read_var('avworks', 'works_list_page');
		}
		isset($category) && $out .= ";category.$category";
		isset($search) && $out .= ";search.$search";
		isset($order) && $out .= ";order.$order";
		isset($menuname) && $out .= ";menuname.$menuname";
		isset($count) && $out .= ";count.$count";
		isset($user) && $out .= ";user.$user";

		$out .= ";offset.$offset";
		return $out;
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

	function show_list_items($block, &$list, $cols = 4, $show_delete = false)
	{
		if (!$list) return $this->tpl->get_var('list_empty');
		$this->tpl->set_var('list_cols', $cols);
		$this->tpl->set_var('works_thumbs_url', $this->ini->read_var('avworks', 'thumbnails_url'));
		
		// ropojam per lista kas 4 paveiksliukus
		for ($index = 0; isset($list[$index]); $index += $cols)
		{
			$this->tpl->set_var('list_images', '');
			$this->tpl->set_var('list_descriptions', '');

			for ($i = 0; ($i < $cols) && isset($list[$index+$i]); $i++)
			{
				$this->tpl->set_var('item', $list[$index+$i]);
				$this->tpl->set_var('delete_link', '');
				if ($show_delete) 
				{
					$this->tpl->process('delete_link', 'delete_url');
				}
				$this->tpl->process('list_images', $block.'_image', 0, 0, 1);
				$this->tpl->process('list_descriptions', $block.'_description', 0, 0, 1);
			}

			$this->tpl->process('list_rows', 'list_row', 0, 0, 1);
		}
		
		return $this->tpl->process('tmp', 'list_table');
	}


	/**
	* kvieciama avNavigatoriaus
	*/
	function work_self_link($offset)
	{
		global $menuname, $category, $search, $user, $order, $count;
		

		$out = "page.workinfo";

		isset($category) && $out .= ";category.$category";
		isset($search) && $out .= ";search.$search";
		isset($order) && $out .= ";order.$order";
		isset($menuname) && $out .= ";menuname.$menuname";
		isset($count) && $out .= ";count.$count";
		isset($user) && $out .= ";user.$user";

		if (isset($this->result[$offset]))
		{
			$out .= ";work." . $this->result[$offset]['id'];
		}
		else
		{
			$out .= ";work.nera_tokio_darbo";
		}
		return $out;
	}

	/*!
		pagrindinis dziaugsmas
	*/
	function show_item()
	{
		global $work, $list_menu_name, $category, $search, $user, $order, $count, $offset, $g_error, $g_user_id;
		
		//if (empty($g_user_id)) redirect('/process.php/page.simple;menuname.badtime');

		isset($work) || redirect('/');

	
		isset($category) || $category = false;
		empty($search) || $search = false;
		isset($order) || $order = false;
		isset($user) || $user = false;
		isset($offset) || $offset = 0;
		isset($count) || $count = 4;

		
		$this->register_view($work);
		$vote_info = $this->recalculate_score($work);
		$this->tpl->set_file('temp', 'darbai/tpl/workitem.html', 1);

		
		// pasiimam visa sarasha
		$list = $this->get_full_list($category, 0, 1000000, $search, $order, $user);
		
		$this->result =&  $list;

		// surandam save
		for($i = 0; isset($list[$i]) && $list[$i]['id'] != $work; $i++);

		$current_work = $i==count($list) ? $i-1: $i;

		// radau save?
		if ($list[$current_work]['id'] != $work) { redirect('http://art.scene.lt/process.php/page.simple;menuname.nowork'); }
		

		
		// darbu navigatorius
//		$this->tpl->set_var('navigator', avNavigator::show($current_work, $this->get_full_list_count($category, $search, $user), 1, 'navigator_link', &$this, 'work_self_link'));
		$this->tpl->set_var('navigator', avNavigator::show($current_work, count($list), 1, 'navigator_link', &$this, 'work_self_link'));


		$info = $list[$current_work];
		$this->tpl->set_var('page_title', $info['subject']);
		empty($info['color']) && $info['color'] = '8FA0A1';

		$this->tpl->set_var('item', $info);
		$this->tpl->set_var('vote_info', $vote_info);

		$this->tpl->set_var('comment_error', $this->error);

		if (!empty($GLOBALS['g_user_id']))
		{
			$this->tpl->set_var('url', $GLOBALS['REQUEST_URI']);
			$this->tpl->process('post_comment', 'post_comment_block');

			if ($this->has_voted_on($work) || $GLOBALS['g_user_id'] == $info['user_id'] || !$this->has_right_to_vote())
			{
				$this->tpl->set_var('vote_line', '');
			}
			else
			{
				$this->tpl->process('vote_line', 'vote_block');
			}
		}
		else
		{
			$this->tpl->set_var('register_page', $this->ini->read_var('users', 'page'));
			$this->tpl->process('post_comment', 'register_block');
			$this->tpl->set_var('vote_line', '');
		}

		$comments = $this->get_comments($work);

		$this->tpl->set_loop('list', $comments);
		$this->tpl->process('comments', 'comments_block', 2);
		
		$voting = $this->get_voting($work);
		$this->tpl->set_loop('voting', $voting);

		$this->tpl->set_var('works_url', $this->ini->read_var('avworks', 'works_url'));

		if ($info['category_id'] == $this->flash_category)
		{
			// get flash dimensions
			$size = GetImageSize('files/'.$info['file']);
			if (!$size)
			{
				$size[0] = 700; $size[1] = 525;
			}
			$this->tpl->set_var('flash_width', $size[0]);
			$this->tpl->set_var('flash_height', $size[1]);
			$this->tpl->process('work_file', 'flash_file');
		}
		else
		{
			$this->tpl->process('work_file', 'image_file');
		}
		
		// near works line

		$near = array();
		$near_id = 0;
		$nid = $current_work - 4;
		($nid > 0) || $nid = 0;
		$list_count = count($list);
		
		//echo "$list_count <br>";print_r($list);
		while ( ($near_id < 8) && ($nid < $list_count) && ($list_count > 1) )
		{

			$near[$near_id] = $list[$nid]; 
			$near[$near_id]['nearlink'] = $this->work_self_link($nid);
			if ($nid == $current_work) { $near[$near_id]['thumbnail']='placeholder.gif'; }
			$near_id++;

			$nid++;
		}

		$this->tpl->set_var('works_thumbs_url', $this->ini->read_var('avworks', 'thumbnails_url'));
		$this->tpl->set_loop('near', $near);
		
		return $this->tpl->process('out', 'temp', 2);
	}

	/**
	* gal jau balsavo
	*/
	function has_voted_on($id)
	{
		global $g_user_id;
		$this->db->query("SELECT * FROM avworkvotes WHERE user_id=$g_user_id AND work_id=$id LIMIT 1");
		return $this->db->not_empty();
	}

	/**
	* ar turi teise balsuoti?
	*/
	function has_right_to_vote()
	{
		global $g_user_id, $g_usr;

		if (empty($g_user_id)) return false;
		if (!isset($g_usr)) return false;

		// praleidziam adminus ir kitus zmogiukus
		if (2 != $g_usr->group_id) return true;

		// nebalsuotoju grupe
		if (7 == $g_usr->group_id) return false;

		// ar turim darba senesni uz savaite
		$tmp = $this->db->get_array("SELECT COUNT(id) AS kiekis  FROM avworks WHERE submiter='$g_user_id' AND category_id!=5 AND DATE_SUB(NOW(), INTERVAL 7 DAY) > posted ");
		if ($tmp['kiekis'] < 1 ) {

			// ar turim tris fotkes senesnes uz savaite
			$tmp = $this->db->get_array("SELECT COUNT(id) AS kiekis  FROM avworks WHERE submiter='$g_user_id' AND category_id=5 AND DATE_SUB(NOW(), INTERVAL 7 DAY) > posted ");
			if ($tmp['kiekis'] < 3 ) return false;
		}

		return true;
	}

	/**
	* jei cia mano darbas - negaliu balsuoti
	*/
	function own_work($id)
	{
		global $g_user_id;
		$this->db->query("SELECT * FROM avworks WHERE submiter=$g_user_id AND id=$id LIMIT 1");
		return $this->db->not_empty();
	}

	/**
	* pasizymim, kad ivyko eprziura darbo
	*/
	function register_view($id)
	{
		$this->db->query("UPDATE LOW_PRIORITY avworks SET views=views+1 WHERE id=$id");
	}

	/**
	* komentaru sarasas
	*/
	function get_comments($pid)
	{
		return $this->db->get_result("SELECT c.subject AS subject, u.username AS username, user_id, c.info AS info, DATE_FORMAT(posted, '%Y.%m.%d %H:%i') AS posted
			FROM avcomments c, u_users u
			WHERE c.parent_id=$pid AND c.user_id=u.id AND c.table_name='avworks'
			ORDER BY posted ASC, c.id ASC");
	}

	/**
	* balsavimu sarasas
	*/
	function get_voting($pid)
	{
		return $this->db->get_result("SELECT u.username AS username, user_id, mark, DATE_FORMAT(posted, '%Y.%m.%d&nbsp;%H:%i') AS posted, IF(DATE_ADD(v.posted, INTERVAL 7 DAY) > NOW(), 'dark', 'light') AS class
			FROM avworkvotes v, u_users u
			WHERE v.work_id=$pid AND v.user_id=u.id
			ORDER BY posted ASC, v.id ASC");
	}
	
	/**
	* informacija apie darba
	*/
	function get_info($id)
	{
		return $this->db->get_array("SELECT w.id AS id, subject, color, w.submiter AS user_id, w.file, DATE_FORMAT(posted, '%Y.%m.%d') AS posted, w.info AS info, u.username AS username,ROUND((file_size / 1024)) AS filesize, wc.name AS category, category_id, score, views
			FROM avworks w, u_users u, avworkcategory wc
			WHERE w.id=$id AND w.submiter=u.id AND w.category_id=wc.id");
	}


	/**
	* kvieciama komentuojant darba
	*/
	function event_work_comment()
	{
		global $url, $subject, $comment, $parent_id, $g_user_id, $g_usr, $g_tpl;

		if (empty($comment))
		{
			$this->error .= 'tuðèias komentaras<br>';
		}

		if (empty($parent_id))
		{
			$this->error .= 'neþinomas darbas<br>';
		}

		if (empty($g_user_id))
		{
			$this->error .= 'reikia prisijungti prie sistemos<br>';
		}

		if ($this->error) return true;

		$comment = do_ubb($comment);
		$subject = htmlchars($subject);

		// patikrinam kad nebutu netyciom dubliu

		$this->db->query("SELECT * FROM avcomments
			WHERE table_name='$this->table' AND parent_id=$parent_id AND subject='$subject' AND info='$comment' LIMIT 1");

		if ($this->db->not_empty())
		{
			$this->error .= 'nesiøsk dukart<br>';
		}

		if ($this->error) return true;

		$this->db->query("INSERT INTO avcomments (subject, info, posted, parent_id, table_name, user_id) 
			VALUES ('$subject', '$comment', NOW(), $parent_id, '$this->table', $g_user_id)");

		$this->db->clear_cache_tables('avcomments');	
		// siunciam meila autoriui

		$work = $this->db->get_array("SELECT * FROM avworks WHERE id='$parent_id'");
		$author = $work['submiter'];
		$user_info = $this->db->get_array("SELECT * FROM u_user_info WHERE uid='$author'");
		$this->db->clear_cache_name('workcomments');
		
		
		if ($user_info['mail_comments'])
		{
			$user = $this->db->get_array("SELECT * FROM u_users WHERE id='$author'");

			$g_tpl->set_file('comment', 'darbai/tpl/mail_comment.txt');
						
			$g_tpl->set_var('id', $parent_id);
			$g_tpl->set_var('work_title', $work['subject']);
			$g_tpl->set_var('title', $subject);
			$g_tpl->set_var('username', $g_usr->username);
			$g_tpl->set_var('info', undo_ubb($comment));
			$g_tpl->set_var('date', date('Y.m.d'));

			mail($user['email'], 'komentaras apie tavo darbà', $g_tpl->process('','comment'), "MIME-Version: 1.0\nContent-Type: text/plain; charset=Windows-1257\nContent-Transfer-Encoding: 8bit\nFrom: art.scene automatas <art@scene.lt>\n", "-fart@scene.lt");


		}
		redirect($url);

	}


	/**
	* paspaudus ant balsavimo
	* tas popupas kur issoka tai sita funkcija
	*/
	function event_work_vote()
	{
		global $parent_id, $g_user_id, $mark, $url;

		$this->tpl->set_file('temp', 'darbai/tpl/vote.html', 1);
		$error = false;

		if (empty($parent_id) || empty($g_user_id))
		{
			$error = "trûksta duomenø. ($parent_id, $g_user_id)";
		}
		elseif($this->has_voted_on($parent_id))
		{
			$error = "jau balsavai.";
		}
		elseif(!$this->has_right_to_vote())
		{
			$error = "neturi portfelio balsavimui.";
		}
		elseif($this->own_work($parent_id))
		{
			$error = "tavo paties darbas.";
		}

		if ($error)
		{
			$this->tpl->set_var('message', '<span style="color:red">Tavo balsas neáskaitytas:<br>'.$error.'</span>');
			echo $this->tpl->process('', 'temp', 1);
			exit();
		}


		empty($mark) && $mark = 0;

		if ($mark < -5) $mark = -5;
		if ($mark > 5) $mark = 5;
		
		$this->db->query("INSERT INTO avworkvotes (mark, user_id, work_id, posted) VALUES
							($mark, $g_user_id, $parent_id, NOW())");
		$this->db->clear_cache_tables('avworkvotes');
		
		$this->recalculate_score($parent_id);

		$this->tpl->set_var('message', 'Aèiû, kad balsuoji.');
		echo $this->tpl->process('', 'temp', 1);
		exit();
	}


	/**
	* kai useris kliktelna savo puslapyje
	*/
	function event_delete_image()
	{
		global $g_user_id, $REQUEST_URI, $work, $g_usr, $g_ini;

		// paziurim ar darbas sito userio
		
		if (!isset($work))
		{
			echo 'fygne tu nepazymejei darbo';
			exit;
		}
		$info = $this->get_info($work);

		if ( (in_array($g_usr->group_id, array(1, 4))) ||
			 ($info['user_id'] == $g_user_id) )
		{
			$list = $this->db->get_result("SELECT file, thumbnail FROM avworks w WHERE id = $work");

			for ($i = 0; isset($list[$i]); $i++)
			{

				unlink( $g_ini->read_var('avworks', 'works_dir') . $list[$i]['file']);
				if ('nothumbnail.gif' != $list[$i]['thumbnail'])
				{
					unlink( $g_ini->read_var('avworks', 'thumbnails_dir') . $list[$i]['thumbnail']);
				}

			}
			
			$this->db->query("DELETE FROM avworks  WHERE id = $work");

			$this->db->query("DELETE FROM avcomments  WHERE table_name='avworks' AND parent_id = $work");
			$this->db->query("DELETE FROM avworkvotes  WHERE  work_id = $work");
			
			$this->db->clear_cache_tables(array('avworkvotes', 'avworks', 'avcomments'));
			
			$url = substr($REQUEST_URI, 0, strpos($REQUEST_URI, 'event.'));

			redirect($url);

		}

		
	}

	/**
	* trina faila ir visus irasus db apie darba
	* TODO: uzloginti kas ir kada tryne
	*/
	function delete_work($work, $image, $thumb)
	{
		global $g_ini;

			unlink( $g_ini->read_var('avworks', 'works_dir') . $image);
			if ('nothumbnail.gif' != $thumb)
			{
					unlink( $g_ini->read_var('avworks', 'thumbnails_dir') . $thumb);
			}
			
			$this->db->query("DELETE FROM avworks  WHERE id = $work");

			$this->db->query("DELETE FROM avcomments  WHERE table_name='avworks' AND parent_id = $work");
			$this->db->query("DELETE FROM avworkvotes  WHERE  work_id = $work");
	}


	/**
	* cia tas gudrusis trynimo automatas
	*/
	function daily_cleanup()
	{
		
		// per diena neishlipo ish minuso
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username, thumbnail,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter AND
				DATE_ADD(w.posted, INTERVAL 1 DAY) < NOW()
			GROUP BY w.id
			HAVING summark < 0
			");

		echo "<b>per dienà neiðlipo ið minuso</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";

		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail']);
		}

		// savaites nepakilo virs 1.5 vidurkis
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username,  thumbnail,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter AND
				DATE_ADD(w.posted, INTERVAL 7 DAY) < NOW()
			GROUP BY w.id
			HAVING avgmark < 1.5
			");

		
		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail']);
		}

		echo "<b>per savaite < 1.5</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";

		// bet kokio senumo jei balsavo daugiau kaip 3 ir -æ visi 
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, w.submiter AS user_id, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username, category_id, thumbnail,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter
			GROUP BY w.id
			HAVING avgmark < -3 AND vcount > 3
			");

	

		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail']);
		}

		echo "<b>maziau uz -3, balsavo bent 4</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";

	
		// fotografijos per savaite mazesnes uz 3 
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username,  thumbnail,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter AND w.category_id=5 AND
				DATE_ADD(w.posted, INTERVAL 7 DAY) < NOW()
			GROUP BY w.id
			HAVING avgmark < 3
			");
	

		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail']);
		}

		echo "<b>per savaite fotografija mazesne uz 3 vidurkis</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";


		
		// per diena foto neperlipo per 2
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username, thumbnail,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter AND w.category_id=5 AND
				DATE_ADD(w.posted, INTERVAL 1 DAY) < NOW()
			GROUP BY w.id
			HAVING avgmark < 2
			");

		echo "<b>per dienà neperlipo per 2 foto</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";

		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail']);
		}


		$this->db->clear_cache_tables(array('avworkvotes', 'avworks', 'avcomments'));

		die();


	}

}




?>