<?
/*
* darbus rodanti klasë
*/

include_once($RELPATH . $COREPATH . 'avcolumn.class.php');
include_once($RELPATH . $COREPATH . 'avnavigator.class.php');

include_once($RELPATH . 'darbai/class/darbai_sql.class.php');


class darbai extends avColumn
{
	var $version = '$Id: darbai.class.php,v 1.28 2008/11/27 02:05:34 lthnnpwr Exp $';
	var $table = 'avworks';

	var $result = '';
	var $error = '';
	var $flash_category = 6;
	var $sql;



	function darbai()
	{
		avColumn::constructor();
		$this->sql =& new darbai_sql(&$this->db);
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
		$sort_sel[] = array('text'=>'perþiûras', 'value'=>'views');
		$sort_sel[] = array('text'=>'balus', 'value'=>'summark');
		$sort_sel[] = array('text'=>'vid. balà', 'value'=>'mark');

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
				$this->tpl->set_var('navigator', avNavigator::show($offset, $this->sql->get_full_list_count($category, $search, $user), $count * 3, 'navigator_link', &$this, 'works_list_self_link'));
				$list = $this->sql->get_full_list($category, $offset, $count * 3, $search, $order, $user);
				
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

				$this->tpl->set_var('navigator', avNavigator::show($offset, $this->sql->get_full_list_count('favourites', $search, $user), $count * 3, 'navigator_link', &$this, 'works_list_self_link'));
				
				$list = $this->sql->get_full_list('favourites', $offset, $count * 3, $search, $order, $user);
				$this->tpl->set_var('list_block', $this->show_list_items('fav_item', &$list, 3));

				break;

			case 'works_category':
				isset($category) || redirect('/');
				$info = $this->sql->get_category_info($category);
				$this->tpl->set_var('page_title', $info['name']);
				$this->tpl->set_var('title', $info['name']);
				$this->tpl->set_var('category_info_info', $info['info'].'<br>');
				$this->tpl->set_var('category', $info);
				$this->tpl->set_var('navigator', avNavigator::show($offset, $this->sql->get_full_list_count($category, $search), $count * 4, 'navigator_link', &$this, 'works_list_self_link'));
				$list = $this->sql->get_full_list($category, $offset, $count * 4, $search, $order, $user);
				
				$this->tpl->set_var('list_block', $this->show_list_items('category_item', &$list, 4));
				
			break;

			default:
				$this->tpl->set_var('page_title', 'visi darbai');
				$this->tpl->set_var('title', 'visi darbai');
				$this->tpl->set_var('category_info_info', '');
				$this->tpl->set_var('navigator', avNavigator::show($offset, 
							$this->sql->get_full_list_count($category, $search), 
							$count * 4, 'navigator_link', &$this, 'works_list_self_link'));

				$list = $this->sql->get_full_list($category, $offset, $count * 4, $search, $order, $user);
				
				$this->tpl->set_var('list_block', $this->show_list_items('norm_item', &$list, 4));

		}

		return $this->tpl->process('out', 'list_tpl', 1);
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
	*	vieno darbo rodymas
	*/
	function show_item()
	{
		global $work, $category, $search, $user, $order, $count, $offset, $g_error, $g_user_id, $g_usr;
		
		isset($work) || redirect('/');

	
		isset($category) || $category = false;
		empty($search) || $search = false;
		isset($order) || $order = false;
		isset($user) || $user = false;
		isset($offset) || $offset = 0;
		isset($count) || $count = 4;

		
		$this->sql->register_view($work);
		$this->tpl->set_file('temp', 'darbai/tpl/workitem.html', 1);

		$info = $this->sql->get_info($work);

		if (!$info)
		{
			//var_dump($info); exit;
			redirect('http://art.scene.lt/process.php/page.simple;menuname.nowork'); 
		}

		$work_stat_info = $this->sql->get_work_stat_info($work);
		$comments = $this->sql->get_comments($work);
		$voting = $this->sql->get_voting($work);
		$info = $this->sql->update_work_stat($work, $info, $work_stat_info, count($comments), &$voting);


		$this->tpl->set_var('page_title', $info['subject']);
		empty($info['color']) && $info['color'] = '8FA0A1';




		$this->tpl->set_var('item', $info);


		$this->tpl->set_var('comment_error', $this->error);


		// near works line
		$near = $this->get_near_works($info, $category, $search, $user, $order, $count, $offset, $g_error, $g_user_id, $next_work);

		$this->tpl->set_var('works_thumbs_url', $this->ini->read_var('avworks', 'thumbnails_url'));
		$this->tpl->set_loop('near', $near);
		
		$this->tpl->set_var('nextwork', $next_work);
		$this->tpl->set_var('admin_options','');
		
		if (!empty($GLOBALS['g_user_id']))
		{
		  if ($g_usr->can_i_comment())
		  {
			   $this->tpl->set_var('url', $GLOBALS['REQUEST_URI']);
			   $this->tpl->process('post_comment', 'post_comment_block');
			}
			else
			{
			   // komentuoti negali
			   $message = 'Komentuoti galësi nuo '. $g_usr->may_comment_after;
			   $this->tpl->set_var('post_comment', $message);
			}

			// adminams ir deletomiotams: darbo trynimas
			if ($g_usr->group_id==1 || $g_usr->group_id==4){
				$this->tpl->process('admin_options','admin_delete');
			}

			if ($this->sql->has_voted_on($work, &$my_vote))
			{
				$this->tpl->set_var('vote_difference', $my_vote - $info['avgmark']);
				$this->tpl->process('vote_line', 'voted_block');
			}
			elseif($GLOBALS['g_user_id'] == $info['user_id'])
			{
				$this->tpl->set_var('vote_line', '');
			}
			elseif(!$this->has_right_to_vote())
			{
				$this->tpl->process('vote_line', 'novote_block');
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



		$this->tpl->set_loop('list', $comments);
		$this->tpl->process('comments', 'comments_block', 2);
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
		
		return $this->tpl->process('out', 'temp', 2);
	}

	/**
	* gràþina gretimø darbø eilutæ
	*/
	function get_near_works($info, $category, $search, $user, $order, $count, $offset, $g_error, $g_user_id, &$next_work)
	{
		$numNear = 6;
		
		if (!empty($GLOBALS['bench'])) echo "darbai::get_near_works()";
		$near = array();

		$near_left = (array)$this->sql->get_full_list($category, 0, $numNear, $search, $order, $user, 'back', $info);
		$near_right = (array)$this->sql->get_full_list($category, 0, $numNear, $search, $order, $user, 'forth', $info);
		
		if (!empty($near_right)) 
		{
			$next_work = $near_right[0]['id'];
		}
		elseif (!empty($near_left))
		{
			$next_work = $near_left[0]['id'];
		}
		else
		{
			$next_work="noavail";
		}
		
		$current = $info;
		$current['nearlink'] = $this->work_self_link($info['id']);
		$current['thumbnail']='placeholder.gif';
		
		
		$near[] = &$current;
		$take_left = false;
		while (count($near)<($numNear+1) && ($near_left || $near_right)){
			$take_left = !$take_left;
			 
			if ($take_left)
				$item = array_shift($near_left);
			else
				$item = array_shift($near_right);
			
			if (!$item)
				continue;
				
			$item['nearlink'] = $this->work_self_link($item['id']);
			
			if ($take_left)
				array_unshift($near,$item);
			else
				$near[] = $item;
		}

		return $near;
	}

	function work_self_link($id)
	{
		global $menuname, $category, $search, $user, $order, $count;
		

		$out = "page.workinfo";

		isset($category) && $out .= ";category.$category";
		isset($search) && $out .= ";search.$search";
		isset($order) && $out .= ";order.$order";
		isset($menuname) && $out .= ";menuname.$menuname";
		isset($count) && $out .= ";count.$count";
		isset($user) && $out .= ";user.$user";
		$out .= ";work." . $id;
		return $out;
	}

	/**
	* ar turi teise balsuoti?
	*/
	function has_right_to_vote()
	{
		global $g_user_id, $g_usr;

		if (empty($g_user_id)) return false;
		if (!isset($g_usr)) return false;

		// nebalsuotoju grupe
		if (7 == $g_usr->group_id) return false;

		// praleidziam adminus ir kitus zmogiukus
		if (2 != $g_usr->group_id) return true;


		// ar turim darba senesni uz savaite
		$tmp = $this->db->get_array("SELECT COUNT(*) AS kiekis  FROM avworks WHERE submiter='$g_user_id' AND category_id!=5 AND DATE_SUB(NOW(), INTERVAL 7 DAY) > posted ");
		if ($tmp['kiekis'] < 1 ) {

			// ar turim tris fotkes senesnes uz savaite
			$tmp = $this->db->get_array("SELECT COUNT(*) AS kiekis  FROM avworks WHERE submiter='$g_user_id' AND category_id=5 AND DATE_SUB(NOW(), INTERVAL 7 DAY) > posted ");
			if ($tmp['kiekis'] < 3 ) return false;
		}

		return true;
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

    if (!$g_usr->can_i_comment())
    {
      $this->error .= 'ðiuo metu negali komentuoti';
    }
		if ($this->error) return true;
		$comment = do_ubb($comment);
		$comment = smartWrap($comment, 30); // [alias] skaidom ilgus piktybiðkus þodþius
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
		$this->db->query("UPDATE avworks_stat SET comment_count = comment_count + 1 WHERE work_id=$parent_id");

		$this->db->clear_cache_tables('avcomments');	
		// siunciam meila autoriui

		$work = $this->db->get_array("SELECT * FROM avworks WHERE id='$parent_id'");
		$author = $work['submiter'];
		$user_info = $this->db->get_array("SELECT * FROM u_user_info WHERE uid='$author'");
		$this->db->clear_cache_name('workcomments');
		
		if ($user_info['mail_comments'] && $author!=$g_user_id)
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
	* 
	* 20080729  - updatinu popup'à á AJAX'à (alias)
	*/
	function event_work_vote()
	{
		global $parent_id, $g_user_id, $mark, $url;

		$this->tpl->set_file('temp', 'darbai/tpl/vote.html', 1);
		$error = false;

		header('Content-Type: text/html; charset=windows-1257'); // |alias| negraþiai darau, bet kitaip neiðeina -- ir perkeliu virs visu pranesimu

		if (empty($parent_id) || empty($g_user_id))
		{
			$error = "balsuoti gali tik prisijungæ vartotojai.";
		}
		elseif($this->sql->own_work($parent_id))
		{
			$error = "tavo paties darbas.";
		}
		elseif($this->sql->has_voted_on($parent_id))
		{
			$error = "jau balsavai.";
		}
		elseif(!$this->has_right_to_vote())
		{
			$error = "neturi portfelio balsavimui.";
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
		$this->db->query("UPDATE avworks_stat SET vote_count = vote_count + 1, vote_sum = vote_sum + $mark, vote_avg = ROUND(vote_sum/vote_count, 1) WHERE work_id='$parent_id'");
		// TODO: ar perskaièiuoti AVG ?
		$this->db->clear_cache_tables('avworkvotes');
		$this->tpl->set_var('message', 'Aèiû, kad balsuoji.');
		echo $this->tpl->process('', 'temp', 1);
		exit();
	}

}

?>