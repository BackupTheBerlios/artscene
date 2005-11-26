<? 
/*
$Id: news.class.php,v 1.2 2005/11/26 16:21:45 pukomuko Exp $
*/

//!! news
//! userside
include_once($RELPATH . $COREPATH . 'avcolumn.class.php');
include_once($RELPATH . $COREPATH . 'avnavigator.class.php');

class news extends avColumn
{

	var $table = 'avnews';
	var $result = '';
	var $error = '';

	function news()
	{
		avColumn::constructor();
	}


	/*!
		\return array with all categories
	*/
	function get_category_list()
	{
		return $this->db->get_result("SELECT c.id AS id, c.name AS name, c.info AS info, c.file AS file, COUNT(n.id) AS count 
				FROM avnewscategory c LEFT JOIN avnews n ON (c.id = n.category_id AND n.visible != 0)

				GROUP BY c.id");
	}

	function get_simple_category_list()
	{
		return $this->db->get_result("SELECT *
				FROM avnewscategory
				ORDER BY sort_number");
	}

	/*!
		\return similiar news  list by keywords
	*/
	function get_similiar($keywords, $id)
	{
		if (!$keywords) { return false; }

		$keyword = explode(', ', $keywords);
		$where = " keywords LIKE '%" .array_shift($keyword) . "%' ";
		while(list($k, $v) = each($keyword))
		{
			$where .= " OR keywords LIKE '%$v%' ";
		}

		return $this->db->get_result("SELECT *, DATE_FORMAT(posted, '%Y.%m.%d') as posted 
					FROM $this->table 
					WHERE id!=$id AND visible!=0 AND ($where) ");
	}

	/*!
		\return string with main content
	*/
	function show_output($input)
	{
		global $menuname, $category, $news;
		
		isset($menuname) || $menuname = '';
		
		switch ($menuname)
		{
			case 'newsitem': // naujienos kategorijoje
					return $this->show_item($news);
				break;

			case 'newscategory': // naujienos kategorijoje
					return $this->show_full_list($category);
				break;

			default: // is eiles visas sarasas
					return $this->show_full_list(false);

		}

	}

	/*!
		info with suplemental content
	*/
	function show_subcontent()
	{
		global $menuname, $category, $news;

		isset($menuname) || $menuname = '';
		
		switch ($menuname)
		{

			case 'newsitem':


			case 'newscategory':
				return $this->show_categories() . $this->show_headlines($this->ini->read_var('avnews', 'headlines_count'));
				break;
			default: // kategoriju sarasas
				return $this->show_categories();

		}

	}


	function show_full_list($category = false, $count = false)
	{
		global $offset, $search, $page;

		isset($offset) || $offset = 0;
		isset($search) || $search = false;
		
		$this->tpl->set_file('temp', 'news/tpl/news_list.html', 1);
		$this->tpl->set_var('newslist_page', $this->ini->read_var('avnews', 'newslist_page'));


		if (!empty($category))
		{
			$info = $this->get_category_info($category);
			$this->tpl->set_var('category_info_info', $info['info'] . '<br>');
			$this->tpl->set_var('page_title', 'naujienos : ' . $info['name']);

		}
		else
		{
			$this->tpl->set_var('category_info_info', '');
			$category = false;
			$this->tpl->set_var('page_title', 'ðvieþiausios naujienos');
		}
		
		$ts = getmicrotime();
		$list = $this->get_full_list($category, $offset, $this->ini->read_var('avnews', 'item_count'), $search);
		if (isset($GLOBALS['bench'])) { echo "<br>check-news1: " . round((getmicrotime() - $ts),2);}	

		for ($i = 0; isset($list[$i]); $i++)
		{
			$list[$i]['file'] && $list[$i]['file'] = '<img src="'. $this->ini->read_var('avnews', 'image_url') . $list[$i]['file'] .'" hspace=2 vspace=2 align="left">';
			if ($list[$i]['read_more'] < 100) 
			{
				$list[$i]['read_more'] = ''; 
			}
			else
			{
				$list[$i]['read_more'] = $this->tpl->get_var('read_more'); 
			}
		}


		
		$this->tpl->set_var('navigator', avNavigator::show($offset, $this->get_full_list_count($category, $search), $this->ini->read_var('avnews', 'item_count'), 'navigator_link', &$this, 'news_list_self_link'));
		$this->tpl->set_var('search', $search);
		$this->tpl->set_loop('list', $list);

		$this->tpl->set_var('news_header_block', '');

		if ($page == $this->ini->read_var('avnews', 'newslist_page'))
		{
			$this->tpl->process('news_header_block', 'news_header');
		}


		return $this->tpl->process('out', 'temp', 2);
	}
	
	function news_list_self_link($offset)
	{
		global $category, $search;
		$out = "page." . $this->ini->read_var('avnews', 'newslist_page');
		isset($category) && $out .= ";category.$category";
		isset($search) && $out .= ";search.$search";

		$out .= ";offset.$offset";
		return $out;
	}

	function get_full_list($category = false, $offset = 0, $count = 1000000, $search = false)
	{
		$limit = " LIMIT $offset, $count ";
		$where = "";
		if ($category) {$where .= " AND n.category_id = $category "; }
		if ($search) { $where .= " AND (n.subject LIKE '%$search%' OR n.info LIKE '%$search%' OR n.full_text LIKE '%$search%') "; }

		$statement = "SELECT n.id AS id, n.subject AS subject, n.info AS info, n.file AS file, DATE_FORMAT(n.posted, '%Y.%m.%d') AS posted, LENGTH(n.full_text) AS read_more, category_id,
			u.id AS user_id, u.username AS username,
			nc.name AS category,
			COUNT(c.id) AS comments
			FROM avnews n LEFT JOIN avcomments c ON (c.table_name='avnews' AND c.parent_id=n.id), u_users u, avnewscategory nc
			WHERE n.visible!=0 AND n.submiter=u.id AND n.category_id=nc.id  $where  
			GROUP BY n.id
			ORDER BY n.posted DESC, id DESC 
			$limit";
			
		$result = $this->db->cached_select('newslist', $statement, array('avnews', 'avcomments', 'u_users', 'avnewscategory'), 9000);
		
		return $result;
	}
	

	function get_full_list_count($category = false, $search = false)
	{
		$where = "";
		if ($category) {$where .= " AND category_id = $category "; }
		if ($search) { $where .= " AND (subject LIKE '%$search%' OR info LIKE '%$search%' OR full_text LIKE '%$search%') "; }
		$tmp = $this->db->get_array("SELECT COUNT(*) as count FROM avnews  WHERE visible!=0 $where" );
		return $tmp['count'];
	}

	function get_category_info($id)
	{
		return $this->db->get_array("SELECT * FROM avnewscategory WHERE id=$id");
	}

	function show_categories()
	{
		$this->tpl->set_file('temp', 'news/tpl/categories.html');
		$list = $this->get_category_list();

		$this->tpl->set_var('newslist_page', $this->ini->read_var('avnews', 'newslist_page'));
		$this->tpl->set_loop('list', $list);
		return $this->tpl->process('out', 'temp', 2);
	}

	function show_headlines($count)
	{
		$list = $this->get_headlines($count);
		$this->tpl->set_loop('list', $list);
		$this->tpl->set_file('temp', 'news/tpl/headlines.html');
		return $this->tpl->process('out', 'temp', 2);
	}

	function show_user_headlines()
	{
		global $user;
		isset($user) || redirect('/');
		$list = $this->get_user_headlines($user);
		$this->tpl->set_loop('list', $list);
		$this->tpl->set_var('newslist_page', $this->ini->read_var('avnews', 'newslist_page'));
		$this->tpl->set_file('temp', 'news/tpl/user_headlines.html');
		return $this->tpl->process('out', 'temp', 2);
	}


	function get_headlines($count)
	{
		return $this->db->get_result("SELECT id, subject, DATE_FORMAT(posted, '%Y.%m.%d') AS posted FROM avnews WHERE visible!=0 ORDER BY posted desc, id desc LIMIT $count");
	}

	function get_user_headlines($user)
	{
		return $this->db->get_result("SELECT id, subject, DATE_FORMAT(posted, '%Y.%m.%d') AS posted FROM avnews WHERE visible!=0 AND submiter=$user ORDER BY posted desc, id desc ");
	}


	function show_item($id)
	{
		$this->tpl->set_file('temp', 'news/tpl/newsitem.html', 1);
		$info = $this->get_info($id);

		$info['file'] && $info['file'] = '<img src="'. $this->ini->read_var('avnews', 'image_url') . $info['file'] .'" hspace=2 vspace=2 align="left">';

		$this->tpl->set_var('info', $info);
		$this->tpl->set_var('page_title', $info['subject']);
		$this->tpl->set_var('comment_error', $this->error);

		if (!empty($GLOBALS['g_user_id']))
		{
			$this->tpl->set_var('url', $GLOBALS['REQUEST_URI']);
			$this->tpl->process('post_comment', 'post_comment_block');
		}
		else
		{
			$this->tpl->set_var('register_page', $this->ini->read_var('users', 'page'));
			$this->tpl->process('post_comment', 'register_block');
		}

		$list = $this->get_comments($id);
		$this->tpl->set_loop('list', $list);
		$this->tpl->process('comments', 'comments_block', 2);

		if ($list = $this->get_similiar($info['keywords'], $id))
		{
			$this->tpl->set_loop('list', $list);
			$this->tpl->process('similiar', 'similiar_block', 1);
		}
		else
		{
			$this->tpl->set_var('similiar', '');
		}

		return $this->tpl->process('out', 'temp', 2);
	}

	function get_info($id)
	{
		return $this->db->get_array("SELECT n.id AS id, subject, DATE_FORMAT(posted, '%Y.%m.%d') AS posted, n.info AS info, full_text, keywords, u.username AS username, nc.name AS category, n.file,  category_id, submiter
			FROM avnews n, u_users u, avnewscategory nc
			WHERE n.id=$id AND n.visible!=0 AND n.submiter=u.id AND n.category_id=nc.id");
	}

	function get_comments($pid)
	{
		return $this->db->get_result("SELECT c.subject AS subject, u.username AS username, user_id, c.info AS info, DATE_FORMAT(posted, '%Y.%m.%d') AS posted
			FROM avcomments c, u_users u
			WHERE c.parent_id=$pid AND c.user_id=u.id AND c.table_name='avnews'
			ORDER BY posted ASC, c.id ASC");
	}


	function event_news_comment()
	{
		global $url, $subject, $comment, $parent_id, $g_user_id;

		if (empty($comment))
		{
			$this->error .= 'tuðèias komentaras<br>';
		}

		if (empty($parent_id))
		{
			$this->error .= 'neþinoma naujiena<br>';
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
		
		$this->db->clear_cache_name('newslist');

		redirect($url);

	}

	function show_submit()
	{
		global $url, $subject, $info, $text, $category, $keywords, $g_user_id;
		if (empty($g_user_id)) return true;

		$this->tpl->set_file('temp', 'news/tpl/submit.html', 1);

		if (!$this->result)
		{
			$this->tpl->set_var('error', $this->error);

			isset($subject) || $subject = '';
			isset($info) || $info = '';
			isset($text) || $text = '';
			isset($category) || $category = '';
			isset($keywords) || $keywords = '';

			$list = $this->get_simple_category_list();
			for ($i = 0; isset($list[$i]); $i++)
			{
				$list[$i]['selected'] = '';
				if ($list[$i]['id'] == $category) $list[$i]['selected'] = 'selected';
			}
			$this->tpl->set_var('subject', stripslashes(htmlchars($subject)));
			$this->tpl->set_var('info', stripslashes(htmlchars($info)));
			$this->tpl->set_var('text', stripslashes(htmlchars($text)));
			$this->tpl->set_loop('category', $list);
			$this->tpl->set_var('keywords', stripslashes(htmlchars($keywords)));

			return $this->tpl->process('out', 'submit_form', 2);
		}
		else
		{
			return $this->tpl->process('out', 'thank_you');
		}

	}

	function event_news_submit()
	{
		global $url, $subject, $info, $text, $category, $keywords, $g_user_id;
		
		if (empty($subject))
		{
			$this->error = 'reikia antraðtës<br>';
		}

		if (empty($category))
		{
			$this->error .= 'reikia temos<br>';
		}

		if (empty($info))
		{
			$this->error .= 'reikia santraukos<br>';
		}

		if (!isset($g_user_id))
		{
			$this->error .= 'reikia prisijungti prie sistemos<br>';
		}

		if ($this->error) return true;

		$mail_text = "
		
$subject
$info 
http://art.scene.lt/control/
		
    
    ";
    
		$info = do_ubb($info);
		$text = do_ubb($text);

		$subject = htmlchars($subject);


		$this->db->query("INSERT INTO avnews (subject, info, full_text, posted, visible, category_id, submiter, keywords) 
			VALUES ('$subject', '$info', '$text', NOW(), 0, $category, $g_user_id, '$keywords')");

		$this->result = 'ok';
		
		mail("artscene-admin-talk@googlegroups.com", 'art.scene atsiusta naujiena', $mail_text, "MIME-Version: 1.0\nContent-Type: text/plain; charset=Windows-1257\nContent-Transfer-Encoding: 8bit\nFrom: art.scene automatas <pukomuko@gmail.com>\n");
		return true;
	}
}


?>
