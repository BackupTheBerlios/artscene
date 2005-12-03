<?
/*
	User class 
	
	Created: nk, 2001.08.13
	
	$Id: avuser.class.php,v 1.2 2005/12/03 22:45:02 pukomuko Exp $
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/



//!! core lib
//!  user login, info

/*!
	
	Users class ver. 1.00 writen by "Alternatyvus Valdymas"
 	NK - 2001 08 13
 		+ added primary functions insert, update, list, info, delete
	
	Klase useriu lenteliu manipuliavimui.

*/

class avUser
{

	var $db;
	
	var $table_name = "u_users"; 	// Table name

	var $id = null;
	var $username = false;
	var $group_id = false;
	var $email;
	var $lastlogin;
	var $lasthost;
	var $active;
	
	var $may_comment_after = false;
	var $may_send_work_after = false;

	
	/*!
		Class constructor. Create database link.
	*/
	function avUser($id = false)
	{
		global $g_db;
		$this->db = & $g_db;
		$tmp = $this->get_info($id);
		if ($tmp)
		{
		  $this->init_from_array($tmp);
		}
	}

  /*!
    Create all class fields from db info
  */
  function init_from_array($tmp)
  {
 			$this->id = $tmp['id'];
			$this->username = $tmp['username'];
			$this->group_id = $tmp['group_id'];
			$this->email = $tmp['email'];
			$this->lastlogin = $tmp['lastlogin'];
			$this->lasthost = $tmp['lasthost'];
			$this->active = $tmp['active'];
			$this->may_comment_after = $tmp['may_comment_after'];
			$this->may_send_work_after = $tmp['may_send_work_after'];
			
  }

	/*!
		Inserts user into database
	*/
	function insert_user( $username, $password, $group_id = 0)
	{
		$info = array();
		$info['username'] = strip_tags($username);
		$info['password'] = md5($password);
		$info['group_id'] = $group_id;
		
		$this->db->insert_query($info, $this->table_name);
	}
	
	
	/*!
		return false if no user exists
		return user info else

		update lasthost, lastip if user exists
	*/
	/*!
		Nikolajus Kraukis: added user log table. 
	*/
	function login_user( $username, $password )
	{
		global $HTTP_SERVER_VARS;
		
		$password = md5($password);

		$this->db->query("SELECT *
							FROM $this->table_name 
							WHERE username='$username' AND password='$password' AND active!=0");

		if ($this->db->not_empty())
		{
		  $tmp = $this->db->get_array();
			$this->init_from_array($tmp);

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
			
			$this->db->query("UPDATE $this->table_name 
							SET lasthost='$host', lastlogin=NOW() 
							WHERE id=$this->id");
			
			//Inserted to logging users who logins into administrator site
			$sql = "INSERT INTO u_user_log (username,logindate,host,browser) VALUES ('{$tmp['username']}',NOW(),'{$host}','{$GLOBALS['HTTP_USER_AGENT']}')";
			$this->db->query($sql);			
			
			return $tmp;
		}
		else
		{
			return false;
		}
	}

	function auto_login_user( $code )
	{
		global $HTTP_SERVER_VARS, $g_user_id;
		
		if (empty($code)) return false;
		

		$this->db->query("SELECT * 
							FROM $this->table_name 
							WHERE auto_login='$code' AND active!=0");

		if ($this->db->not_empty())
		{
			$this->init_from_array($tmp);

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
			
			$this->db->query("UPDATE $this->table_name 
							SET lasthost='$host', lastlogin=NOW() 
							WHERE id=$this->id");
			
			//Inserted to logging users who logins into administrator site
			$sql = "INSERT INTO u_user_log (username,logindate,host,browser) VALUES ('{$tmp['username']}',NOW(),'[auto]$host','{$GLOBALS['HTTP_USER_AGENT']}')";
			$this->db->query($sql);			
			
			return $tmp;
		}
		else
		{
			return false;
		}
	}



	/*!
		\return array user info from database
	*/
	function get_info($id)
	{
		
		if (!$id) { return false; }
		$this->db->query("SELECT *, 
              DATE_FORMAT(lastlogin, '$GLOBALS[SQL_DATE_FORMAT_LONG]') AS lastlogin,
		          DATE_FORMAT(may_comment_after, '$GLOBALS[SQL_DATE_FORMAT_SHORT]') AS may_comment_after,
		          DATE_FORMAT(may_send_work_after, '$GLOBALS[SQL_DATE_FORMAT_SHORT]') AS may_send_work_after
							FROM $this->table_name 
							WHERE id=$id");
		
		return $this->db->get_array();	

	}

	/*!
		\return array user additional info from database
	*/
	function get_user_info($id = false)
	{
		
		if (!$id) { $id = $this->id; }
		$this->db->query("SELECT *, DATE_FORMAT(reg_date, '$GLOBALS[SQL_DATE_FORMAT_LONG]') AS reg_date, 
              DATE_FORMAT(lastlogin, '$GLOBALS[SQL_DATE_FORMAT_LONG]') AS lastlogin,
		          DATE_FORMAT(may_comment_after, '$GLOBALS[SQL_DATE_FORMAT_SHORT]') AS may_comment_after,
		          DATE_FORMAT(may_send_work_after, '$GLOBALS[SQL_DATE_FORMAT_SHORT]') AS may_send_work_after
							FROM u_user_info, $this->table_name u
							WHERE uid=$id AND u.id=$id");
		
		return $this->db->get_array();	

	}


	/*!
		user's group info	
	*/
	function get_group_info($groupID = false)
	{
		if ($groupID==false) {
		if (!$this->id) return false;
		$this->db->query("SELECT id, name, info, menu
							FROM u_group
							WHERE id=$this->group_id");
		} else {
			$this->db->query("SELECT id, name, info, menu
							FROM u_group
							WHERE id=$groupID");
		}
		
		return $this->db->get_array();	
	}

	/*!
		Returns group list
	*/
	function get_group_list()
	{
		$sql = "SELECT id, name, info FROM u_group";
		
		return $this->db->get_result($sql);	
	}

	/*
		Is user on the system
	*/
	function is_user($username,$password) 
	{
		$password = md5($password);
		
		$this->db->query("SELECT id, username, password, group_id 
							FROM $this->table_name
							WHERE username='$username' AND password='$password'");

		if ($this->db->not_empty()) 
		{
				return $this->db->get_array();
		} 
		else 
		{
				return false;	
		}
	}

	/*!
		Returns number of users in system
	*/
	function get_user_count()
	{
		$this->db->query("SELECT COUNT(*) AS count FROM $this->table_name");

		$tmp = $this->db->get_array();
		return $tmp['count'];
	}

	/*!
		online users	
	*/
	function list_online_users($interval = 1800)
	{
		$list = $this->db->get_result("SELECT u.*, " .time(). " - s.LastAction AS idle, g.name as group_name, g.info as group_info, s.url as url 
		FROM u_users u, u_session s, u_group g 
		WHERE u.id=s.userID and u.group_id=g.id AND s.LastAction > ". (time()-$interval) ."
		ORDER BY idle ASC");

		for ($i = 0; isset($list[$i]); $i++)
		{
			$list[$i]['idle'] = date("i:s", $list[$i]['idle']);
		}

		return $list;
	}

	/*!
		registered users	
	*/
	function list_users()
	{
		return $this->db->get_result("SELECT * FROM u_users ORDER BY username");
	}

	/*!
		check username	
	*/
	function exists_username($username)
	{
		$this->db->query("SELECT id FROM $this->table_name WHERE username='$username'");
		return $this->db->not_empty();
	}

	/*!
		check email	
	*/
	function exists_email($email, $notmy = false)
	{
		$where = '';
		if ($notmy) { $where = "AND id!=$this->id"; }
		$this->db->query("SELECT id FROM $this->table_name WHERE email='$email' $where");
		if ($this->db->not_empty())
		{
			$tmp = $this->db->get_array();
			return $tmp['id'];
		}
		else
		{
			return false;
		}
	}

	function is_forgotten_code($code, $user_id)
	{
		if (empty($code) || empty($user_id)) return false;
		$this->db->query("SELECT id FROM u_users WHERE forgotten_pass='$code' AND id='$user_id'");
		return $this->db->not_empty();
	}
	/*!
		send mail to every user
	*/
	function mass_mail($subject, $message, $filter = false)
	{
		if ($filter)
		{
			$list = $this->db->get_result("SELECT email 
							FROM u_users u LEFT JOIN u_user_info i ON u.id=i.uid
							WHERE $filter!=0");
		}
		else
		{
			$list = $this->db->get_result('SELECT email FROM u_users');
		}

		for ($i = 0; isset($list[$i]); $i++)
		{
			mail($list[$i]['email'], $subject, $message, "MIME-Version: 1.0\nContent-Type: text/plain; charset=Windows-1257\nContent-Transfer-Encoding: 8bit\nFrom: art.scene automatas <artscene@fluxus.lt>\n");
		}

	}
	
	function can_i_send_work() 
	{
	   return (time() > strtotimelt($this->may_send_work_after));
  }
  
  function can_i_comment()
  {
    return (time() > strtotimelt($this->may_comment_after)); 
  }

} //end of class

?>
