<? 

/**
 * @author	Simonas Karuþas aka aubergine and Nikolajus Krauklis
 * @desc	php.lt forum'as
 *
 * @todo	neuzmirst: send email reply to this post (monitor)
 *			puslapiavimas
 *			reikia skaidyt tekstà jei jis per ilgas ir netelpa á langà 
 *			(atsiþvelgt á tai kad tai gali bûti nuoroda)
 *			[url] classname ;)
 *
 * @id		$Id: forum.class.php,v 1.1 2004/08/04 22:48:29 pukomuko Exp $
 */

include_once($RELPATH . $COREPATH . 'avcolumn.class.php');
include_once($RELPATH . $COREPATH . 'avnavigator.class.php');

class forum extends avColumn
{

	var $tbforum_list  = 'forum_list';
	var $tbthread_list = 'forum_thread_list';
	var $tbpost_list   = 'forum_post_list';
	var $tbusers       = 'u_users';
	var $result        = '';
	
	// bendra klaida po kurios nieko apart klaidos nerodoma
	var $error         = '';
	// thread error
	var $thread_error  = '';
	// post error
	var $post_error  = '';

	function forum($comp = false)
	{
		global $g_usr;
		parent::constructor($comp);	
		$this->user =& $g_usr;
		$this->userErr = new tempError();

	}

	function is_admin()
	{
		if ((6==$this->user->id) || (12==$this->user->id))
		{
			return true;
		}
		return false;
	}
	
	function get_forum($id)
	{
		$mas = $this->db->get_array("SELECT *
				FROM {$this->tbforum_list}
				WHERE id='{$id}'");
		return $mas;
	}
	
	/**
	 * @return array
	 * @desc grazina forumu sarasa ir threadu COUNT'a jame
	 */
	function get_forums_with_count()
	{
		$sql = "SELECT f.*, COUNT(p.id) as kiek, MAX(p.created_on) as kada FROM {$this->tbforum_list} as f
				LEFT JOIN {$this->tbthread_list} as t ON t.forum_id = f.id
				LEFT JOIN {$this->tbpost_list} as p ON p.thread_id = t.id
				GROUP BY f.id ORDER BY sort ASC";
		
		return $this->db->get_result($sql);
	}

	/**
	 * @return array
	 * @desc grazina threadu sarasa ir postu count'a jame
	 */
	function get_threads_with_count($forumid)
	{
		$sql = "SELECT t.*, u.username, u.id as uid, DATE_FORMAT(t.created_on, '%Y.%m.%d %H:%i') as created_on_short,
				DATE_FORMAT(MAX(p.created_on), '%Y.%m.%d %H:%i') as last_post_short, COUNT(p.id) as kiek
				FROM {$this->tbthread_list} as t LEFT JOIN {$this->tbusers} as u
		  		ON t.author_id = u.id
				LEFT JOIN {$this->tbpost_list} as p ON t.id = p.thread_id
				WHERE t.forum_id = '$forumid' 
				GROUP BY t.id 
				ORDER BY t.sticky, last_post_short DESC";

		return $this->db->get_result($sql);
	}

	/**
	 * @return array
	 * @desc grazina svieziausiu threadu sarasa is visu forumu
	 */
	function get_fresh_threads($count)
	{
		$sql = "SELECT t.*, LEFT(t.name, 40) AS name, 
				DATE_FORMAT(max(p.created_on), '%Y.%m.%d %H:%i') as last_post_short
				FROM {$this->tbthread_list} as t LEFT JOIN {$this->tbpost_list} as p ON t.id = p.thread_id
				GROUP BY t.id
				ORDER BY  last_post_short DESC
				LIMIT $count";

		return $this->db->get_result($sql);
	}
	 

	/**
	 * @return array
	 * @desc grazina postu sarasa
	 */
	function get_posts($thread_id)
	{
		$sql = "SELECT p.*, u.username, u.id as uid, DATE_FORMAT(p.created_on, '%Y.%m.%d %H:%i') as created_on_short,
				t.name as thread_name, t.id as tid
				FROM {$this->tbpost_list} as p, {$this->tbthread_list} as t LEFT JOIN {$this->tbusers} as u
		  		ON p.author_id = u.id
				WHERE p.thread_id = '$thread_id' and p.thread_id = t.id
				GROUP BY p.id ORDER BY p.created_on ASC";

		return $this->db->get_result($sql);
	}

	function get_forum_by_thread($id)
	{
		$mas = $this->db->get_array("SELECT *
				FROM {$this->tbthread_list}
				WHERE id='{$id}'");

		if (isset($mas['forum_id'])) {
			$forum_id = $mas['forum_id'];
			$f = $this->get_forum($forum_id);
		} else
			return 0;

		return $f;
	}

	function get_thread($id)
	{
		$mas = $this->db->get_array("SELECT *
				FROM {$this->tbthread_list}
				WHERE id='{$id}'");
		return $mas;
	}
	
	function get_post($id)
	{
		$mas = $this->db->get_array("SELECT *
				FROM {$this->tbpost_list}
				WHERE id='{$id}'");
		return $mas;
	}

	function add_hit($id)
	{
		$this->db->query("UPDATE 
				{$this->tbthread_list}
				SET hit_cnt=hit_cnt + 1
				WHERE id='{$id}'");
	}
	
	function add_post($params)
	{
		$this->db->insert_query($params,$this->tbpost_list);
	}
	
	function add_thread($params)
	{
		$this->db->insert_query($params,$this->tbthread_list);
		$res = $this->db->get_insert_id();
		return $res;
	}
	
	
	function show_forum_list()
	{
		$this->tpl->set_file('file_forum_list', 'forum/tpl/forum_list.html', 1);

		$mas = $this->get_forums_with_count();
		$massize = sizeof($mas);
		
		// Pereinam per rezultatus ir pataisom datas
		for ($x=0;$x<$massize;$x++)
			if (empty($mas[$x]['kada']))
			{
				$mas[$x]['kada'] = '----&nbsp;&nbsp;&nbsp;';
				$mas[$x]['kas'] = '';
			}
			else $mas[$x]['kas'] = '';

		$this->tpl->set_loop('list', $mas);
		
		if (!isset($this->user->id)||empty($this->user->id)) {
			$this->tpl->set_var('pleaselogin',$this->tpl->process('PleaseLogin','PleaseLogin'));
		} else {
			$this->tpl->set_var('pleaselogin','');
		}
		
		return $this->tpl->process('temp_out','file_forum_list',1);
	}

	function forum_exits($id) 
	{
		$mas = $this->db->get_array("SELECT *
				FROM {$this->tbforum_list}
				WHERE id='{$id}'");
		if (!empty($mas))
			return true;
		else 
			return false;
	}
	
	function show_thread_list($forum_id)
	{
		$in_page = 30;
		global $offset;
		empty($offset) && $offset = 0;
		$this->tpl->set_file('file_thread_list', 'forum/tpl/forum_thread_list.html', 1);

		$mas = $this->get_threads_with_count((int)$forum_id);
		
		if (!$this->forum_exits($forum_id))
			return $this->userErr->Out("Tokio forumo nëra arba ávyko nenumatyta klaida, pasitikrinkit URL!");
			
		$cnt = count($mas);

		// Apdorojimas pries parodyma
		// 1. striptags, 2. do_ubb	
		$newlist = array();
		for ($x=$offset; ($x < $offset + $in_page) && isset($mas[$x]); $x++)
		{
			$mas[$x]['name'] = do_ubb(htmlspecialchars($mas[$x]['name']));
			$mas[$x]['username'] = htmlspecialchars($mas[$x]['username']);
			$mas[$x]['sticky'] == 'Y' ? $mas[$x]['image'] = 'sticky' : $mas[$x]['image'] = 'rod';
			$newlist[] = $mas[$x];
		}
		
		$this->tpl->set_var('navigator', avNavigator::show($offset, count($mas), $in_page, false, &$this, 'thread_self_link'));
		$this->tpl->set_loop('list', $newlist);
		
		$forum_info = $this->get_forum($forum_id);
		
		$this->tpl->set_var('page_title',$forum_info['name']);
		$this->tpl->set_var('category_info_info',$forum_info['description']);
		$this->tpl->set_var('forum_id',$forum_info['id']);
		
		if (!isset($this->user->id)||empty($this->user->id)) {
			$this->tpl->set_var('infotext',$this->tpl->process('PleaseLogin','PleaseLogin'));
		} else {
			if ($this->thread_error != '') {
				$this->tpl->set_var('threadtext',htmlspecialchars(stripslashes($GLOBALS['subject'])));
				$this->tpl->set_var('threadbody',htmlspecialchars(stripslashes($GLOBALS['body'])));
				$out = $this->userErr->Out($this->thread_error);
				$out .= '<br><br>';
				$out .= $this->tpl->process('NewThread','NewThread');
				$this->tpl->set_var('infotext', $out);
			} else {
				$this->tpl->set_var('threadtext','');
				$this->tpl->set_var('threadbody','');
				$this->tpl->set_var('infotext',$this->tpl->process('NewThread','NewThread'));
			}
		}
		
		return $this->tpl->process('temp_out','file_thread_list',2);
	}
	

	function show_fresh_threads()
	{
		global $g_ini;

		$list = $this->get_fresh_threads($g_ini->read_var('forum', 'fresh_count'));

		$this->tpl->set_loop('ffresh', $list);

		$this->tpl->set_file('temp', 'forum/tpl/fresh_list.html', 1);

		return $this->tpl->process('', 'temp', 1);
	}

	function thread_self_link($offset)
	{
		global $forum;

		return "page.simple;menuname.forum;forum.$forum;offset.$offset";
	}

	function show_post_list($thread_id)
	{
		global $g_user_id;
		$this->tpl->set_file('file_post_list', 'forum/tpl/forum_post_list.html', 1);

		$this->tpl->set_var('delete', '');

		$mas = $this->get_posts((int)$thread_id);
		
		$cnt = count($mas);

		$forum_info = $this->get_forum_by_thread($thread_id);

		if ($cnt == 0)
			return $this->userErr->Out("Tokios temos nëra.  Pasitikrinkit URL!");

		if (empty($forum_info))
			return $this->userErr->Out("Forumo kuriai priklauso tema nebeegzistuoja. Gryþkit á forumø sàraðà.");
		
		// apdorojam postu sarasa jei tuscia
		for ($x=0; $x<$cnt; $x++){
			
			$mas[$x]['body']= do_ubb(($mas[$x]['body']),"ForumLink");
			if (empty($mas[$x]['subject']))
				$mas[$x]['subject'] = do_ubb (htmlspecialchars($mas[$x]['thread_name']));
			else
				$mas[$x]['subject'] = do_ubb (htmlspecialchars($mas[$x]['subject']));
			
			$x == 0 ? $mas[$x]['first'] = '' : $mas[$x]['first'] = '2';
			$x % 2 == 0 ? $mas[$x]['number'] = '' : $mas[$x]['number'] = '2';

		}

		$this->add_hit($thread_id);
		
		$this->tpl->set_loop('list', $mas);

		$this->tpl->set_var('page_title',$forum_info['name']);
		$this->tpl->set_var('category_info_info',$forum_info['description']);
		$this->tpl->set_var('forum_id',$forum_info['id']);
		$this->tpl->set_var('thread_id',$thread_id);

		if ($this->is_admin())
		{
			$this->tpl->set_var('delete', '| <a href="page.simple;menuname.forum;forum.'. $forum_info['id'] .";tid.$thread_id;event.delete_thread\">trinti</a>");
		}


		if (!isset($this->user->id)||empty($this->user->id)) {
			$this->tpl->set_var('infotext',$this->tpl->process('PleaseLogin','PleaseLogin'));
		} else {
			if ($this->post_error != '') {
				$this->tpl->set_var('postext',htmlspecialchars(stripslashes($GLOBALS['subject'])));
				$this->tpl->set_var('postbody',htmlspecialchars(stripslashes($GLOBALS['body'])));
				$out = $this->userErr->Out($this->post_error);
				$out .= '<br><br>';
				$out .= $this->tpl->process('NewPost','NewPost');
				$this->tpl->set_var('infotext', $out);
			} else {
				$this->tpl->set_var('postext','Re: ' . strip_tags($mas[0]['thread_name']));
				$this->tpl->set_var('postbody','');
				$this->tpl->set_var('infotext',$this->tpl->process('NewPost','NewPost'));
			}
		}

		return $this->tpl->process('temp_out','file_post_list',2);
	}
	
	
	/*!
		\return string with main content
	*/
	function show_output($input)
	{
		global $forum, $thread, $post, $e;
		
		if (isset($this->error) && $this->error != "" ) 
			return $this->userErr->Out($this->error);
		
		if (isset($e)&&!empty($e)) {
			switch ($e) {
				case 'recount':
					return $this->recount();
					break;
			}	
		}
		
		if (isset($forum)&&!empty($forum)) {
			return $this->show_thread_list($forum);
		} elseif (isset($thread)&&!empty($thread)) {
			return $this->show_post_list($thread);
		} else {
			return $this->show_forum_list();
		}
	}
	
	function event_delete_thread()
	{
		global $g_user_id, $tid;
		if (!$this->is_admin()) return true;
		if (empty($tid)) return true;

		$this->db->query("DELETE FROM forum_post_list WHERE thread_id='$tid' ");
		$this->db->query("DELETE FROM forum_thread_list WHERE id='$tid' ");
	}

	function event_submit_post(){
		global $url;

		if (!isset($this->user->id)||empty($this->user->id)) {
			
			$this->error = "Jûsø sesija baigësi, ir buvote atjungtas nuo sistemos, todël naujo thread'o nesukûrëte. [b]Prisijungite ið naujo ir bandykite dar kartà[/b]";
			return false;

		} else {

			if (empty($GLOBALS['body'])||strlen(trim($GLOBALS['body'])) < 1)
			{
				$this->post_error = "Neávedëte þinutës teksto teksto. Praðome suvesti ...";
				return false;
			}
			
			$params['subject']    = $GLOBALS['subject'];
			$params['author_id']  = $this->user->id;
			$params['thread_id']  =$GLOBALS['thread_id'];
			$params['body']       = $GLOBALS['body'];
			$params['created_on'] = date("Y-m-d H:i");
			
			$this->add_post($params);
			
			header("Location: ".$url.$GLOBALS['thread_id']);
			exit;
		}		
	}
	
	function event_submit_thread(){
		global $url;

		if (!isset($this->user->id)||empty($this->user->id)) {
			
			$this->error = "Jûsø sesija baigësi, ir buvote atjungtas nuo sistemos, todël naujo thread'o nesukûrëte. [b]Prisijungite ið naujo ir bandykite dar kartà[/b]";
			return false;

		} else {
			
			if (empty($GLOBALS['subject']) || empty($GLOBALS['body'])||strlen(trim($GLOBALS['subject'])) < 1|| strlen(trim($GLOBALS['body'])) < 1)
			{
				$this->thread_error = "Neávedëte temos pavadinimo arba teksto. Praðome suvesti ...";
				return false;
			}
			
			$params['author_id'] = $this->user->id;
			$params['forum_id'] = $GLOBALS['forum_id'];
			$params['created_on'] = date("Y-m-d H:i");

			$t_params = $params;
			$t_params['name']=$GLOBALS['subject'];
		
			$p_params['author_id'] = $this->user->id;
			$p_params['created_on'] = date("Y-m-d H:i");
			$p_params['thread_id'] = $this->add_thread($t_params);
		
			$p_params['body'] = $GLOBALS['body'];
			
			$this->add_post($p_params);
			
			header("Location: $url".$p_params['thread_id']);
			exit;
			
		}
	}

	function recount()
	{
		$forum_mas = $this->db->get_result("
				 SELECT count( * ) as thread_cnt, forum_id FROM forum_thread_list GROUP BY forum_id
		");

		$cnt=count($forum_mas);
		for ($x=0; $x<$cnt;$x++){
			$this->db->query("UPDATE forum_list set thread_cnt={$forum_mas[$x]['thread_cnt']} where id={$forum_mas[$x]['forum_id']}");
		}


		$thread_mas = $this->db->get_result("
				 SELECT count( * ) as post_cnt, thread_id FROM forum_post_list GROUP BY thread_id
		");

		$t_cnt=count($thread_mas);

		for ($x=0; $x<$t_cnt;$x++){
			$this->db->query("UPDATE forum_thread_list set post_cnt={$thread_mas[$x]['post_cnt']} where id={$thread_mas[$x]['thread_id']}");
		}

		return "Afected:<br>Forums: <b>$cnt</b><br>Threads: <b>$t_cnt</b>";
	}
}



class tempError
{
	function Out($msg)
	{
		return '<br><font color="#990000"><b>'. $msg .'</b></font><br>';
	}
}

?>