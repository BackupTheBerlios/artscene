# phpMyAdmin MySQL-Dump
# version 2.3.0
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Jan 18, 2003 at 07:02 PM
# Server version: 3.23.45
# PHP Version: 4.0.6
# Database : `php_lt`
# --------------------------------------------------------

#
# Table structure for table `forum_list`
#

DROP TABLE IF EXISTS forum_list;
CREATE TABLE forum_list (
  id int(11) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  sort int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id)
) TYPE=MyISAM;

#
# Dumping data for table `forum_list`
#

INSERT INTO forum_list VALUES (1, 'PHP.lt forumas', 'viskas kas susijæ su www.php.lt', 5000);
INSERT INTO forum_list VALUES (2, 'Duomenø bazës, SQL', 'diskusijos apie duomenu bazes, SQL ir pan.', 20);
INSERT INTO forum_list VALUES (3, 'PHP pradmenø forumas', 'èia visi pradedantys gali diskutuoti tarpusavyje, ir klausinëti durnus klausymus', 10);
INSERT INTO forum_list VALUES (4, 'TESTAVIMO forumas', 'forumas skirtas testavimui, pilnai paleidus jis bus iðtrintas', 1);
# --------------------------------------------------------

#
# Table structure for table `forum_post_list`
#

DROP TABLE IF EXISTS forum_post_list;
CREATE TABLE forum_post_list (
  id int(11) NOT NULL auto_increment,
  thread_id int(11) NOT NULL default '0',
  author_id int(11) NOT NULL default '0',
  subject text NOT NULL,
  body text NOT NULL,
  created_on datetime NOT NULL default '0000-00-00 00:00:00',
  good_bad int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY id (id),
  KEY thread_id (thread_id),
  KEY id_2 (id)
) TYPE=MyISAM;

#
# Dumping data for table `forum_post_list`
#

INSERT INTO forum_post_list VALUES (1, 1, 126, '', '[b]aaa[/b] hmz...', '2003-01-18 17:13:00', 0);
INSERT INTO forum_post_list VALUES (2, 1, 126, 'Re: blah blah', 'rabotaet', '2003-01-18 17:14:00', 0);
INSERT INTO forum_post_list VALUES (3, 1, 16, 'Re: blah blah', 'eik jau ? reiktø bbcode pabandyt\r\n\r\n[b]alio[/b]\r\n\r\n[i]kaip yra?[/b]', '2003-01-18 17:15:00', 0);
INSERT INTO forum_post_list VALUES (4, 2, 16, '', 'Tarp kitko kodas yra forumo modulio:\r\n\r\n<? \r\n\r\n/**\r\n * @author	Simonas Karuþas aka aubergine, koregavo Nikolajus Krauklis\r\n * @desc	php.lt forum\'as\r\n *\r\n * @todo	neuzmirst: send email reply to this post (monitor)\r\n *			delete post, stick\'y post\r\n *			posto view\'as taip vyksta:\r\n *			1.striptags,2. hilight,3. bbcode\r\n *          blogai su post\'u countais. reik perdaryt.\r\n *\r\n * @id		$Id: php_lt.sql.php,v 1.1 2004/08/04 22:48:29 pukomuko Exp $\r\n */\r\n\r\n\r\ninclude_once($RELPATH . $COREPATH . \'avcolumn.class.php\');\r\ninclude_once($RELPATH . $COREPATH . \'PageElements.class.php\');\r\ninclude_once($RELPATH . $COREPATH . \'avnavigator.class.php\');\r\n\r\nclass forum extends avColumn\r\n{\r\n\r\n	var $tbforum_list  = \'forum_list\';\r\n	var $tbthread_list = \'forum_thread_list\';\r\n	var $tbpost_list   = \'forum_post_list\';\r\n	var $tbusers       = \'u_users\';\r\n	var $result        = \'\';\r\n	\r\n	// bendra klaida po kurios nieko apart klaidos nerodoma\r\n	var $error         = \'\';\r\n	// thread error\r\n	var $thread_error  = \'\';\r\n	// post error\r\n	var $post_error  = \'\';\r\n\r\n	function forum($comp)\r\n	{\r\n		global $g_usr;\r\n		parent::constructor($comp);	\r\n		$this->user =& $g_usr;\r\n	}\r\n	\r\n	function get_forum($id)\r\n	{\r\n		$mas = $this->db->get_array("SELECT *\r\n				FROM {$this->tbforum_list}\r\n				WHERE id=\'{$id}\'");\r\n		return $mas;\r\n	}\r\n	\r\n	/**\r\n	 * @return array\r\n	 * @desc grazina forumu sarasa ir threadu COUNT\'a jame\r\n	 */\r\n	function get_forums_with_count()\r\n	{\r\n		$sql = "SELECT f.*, COUNT(t.id) as kiek, MAX(t.created_on) as kada FROM {$this->tbforum_list} as f\r\n				LEFT JOIN {$this->tbthread_list} as t ON t.forum_id = f.id\r\n				GROUP BY f.id ORDER BY sort ASC";\r\n		\r\n		return $this->db->get_result($sql);\r\n	}\r\n\r\n	/**\r\n	 * @return array\r\n	 * @desc grazina threadu sarasa ir postu count\'a jame\r\n	 */\r\n	function get_threads_with_count($forumid)\r\n	{\r\n		$sql = "SELECT t.*, u.username, u.id as uid, DATE_FORMAT(t.created_on, \'%m-%d %H:%i\') as created_on_short,\r\n				DATE_FORMAT(MAX(p.created_on), \'%m-%d %H:%i\') as last_post_short, COUNT(p.id) as kiek\r\n				FROM {$this->tbthread_list} as t LEFT JOIN {$this->tbusers} as u\r\n		  		ON t.author_id = u.id\r\n				LEFT JOIN {$this->tbpost_list} as p ON t.id = p.thread_id\r\n				WHERE t.forum_id = \'$forumid\' \r\n				GROUP BY t.id ORDER BY last_post_short DESC";\r\n\r\n		return $this->db->get_result($sql);\r\n	}\r\n	 \r\n	/**\r\n	 * @return array\r\n	 * @desc grazina postu sarasa\r\n	 */\r\n	function get_posts($thread_id)\r\n	{\r\n		$sql = "SELECT p.*, u.username, u.id as uid, DATE_FORMAT(p.created_on, \'%m-%d %H:%i\') as created_on_short,\r\n				t.name as thread_name, t.id as tid\r\n				FROM {$this->tbpost_list} as p, {$this->tbthread_list} as t LEFT JOIN {$this->tbusers} as u\r\n		  		ON p.author_id = u.id\r\n				WHERE p.thread_id = \'$thread_id\' and p.thread_id = t.id\r\n				GROUP BY p.id ORDER BY p.created_on ASC";\r\n\r\n		return $this->db->get_result($sql);\r\n	}\r\n\r\n	function get_forum_by_thread($id)\r\n	{\r\n		$mas = $this->db->get_array("SELECT *\r\n				FROM {$this->tbthread_list}\r\n				WHERE id=\'{$id}\'");\r\n\r\n		if (isset($mas[\'forum_id\'])) {\r\n			$forum_id = $mas[\'forum_id\'];\r\n			$f = $this->get_forum($forum_id);\r\n		} else\r\n			return 0;\r\n\r\n		return $f;\r\n	}\r\n\r\n	function get_thread($id)\r\n	{\r\n		$mas = $this->db->get_array("SELECT *\r\n				FROM {$this->tbthread_list}\r\n				WHERE id=\'{$id}\'");\r\n		return $mas;\r\n	}\r\n	\r\n	function get_post($id)\r\n	{\r\n		$mas = $this->db->get_array("SELECT *\r\n				FROM {$this->tbpost_list}\r\n				WHERE id=\'{$id}\'");\r\n		return $mas;\r\n	}\r\n\r\n	function add_hit($id)\r\n	{\r\n		$this->db->query("UPDATE \r\n				{$this->tbthread_list}\r\n				SET hit_cnt=hit_cnt + 1\r\n				WHERE id=\'{$id}\'");\r\n	}\r\n	\r\n	function add_post($params)\r\n	{\r\n		$this->db->insert_query($params,$this->tbpost_list);\r\n	}\r\n	\r\n	function add_thread($params)\r\n	{\r\n		$this->db->insert_query($params,$this->tbthread_list);\r\n		$res = $this->db->get_insert_id();\r\n		return $res;\r\n	}\r\n	\r\n	\r\n	function show_forum_list()\r\n	{\r\n		$this->tpl->set_file(\'file_forum_list\', \'forum/tpl/forum_list.html\', 1);\r\n\r\n		$mas = $this->get_forums_with_count();\r\n		$massize = sizeof($mas);\r\n		\r\n		// Pereinam per rezultatus ir pataisom datas\r\n		for ($x=0;$x<$massize;$x++)\r\n			if (empty($mas[$x][\'kada\']))\r\n				$mas[$x][\'kada\'] = \'----&nbsp;&nbsp;&nbsp;\';		\r\n		\r\n		$this->tpl->set_loop(\'list\', $mas);\r\n		\r\n		if (!isset($this->user->id)||empty($this->user->id)) {\r\n			$this->tpl->set_var(\'pleaselogin\',$this->tpl->process(\'PleaseLogin\',\'PleaseLogin\'));\r\n		} else {\r\n			$this->tpl->set_var(\'pleaselogin\',\'\');\r\n		}\r\n		\r\n		return $this->tpl->process(\'temp_out\',\'file_forum_list\',1);\r\n	}\r\n\r\n	function forum_exits($id) \r\n	{\r\n		$mas = $this->db->get_array("SELECT *\r\n				FROM {$this->tbforum_list}\r\n				WHERE id=\'{$id}\'");\r\n		if (!empty($mas))\r\n			return true;\r\n		else \r\n			return false;\r\n	}\r\n	\r\n	function show_thread_list($forum_id)\r\n	{\r\n		$this->tpl->set_file(\'file_thread_list\', \'forum/tpl/forum_thread_list.html\', 1);\r\n\r\n		$mas = $this->get_threads_with_count((int)$forum_id);\r\n		\r\n		if (!$this->forum_exits($forum_id))\r\n			return $this->userErr->Out("Tokio forumo nëra arba ávyko nenumatyta klaida, pasitikrinkit URL!");\r\n			\r\n		$cnt = count($mas);\r\n\r\n		// Apdorojimas pries parodyma\r\n		// 1. striptags, 2. do_ubb	\r\n		for ($x=0; $x<$cnt; $x++){\r\n			$mas[$x][\'name\'] = do_ubb(htmlspecialchars($mas[$x][\'name\']));\r\n			$mas[$x][\'username\'] = htmlspecialchars($mas[$x][\'username\']);\r\n		}\r\n		\r\n		$this->tpl->set_loop(\'list\', $mas);\r\n		\r\n		$forum_info = $this->get_forum($forum_id);\r\n		\r\n		$this->tpl->set_var(\'page_title\',$forum_info[\'name\']);\r\n		$this->tpl->set_var(\'category_info_info\',$forum_info[\'description\']);\r\n		$this->tpl->set_var(\'forum_id\',$forum_info[\'id\']);\r\n		\r\n		if (!isset($this->user->id)||empty($this->user->id)) {\r\n			$this->tpl->set_var(\'infotext\',$this->tpl->process(\'PleaseLogin\',\'PleaseLogin\'));\r\n		} else {\r\n			if ($this->thread_error != \'\') {\r\n				$this->tpl->set_var(\'threadtext\',htmlspecialchars(stripslashes($GLOBALS[\'subject\'])));\r\n				$this->tpl->set_var(\'threadbody\',htmlspecialchars(stripslashes($GLOBALS[\'body\'])));\r\n				$out = $this->userErr->Out($this->thread_error);\r\n				$out .= \'<br><br>\';\r\n				$out .= $this->tpl->process(\'NewThread\',\'NewThread\');\r\n				$this->tpl->set_var(\'infotext\', $out);\r\n			} else {\r\n				$this->tpl->set_var(\'threadtext\',\'\');\r\n				$this->tpl->set_var(\'threadbody\',\'\');\r\n				$this->tpl->set_var(\'infotext\',$this->tpl->process(\'NewThread\',\'NewThread\'));\r\n			}\r\n		}\r\n		\r\n		return $this->tpl->process(\'temp_out\',\'file_thread_list\',2);\r\n	}\r\n\r\n	function show_post_list($thread_id)\r\n	{\r\n		$this->tpl->set_file(\'file_post_list\', \'forum/tpl/forum_post_list.html\', 1);\r\n\r\n		$mas = $this->get_posts((int)$thread_id);\r\n		\r\n		$cnt = count($mas);\r\n\r\n		$forum_info = $this->get_forum_by_thread($thread_id);\r\n\r\n		if ($cnt == 0)\r\n			return $this->userErr->Out("Tokios temos nëra.  Pasitikrinkit URL!");\r\n\r\n		if (empty($forum_info))\r\n			return $this->userErr->Out("Forumo kuriai priklauso tema nebeegzistuoja. Gryþkit á forumø sàraðà.");\r\n		\r\n		// apdorojam postu sarasa jei tuscia\r\n		for ($x=0; $x<$cnt; $x++){\r\n			\r\n			$mas[$x][\'body\']= do_ubb(highlight_text($mas[$x][\'body\']));\r\n			if (empty($mas[$x][\'subject\']))\r\n				$mas[$x][\'subject\'] = do_ubb (htmlspecialchars($mas[$x][\'thread_name\']));\r\n			else\r\n				$mas[$x][\'subject\'] = do_ubb (htmlspecialchars($mas[$x][\'subject\']));\r\n			\r\n			$x == 0 ? $mas[$x][\'first\'] = \'\' : $mas[$x][\'first\'] = \'2\';\r\n			$x % 2 == 0 ? $mas[$x][\'number\'] = \'\' : $mas[$x][\'number\'] = \'2\';\r\n\r\n		}\r\n\r\n		$this->add_hit($thread_id);\r\n		\r\n		$this->tpl->set_loop(\'list\', $mas);\r\n\r\n		$this->tpl->set_var(\'page_title\',$forum_info[\'name\']);\r\n		$this->tpl->set_var(\'category_info_info\',$forum_info[\'description\']);\r\n		$this->tpl->set_var(\'forum_id\',$forum_info[\'id\']);\r\n		$this->tpl->set_var(\'thread_id\',$thread_id);\r\n\r\n		if (!isset($this->user->id)||empty($this->user->id)) {\r\n			$this->tpl->set_var(\'infotext\',$this->tpl->process(\'PleaseLogin\',\'PleaseLogin\'));\r\n		} else {\r\n			if ($this->post_error != \'\') {\r\n				$this->tpl->set_var(\'postext\',htmlspecialchars(stripslashes($GLOBALS[\'subject\'])));\r\n				$this->tpl->set_var(\'postbody\',htmlspecialchars(stripslashes($GLOBALS[\'body\'])));\r\n				$out = $this->userErr->Out($this->post_error);\r\n				$out .= \'<br><br>\';\r\n				$out .= $this->tpl->process(\'NewPost\',\'NewPost\');\r\n				$this->tpl->set_var(\'infotext\', $out);\r\n			} else {\r\n				$this->tpl->set_var(\'postext\',\'Re: \' . strip_tags($mas[0][\'thread_name\']));\r\n				$this->tpl->set_var(\'postbody\',\'\');\r\n				$this->tpl->set_var(\'infotext\',$this->tpl->process(\'NewPost\',\'NewPost\'));\r\n			}\r\n		}\r\n\r\n		return $this->tpl->process(\'temp_out\',\'file_post_list\',2);\r\n	}\r\n	\r\n	\r\n	/*!\r\n		\\return string with main content\r\n	*/\r\n	function show_output($input)\r\n	{\r\n		global $forum, $thread, $post, $e;\r\n		\r\n		if (isset($this->error) && $this->error != "" ) \r\n			return $this->userErr->Out($this->error);\r\n		\r\n		if (isset($e)&&!empty($e)) {\r\n			switch ($e) {\r\n				case \'recount\':\r\n					return $this->recount();\r\n					break;\r\n			}	\r\n		}\r\n		\r\n		if (isset($forum)&&!empty($forum)) {\r\n			return $this->show_thread_list($forum);\r\n		} elseif (isset($thread)&&!empty($thread)) {\r\n			return $this->show_post_list($thread);\r\n		} else {\r\n			return $this->show_forum_list();\r\n		}\r\n	}\r\n	\r\n	function event_submit_post(){\r\n		global $url;\r\n\r\n		if (!isset($this->user->id)||empty($this->user->id)) {\r\n			\r\n			$this->error = "Jûsø sesija baigësi, ir buvote atjungtas nuo sistemos, todël naujo thread\'o nesukûrëte. [b]Prisijungite ið naujo ir bandykite dar kartà[/b]";\r\n			return false;\r\n\r\n		} else {\r\n\r\n			if (empty($GLOBALS[\'body\'])||strlen(trim($GLOBALS[\'body\'])) < 1)\r\n			{\r\n				$this->post_error = "Neávedëte þinutës teksto teksto. Praðome suvesti ...";\r\n				return false;\r\n			}\r\n			\r\n			$params[\'subject\']    = $GLOBALS[\'subject\'];\r\n			$params[\'author_id\']  = $this->user->id;\r\n			$params[\'thread_id\']  =$GLOBALS[\'thread_id\'];\r\n			$params[\'body\']       = $GLOBALS[\'body\'];\r\n			$params[\'created_on\'] = date("Y-m-d H:i");\r\n			\r\n			$this->add_post($params);\r\n			\r\n			header("Location: ".$url.$GLOBALS[\'thread_id\']);\r\n			exit;\r\n		}		\r\n	}\r\n	\r\n	function event_submit_thread(){\r\n		global $url;\r\n\r\n		if (!isset($this->user->id)||empty($this->user->id)) {\r\n			\r\n			$this->error = "Jûsø sesija baigësi, ir buvote atjungtas nuo sistemos, todël naujo thread\'o nesukûrëte. [b]Prisijungite ið naujo ir bandykite dar kartà[/b]";\r\n			return false;\r\n\r\n		} else {\r\n			\r\n			if (empty($GLOBALS[\'subject\']) || empty($GLOBALS[\'body\'])||strlen(trim($GLOBALS[\'subject\'])) < 1|| strlen(trim($GLOBALS[\'body\'])) < 1)\r\n			{\r\n				$this->thread_error = "Neávedëte temos pavadinimo arba teksto. Praðome suvesti ...";\r\n				return false;\r\n			}\r\n			\r\n			$params[\'author_id\'] = $this->user->id;\r\n			$params[\'forum_id\'] = $GLOBALS[\'forum_id\'];\r\n			$params[\'created_on\'] = date("Y-m-d H:i");\r\n\r\n			$t_params = $params;\r\n			$t_params[\'name\']=$GLOBALS[\'subject\'];\r\n		\r\n			$p_params[\'author_id\'] = $this->user->id;\r\n			$p_params[\'created_on\'] = date("Y-m-d H:i");\r\n			$p_params[\'thread_id\'] = $this->add_thread($t_params);\r\n		\r\n			$p_params[\'body\'] = $GLOBALS[\'body\'];\r\n			\r\n			$this->add_post($p_params);\r\n			\r\n			header("Location: $url".$p_params[\'thread_id\']);\r\n			exit;\r\n			\r\n		}\r\n	}\r\n\r\n	function recount()\r\n	{\r\n		$forum_mas = $this->db->get_result("\r\n				 SELECT count( * ) as thread_cnt, forum_id FROM forum_thread_list GROUP BY forum_id\r\n		");\r\n\r\n		$cnt=count($forum_mas);\r\n		for ($x=0; $x<$cnt;$x++){\r\n			$this->db->query("UPDATE forum_list set thread_cnt={$forum_mas[$x][\'thread_cnt\']} where id={$forum_mas[$x][\'forum_id\']}");\r\n		}\r\n\r\n\r\n		$thread_mas = $this->db->get_result("\r\n				 SELECT count( * ) as post_cnt, thread_id FROM forum_post_list GROUP BY thread_id\r\n		");\r\n\r\n		$t_cnt=count($thread_mas);\r\n\r\n		for ($x=0; $x<$t_cnt;$x++){\r\n			$this->db->query("UPDATE forum_thread_list set post_cnt={$thread_mas[$x][\'post_cnt\']} where id={$thread_mas[$x][\'thread_id\']}");\r\n		}\r\n\r\n		return "Afected:<br>Forums: <b>$cnt</b><br>Threads: <b>$t_cnt</b>";\r\n	}\r\n}\r\n\r\n\r\n?>', '2003-01-18 17:15:00', 0);
INSERT INTO forum_post_list VALUES (5, 1, 126, 'Re: blah blah', '[php]\r\necho "Hello forum!";\r\n[/php]', '2003-01-18 17:16:00', 0);
INSERT INTO forum_post_list VALUES (6, 2, 16, 'Re: karoèë [b]testas[/b] sourco kodo pastinimo, toj papastysiu krûva kodo ;)', 'pizë, veikiot ;))) ) ))) )))', '2003-01-18 17:16:00', 0);
INSERT INTO forum_post_list VALUES (7, 2, 126, 'Re: karoèë [b]testas[/b] sourco kodo pastinimo, toj papastysiu krûva kodo ;)', 'nu zjbs!', '2003-01-18 17:17:00', 0);
INSERT INTO forum_post_list VALUES (8, 1, 16, 'Re: blah blah', 'liux hilightina ?', '2003-01-18 17:17:00', 0);
INSERT INTO forum_post_list VALUES (9, 1, 16, 'to: [color=red]donis[/color]', 'Nu tai kà ? kas dar xujovo èia ?\r\n\r\nreik kaþkà padaryt ?', '2003-01-18 17:18:00', 0);
INSERT INTO forum_post_list VALUES (10, 1, 381, 'Re: blah blah', '"Mc Donald\'s" \\ \' \'\' \'\'\\\' \\\' \'\' \'"" "|\' \'\' "" <? \' \'] ?><br> die();\r\n\r\nfelar\r\n\r\naaaaaaaaaaaaa aaaaaaaaaa aaaaaa aaaaaaaa aaaaaaaaa aaaaaaaaa aaaaaaaaaa aaaaaaaaaaa aaaaaaaa aaaaaaaaaa aaaaaaaaa a aaaaaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaa\r\n\r\n<a href=\\"\'as\\">', '2003-01-18 17:18:00', 0);
INSERT INTO forum_post_list VALUES (11, 1, 126, 'Re: blah blah', 'biske navigacija reik lengvesne padaryt, parasius zinute norint i grizt atgal arba i kita foruma nueit reik biske knistis :)', '2003-01-18 17:19:00', 0);
INSERT INTO forum_post_list VALUES (12, 1, 16, 'Re: blah blah', 'niu ðiaip taip, bet galima priprast labai patogu kai atgal gryþimas visur toj paèioj vietoj', '2003-01-18 17:20:00', 0);
INSERT INTO forum_post_list VALUES (13, 1, 16, 'Re: FELAR,', 'dëkui reikia taisyti ðità bugà,\r\n\r\nbus pataisytà, á todo susimetu kad neuþmirðèiau', '2003-01-18 17:21:00', 0);
INSERT INTO forum_post_list VALUES (14, 2, 16, 'to donis,', 'a kà nors supratai ?', '2003-01-18 17:23:00', 0);
INSERT INTO forum_post_list VALUES (15, 2, 19, 'Re: karoèë [b]testas[/b] sourco kodo pastinimo, toj papastysiu krûva kodo ;)', 'nu kaip smagu....!!!!\r\n\r\npagalew acirado forumas !!! >;)', '2003-01-18 17:41:00', 0);
INSERT INTO forum_post_list VALUES (16, 1, 19, 'Re: blah blah', 'ghem.....tai kada oficialus forumo atidarymas ?!', '2003-01-18 17:43:00', 0);
INSERT INTO forum_post_list VALUES (17, 1, 16, 'to: enc,', 'kai iðgaudysiu visus ðûdus , ir dabaigsiu uþplanuotus featurus daryt,\r\nbet teoriðkai naudotis jau dabar galima, tam yra sukurti kiti [b]forumai[/b]', '2003-01-18 17:46:00', 0);
INSERT INTO forum_post_list VALUES (18, 1, 19, 'Re: blah blah', 'em....o kaip "Forum" bus lietuvishkai ?!', '2003-01-18 17:49:00', 0);
INSERT INTO forum_post_list VALUES (19, 1, 16, 'xmz,', 'ta prasme lietuviðkai ? juk meniu yra "Forumai", gal pavadint diskusijos ? bet tada daugiau vietos uþims meniu ;(\r\n\r\nai koks skirtumas. forumai ar diskusijos.', '2003-01-18 17:50:00', 0);
INSERT INTO forum_post_list VALUES (20, 1, 19, 'Re: blah blah', 'bet tai jau linku spalvas manau reiketu pakeisti....kazhkaip nelabai man prie akies tos raudona ir zhalia spalvos....', '2003-01-18 17:51:00', 0);
INSERT INTO forum_post_list VALUES (21, 3, 16, '', 'Þodþiu kol forumas yra dar developinimo stadijoje reiktø padiskutuoti apie featurus kuriø reikia forumui\r\n\r\nmano uþmanyti yra ðtai tokie:\r\n[b]1[/b]. sticky post - post\'as kurá paraðius jis visada kaba virðuj forumo.\r\n[b]2[/b]. post to mail - galima pasiþymëti kad monitoriná ðità thread\'à ir visi atsakymai ateis meil\'u\r\n[b]3[/b]. kiekvienas prisiloginæs savo þinutes gali administruoti (trinti, koreguoti), o jei tai administratorio grupës vartotojas arba forum\'o grupës, jis gali administruoti visas þinutes.\r\n[b]4[/b]. nuoroda ið vartotojo vestø á naujajá vartotojo info forum\'o skiltá, kuriame bûtø kiek post\'ø paraðë, kiek threadø sukûrë ir kiek ilgai prabuvo forume.\r\n\r\nany ideas ?', '2003-01-18 17:54:00', 0);
INSERT INTO forum_post_list VALUES (22, 1, 16, 'Re: blah blah', 'man tai kaip tik prie akies.\r\n\r\nforumo stiliukà paëmiau ið naujausio phorum\'o 5\r\n[url]http://dev.phorum.org/phorum5/[/url]\r\n\r\ntad èia ne viena mano tokia nuomonë ;)\r\n\r\nvienà þinau kad vienas font\'as kai kuriose OS\'uose nerodo liet. raidþiø, vat dël to reiktø pamàstyti.....\r\n', '2003-01-18 17:56:00', 0);
INSERT INTO forum_post_list VALUES (23, 1, 19, 'Re: blah blah', 'bet tai kad ten 3.4 veliausias yra >;\\', '2003-01-18 18:14:00', 0);
INSERT INTO forum_post_list VALUES (24, 2, 34, 'Re: karoèë [b]testas[/b] sourco kodo pastinimo, toj papastysiu krûva kodo ;)', 'Karoche malonu matyti kodinima pazystamam style :)', '2003-01-18 18:34:00', 0);
# --------------------------------------------------------

#
# Table structure for table `forum_thread_list`
#

DROP TABLE IF EXISTS forum_thread_list;
CREATE TABLE forum_thread_list (
  id int(11) NOT NULL auto_increment,
  forum_id int(11) NOT NULL default '0',
  author_id int(11) NOT NULL default '0',
  name varchar(255) NOT NULL default '',
  hit_cnt int(11) NOT NULL default '0',
  created_on datetime NOT NULL default '0000-00-00 00:00:00',
  sticky enum('Y','N') NOT NULL default 'N',
  KEY id (id),
  KEY forum_id (forum_id)
) TYPE=MyISAM;

#
# Dumping data for table `forum_thread_list`
#

INSERT INTO forum_thread_list VALUES (1, 4, 126, 'blah blah', 56, '2003-01-18 17:13:00', 'N');
INSERT INTO forum_thread_list VALUES (2, 4, 16, 'karoèë [b]testas[/b] sourco kodo pastinimo, toj papastysiu krûva kodo ;)', 32, '2003-01-18 17:15:00', 'N');
INSERT INTO forum_thread_list VALUES (3, 1, 16, 'Forumo [b]featurai[/b]', 6, '2003-01-18 17:54:00', 'N');

