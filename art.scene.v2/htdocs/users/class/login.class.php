<?

/*

CREATE TABLE u_user_info (
   id int(11) NOT NULL auto_increment,
   uid int(11) NOT NULL,
   lastname varchar(200) NOT NULL,
	url varchar(200) NOT NULL,
	icq varchar(200) NOT NULL,

	mail_news tinyint(4) DEFAULT '0' NOT NULL,
	mail_comments tinyint(4) DEFAULT '0' NOT NULL,

	code varchar(33) NOT NULL,
	reg_date timestamp(14),

   PRIMARY KEY (id)
);

*/

/*
flexiUpdate community version		
*/

include_once($RELPATH . $COREPATH . 'avcolumn.class.php');

class login extends avColumn
{
	var $version = '$Id: login.class.php,v 1.5 2004/10/13 14:48:05 pukomuko Exp $';

	var $table = 'u_users';

	var $error = '';

	var $component = false;

	var $result = '';

	function login($comp = false)
	{
		avColumn::constructor($comp);
	}


	/*!
		\return string with 	
	*/
	function show_output($input)
	{
		global $g_user_id, $g_user_name, $page, $g_usr, $g_sess, $cookie_user_name;

		$this->tpl->set_var('users_page', $this->ini->read_var('users', 'page'));
		$this->tpl->set_var('visitors_online', $g_sess->users_online('all'));
		$this->tpl->set_var('total_users', $g_usr->get_user_count());
		
		if (!empty($g_user_id)) // just user info, link to settings, messages
		{
			$this->tpl->set_var('messages', $this->get_messages_info($g_user_id));
			$this->tpl->set_var('user_id', $g_user_id);
			$this->tpl->set_var('username', $g_usr->username);
			$this->tpl->set_file('temp', 'users/tpl/login_info.html');
			return $this->tpl->process('out', 'temp', 2);
		}
		else
		{
			isset($cookie_user_name) || $cookie_user_name = '';
			$this->tpl->set_var('cookie_user_name', $cookie_user_name);

			$this->tpl->set_var('error', $this->error);
			$this->tpl->set_var('url', $GLOBALS['REQUEST_URI']);

			$this->tpl->set_file('temp', 'users/tpl/login_form.html');
			return $this->tpl->process('out', 'temp', 2);
		}

	}


	/*!
		user signup form	
	*/
	function show_signup($input)
	{
		global $username, $email, $lastname, $webpage, $icq, $mail_news, $mail_comments, $mail_works;

		$this->tpl->set_file('temp', 'users/tpl/signup_form.html', 1);
		
		if (!$this->result)
		{
			isset($username) || $username = '';
			isset($email) || $email = '';
			isset($lastname) || $lastname = '';
			isset($webpage) || $webpage = 'http://';
			isset($icq) || $icq = '';

			$mail_news = 'checked';
			isset($mail_comments) || $mail_comments = '';
			$mail_comments && $mail_comments = 'checked';
			
			$this->tpl->set_var('error', $this->error);
			$this->tpl->set_var('username', $username);
			$this->tpl->set_var('email', $email);
			$this->tpl->set_var('lastname', $lastname);
			$this->tpl->set_var('webpage', $webpage);
			$this->tpl->set_var('icq', $icq);
			$this->tpl->set_var('mail_news', $mail_news);
			$this->tpl->set_var('mail_comments', $mail_comments);
			$this->tpl->set_var('mail_works', $mail_works);
			return $this->tpl->process('out', 'sign_up_form');
		}
		else
		{
			$this->tpl->set_var('password', $this->result);
			$this->tpl->set_var('email', $email);
			$this->tpl->set_var('username', $username);

			$this->tpl->set_file('letter_signup', 'users/tpl/letter_signup.txt');
			mail($email, 'art.scene.lt registracija / slaptaþodis viduj!', $this->tpl->process('out', 'letter_signup'), "From: artscene@fluxus.lt\r\nReply-To: artscene@fluxus.lt" , "-fart@scene.lt");

			return $this->tpl->process('out', 'sign_up_success');
		}
	}

	
	/*!
		show online users
	*/
	function show_online($input)
	{
		global $g_usr;

		$this->tpl->set_file('temp', 'users/tpl/online_list.html');
		$this->tpl->set_loop('users', $g_usr->list_online_users());
		$this->tpl->set_var('anonymous_online', $this->tpl->get_var('visitors_online') - $this->tpl->get_var('users_online'));

		return $this->tpl->process('out', 'temp', 2);
	}
	

	/*!
		change settings	
	*/
	function show_settings($input)
	{
		if (!$this->component) return false;

		$this->tpl->set_file('temp', 'users/tpl/change_settings.html', 1);

		if ($this->result) return $this->tpl->process('out', 'settings_success');

		global $g_usr, $g_user_id, $g_user_name, $oldpass, $newpass, $newpass2, $email, $lastname, $webpage, $icq, $mail_news, $mail_comments, $mail_works;
		
		if (empty($g_user_id)) { redirect($GLOBALS['SCRIPT_NAME'] . '/'); }

		if (empty($email)) // get info from db
		{
			$email = $g_usr->email;
			
			$tmp = $g_usr->get_user_info();

			$lastname = $tmp['lastname'];
			$webpage = $tmp['url'];
			$icq = $tmp['icq'];
			$mail_news = $tmp['mail_news'];
			$mail_comments = $tmp['mail_comments'];
			$mail_works = $tmp['mail_works'];
		}

		!empty($mail_news) ? $mail_news = 'checked' : $mail_news = '';
		!empty($mail_comments) ? $mail_comments = 'checked' : $mail_comments = '';
		!empty($mail_works) ? $mail_works = 'checked' : $mail_works = '';

		empty($webpage) ? $webpage = 'http://' : false;
		$this->tpl->set_var('error', $this->error);

		$this->tpl->set_var('email', $email);
		$this->tpl->set_var('lastname', $lastname);
		$this->tpl->set_var('webpage', $webpage);
		$this->tpl->set_var('icq', $icq);
		$this->tpl->set_var('mail_news', $mail_news);
		$this->tpl->set_var('mail_comments', $mail_comments);
		$this->tpl->set_var('mail_works', $mail_works);


		$this->tpl->set_var('error', $this->error);
		
		return $this->tpl->process('out', 'settings_form');
	}


	function list_users( $letter = '*')
	{
		$where = '';
		if ('*' == $letter)
		{
			$where = "FIND_IN_SET(LOWER(SUBSTRING(username,1,1)), 'a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,x,y,w,z') < 1";
		}
		else
		{
			$where = "'$letter' = LOWER(SUBSTRING(username,1,1))";
		}
		return $this->db->cached_select('userlist', "SELECT u.id AS id, u.username AS username, DATE_FORMAT(u.lastlogin, '%Y.%m.%d %H:%i') AS lastlogin,
				i.url AS url, i.icq AS icq
				FROM u_users u, u_user_info i
				WHERE u.id = i.uid AND $where
				ORDER BY username", array('u_users', 'u_user_info'), 300);

	}

	function get_first_user_letters()
	{
		// pirma padarau * toleu tik raides
		$list[0]['letter'] = '*';
		$list[0]['letter_url'] = urlencode('*');
		$index = 1;
		for ($c = ord('a'); $c <= ord('z'); $c++)
		{
			$list[$index]['letter_url'] = urlencode(chr($c));
			$list[$index]['letter'] = chr($c);
			$index++;
		}

		return $list;
	}
	/*!
		user list	
	*/
	function show_users_list()
	{
		global $users_list_search, $g_usr, $user_letter;
		$this->tpl->set_file('temp', 'users/tpl/users_list.html');
		

		isset($user_letter) || $user_letter = '*';
		$user_letter = urldecode($user_letter);
		
		$this->tpl->set_loop('letters', $this->get_first_user_letters());
		
		$this->tpl->set_loop('users', $this->list_users($user_letter));

		return $this->tpl->process('out', 'temp', 2);

	}


	function show_userinfo()
	{
		global $user, $g_usr;
		isset($user) || redirect('/');
		$this->tpl->set_file('temp', 'users/tpl/userinfo.html');
		
		$info = $g_usr->get_user_info($user);

		$tmp = $this->db->get_array("SELECT COUNT(id) AS count FROM avcomments WHERE user_id=$user");
		$info['comments'] = $tmp['count'];

		$tmp = $this->db->get_array("SELECT COUNT(id) AS count, sum(mark) AS sum_mark FROM avworkvotes WHERE user_id=$user");
		$info['votes'] = $tmp['count'];
		$info['sum_mark'] = $tmp['sum_mark'] ? $tmp['sum_mark'] : 0;

		$this->tpl->set_var('user', $info);

		$this->tpl->set_var('nonactive', '');
		if (!$g_usr->active) 
		{
			$this->tpl->set_var('nonactive', 'atjungtas')
		}

		return $this->tpl->process('out', 'temp');
	}

	/*!
		login user
	*/
	function event_login_login()
	{
		global $username, $password, $g_usr, $g_sess, $url, $g_lang, $g_user_id, $auto_login, $user;

		$rez = $g_usr->login_user($username, $password);

		setcookie ("cookie_user_name", $username, time() + 3600*24*30);

		if (!$rez)
		{
			$this->error =  'neteisingas vardas ir/arba slaptaþodis';
			//redirect('/');
			return false;
		}



		$url = str_replace('event.login_logout', '', $url);
		$g_sess->set_var("g_user_name",$rez["username"]);
		$g_sess->set_var("g_user_id",$rez["id"]);
		$g_sess->set_var("g_user_groupID",$rez["group_id"]);
		
		$g_sess->user_login($rez["id"]);

		$g_user_id = $rez['id'];

		if (isset($auto_login)) 
		{
			$code = $g_sess->gencode();
			$this->db->query("UPDATE u_users SET auto_login='$code' WHERE id=$g_user_id");
			setcookie("fygne_vietoj_passwordo", $code, time() + 3600*24*30, '/');
		}
		
		redirect($url);
	}

	/*!
		logout user
	*/
	function event_login_logout()
	{
		global $g_sess, $g_user_id;
		
		$g_sess->logout();
		unset($GLOBALS['g_user_id']);
		setcookie("fygne_vietoj_passwordo", '', time() + 3600*24*30, '/');
		redirect('../');
	}

	/*!
		sign up	
	*/
	function event_login_signup()
	{
		if (!$this->component) return false;

		global $username, $email, $lastname, $webpage, $icq, $mail_news, $mail_works, $mail_comments, $g_usr, $g_ini, $HTTP_SERVER_VARS;

		if (empty($username) || empty($email))
		{
			$this->error = 'praðom uþpildyti abu privalomus laukus<br>';
			empty($username) && $username = '';
			empty($email) && $email = '';
		}
		
		if (strlen($username) != strlen(clean_username($username)))
		{
			$this->error .= 'vartotojo varde galimi tik ðie þenklai: 0-9a-zA-Z_<br>';
			$username = clean_username($username);
		}

		if ($g_usr->exists_username($username))
		{
			$this->error .= 'toks vartotojas jau yra<br>';
		}

		if (!empty($email) && $g_usr->exists_email($email))
		{
			$this->error .= 'toks e-mailas jau yra<br>';
		}

		if (!valid_email($email))
		{
			$this->error .= 'nekorektiðkas e-mailas<br>';
		}
		
/*		if ('217.147.34.6' == $HTTP_SERVER_VARS['REMOTE_ADDR'])
		{
			$this->error .= 'didelës problemos, brûkðtelk laiðkà <a href="mailto:art@scene.lt">art@scene.lt</a><br>';
		}
*/
		if ($this->error) return false;

		// get hostname
		if (!empty($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR']))
		{
			$proxy = @gethostbyaddr($HTTP_SERVER_VARS['REMOTE_ADDR']);
			$host = @gethostbyaddr($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR']);

			$host = "$host [proxy: $proxy]";
		}
		else
		{
			$host = @gethostbyaddr($HTTP_SERVER_VARS['REMOTE_ADDR']);
		}

		$password = genpass();

		// everything ok, create user
		$mas['username'] = $username;
		$mas['email'] = $email;
		$mas['password'] = md5($password);
		$mas['group_id'] = $g_ini->read_var('users', 'default_group');
		$mas['active'] = 1;
		$mas['lastlogin'] = date('Y.m.d H.i');
		$mas['lasthost'] = "[new] $host";

		$this->db->insert_query($mas, $this->table);

		isset($lastname) || $lastname = '';
		isset($webpage) || $webpage = '';
		isset($icq) || $icq = '';
		isset($mail_news) || $mail_news = '0';
		isset($mail_comments) || $mail_comments = '0';
		isset($mail_works) || $mail_works = '0';

		if ('http://' == $webpage) $webpage = '';

		$mas = array();
		$mas['uid'] = $this->db->get_insert_id();
		$mas['lastname'] = $lastname;
		$mas['url'] = $webpage;
		$mas['icq'] = $icq;
		$mas['mail_news'] = $mail_news;
		$mas['mail_comments'] = $mail_comments;
		$mas['mail_works'] = $mail_works;
		$mas['reg_date'] = date('Y.m.d H.i');

		$this->db->insert_query($mas, 'u_user_info');

		setcookie ("cookie_user_name", $username, time() + 3600*24*30);

		$this->result = $password;

		return true;
	}


	/*!
		user settings	
	*/
	function event_login_settings()
	{
		if (!$this->component) return false;

		global $g_usr, $g_user_id, $g_user_name, $oldpass, $newpass, $newpass2, $email, $lastname, $webpage, $icq, $mail_news, $mail_comments, $mail_works;

		if (!$g_usr->is_user($g_usr->username, $oldpass))
		{
			$this->error .= 'neteisingas senas slaptaþodis<br>';
		}
		
		if (empty($email))
		{
			$this->error = 'praðom ávesti e-mailà<br>';
			$email = '';
		}


		if (!empty($email) && $g_usr->exists_email($email, 1))
		{
			$this->error .= 'toks e-mailas jau yra<br>';
		}

		if (!valid_email($email))
		{
			$this->error .= 'nekorektiðkas e-mailas<br>';
		}

		if (!empty($newpass) && ($newpass != $newpass2))
		{
			$this->error .= 'nesutampa naujas slaptaþodis<br>';

		}


		if ($this->error) return false;


		$mas['email'] = $email;
		if (!empty($newpass)) { $mas['password'] = md5($newpass); }

		$this->db->update_query($mas, $this->table, array('id' => $g_user_id));




		// everything ok, update user
		$mas['email'] = $email;
		if (!empty($newpass)) { $mas['password'] = md5($newpass); }

		$this->db->update_query($mas, $this->table, array('id' => $g_user_id));

		isset($lastname) || $lastname = '';
		isset($webpage) || $webpage = '';
		isset($icq) || $icq = '';
		isset($mail_news) || $mail_news = '0';
		isset($mail_comments) || $mail_comments = '0';
		isset($mail_works) || $mail_works = '0';
		if ('http://' == $webpage) $webpage = '';

		$mas = array();
		$mas['lastname'] = $lastname;
		$mas['url'] = $webpage;
		$mas['icq'] = $icq;
		$mas['mail_news'] = $mail_news;
		$mas['mail_comments'] = $mail_comments;
		$mas['mail_works'] = $mail_works;

		$this->db->update_query($mas, 'u_user_info', array('uid' => $g_user_id));

		$this->result = true;
		return true;
	}


	/*!
		lost password	
	*/
	function show_lost_password()
	{
		$this->tpl->set_file('temp', 'users/tpl/lost_password.html', 1);

		if ($this->result)
		{
			return $this->tpl->process('out', 'ok');
		}
		else
		{
			$this->tpl->set_var('error', $this->error);
			return $this->tpl->process('out', 'register');
		}
		
	}

	function event_lost_password_register()
	{
		global $g_usr, $g_sess, $email;

		if (!$this->component) return false;

		$user_id = $g_usr->exists_email($email);

		if (empty($email) || !$user_id)
		{
			$this->error = 'tokio emailo nëra';
		}

		if ($this->error) return false;

		$code = $g_sess->gencode();

		$this->db->query("UPDATE u_users SET forgotten_pass='$code' WHERE id=$user_id");

		$message = "labas, uþmarðtuk,
tau suteikiama galimybë pasikeisti slaptaþodá á naujà.
nueik ðiuo adresu ir susivesk naujàjá slaptaþodá:

http://art.scene.lt/process.php/page.simple;menuname.lostpassword_recover;code.$code

kol nepakeistas galioja senasis slaptaþodis

art.scene paðto automatas";
		mail($email, 'art.scene pamestas slaptaþodis', $message, "From: artscene@fluxus.lt\r\nReply-To: artscene@fluxus.lt", "-fart@scene.lt" );

		$this->result = true;
		return true;
	}

	function show_lost_password_recover()
	{
		global $email, $code;

		$this->tpl->set_file('temp', 'users/tpl/lost_password.html', 1);

		if ($this->result)
		{
			return $this->tpl->process('out', 'recovered');
		}
		else
		{
			isset($email) || $email = '';
			$this->tpl->set_var('error', $this->error);
			$this->tpl->set_var('code', $code);
			$this->tpl->set_var('email', $email);

			return $this->tpl->process('out', 'recover');
		}
	}

	function event_lost_password_recover()
	{
		global $email, $code, $newpass, $newpass2, $g_usr;

		if (!$this->component) return false;

		isset($email) || $email = '';
		isset($code) || $code = '';
		isset($newpass) || $newpass = '';
		isset($newpass2) || $newpass2 = '';

		$user_id = $g_usr->exists_email($email);

		if (empty($email) || !$user_id)
		{
			$this->error = 'tokio emailo nëra<br>';
		}
		
		if (empty($code))
		{
			$this->error .= 'nenorodytas kodas<br>';
		}

		if (!$g_usr->is_forgotten_code($code, $user_id))
		{
			$this->error .= 'neteisingas kodas<br>';
		}
		
		if (empty($newpass) || empty($newpass2))
		{
			$this->error .= 'tuðèias slaptaþodis<br>';
		}

		if ($newpass != $newpass2)
		{
			$this->error .= 'nesutampa slaptaþodþiai<br>';
		}

		if ($this->error) return false;

		$pass = md5($newpass);

		$this->db->query("UPDATE u_users SET forgotten_pass='', password='$pass' WHERE id=$user_id");

		$this->result = true;

	}


	function get_draugeliai($user)
	{
		return $this->db->get_result("
			SELECT SUM(v.mark) AS suma, COUNT(v.id) AS kiekis, u.username, v.user_id
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.user_id = u.id AND w.submiter='$user' AND w.id=v.work_id
			GROUP BY v.user_id
			ORDER BY suma DESC
			LIMIT 5");
	}

	function get_saviakai($user)
	{
		return $this->db->get_result("
			SELECT SUM(v.mark) AS suma, COUNT(v.id) AS kiekis, u.username, w.submiter
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.user_id = '$user' AND w.submiter=u.id AND w.id=v.work_id
			GROUP BY w.submiter
			ORDER BY suma DESC
			LIMIT 5");
	}

	function show_draugeliai()
	{
		global $user;

		$list = $this->get_draugeliai($user);
		$sav = $this->get_saviakai($user);

		$this->tpl->set_loop('drg', $list);
		$this->tpl->set_loop('sav', $sav);
		$this->tpl->set_file('draugeliai', 'users/tpl/draugeliai.html', 1);
		return $this->tpl->process('out', 'draugeliai', 2);
	}

	function get_messages_info($user)
	{
		$tmp = $this->db->get_array("SELECT COUNT(c.id) AS kiek
			FROM avcomments c
			WHERE c.parent_id=$user AND c.table_name='u_users'");

		$tmp1 = $this->db->get_array("SELECT COUNT(c.id) AS kiek
			FROM avcomments c
			WHERE c.parent_id=$user AND c.table_name='u_users' AND c.new=1");
		
		$result = array('unread'=>$tmp1['kiek'], 'total'=>$tmp['kiek']);

		if ($result['unread']) { $result['unread'] = '<span class="alert">'. $result['unread'] .'</span>'; }

		return $result;

	}

}


?>
