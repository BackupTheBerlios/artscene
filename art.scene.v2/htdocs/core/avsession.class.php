<?
/*
	Session handler class
	
	Created: nk, 2001.08.09
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/


//!! core
//!  persistent variables for users

/*!
CHANGES:

	2002.01.31 js
		- killold() called too often
	2002.01.18 js
		- double var $db
	2002.01.17 js
		+ new session indicator
	2001.11.05 js
		- users_online('registered') sql bug
	2001.09.25 js, dzhibas
		- idle logout bug
		+ var $userID
	2001.09.07 js
		* rename, coding style
		- droped debug feature, for cleaner code
  	Juozas Salna - 2001 08 28
 		+ class speed improve, deleted unneed DB requests,
 		+ updated set_var method last action, updated get_var method
 	Nikolajus Krauklis - 2001 08 24
 		+ corrected get_var() function bugs
 	Nikolajus Krauklis - 2001 08 21
 		+ function users_online - return how many users online
 	Nikolajus Krauklis - 2001 08 10
 		+ convert date structure to unix timestamp, then 
 		  killold function will work corectly		
 		+ after set_vars(); added loadvars function to renew variables
 		+ added $load_vars variable. You may not load vars to GLOBALS
 	Nikolajus Krauklis - 2001 08 09
 		+ gencode(); correction
 		+ Added variables $session_table and $session_var_table for
 		  users who wants to have own table name
 		+ DB structure corrected. Deleted intval column and
 		  renamed other colums in vars table
*/



/*!TODO
	less sql queries on ordinary page hit
*/

/*	
    CREATE TABLE u_session (
	   id char(20) NOT NULL,
	   LastAction int(10) DEFAULT '0' NOT NULL,
	   ip char(15) NOT NULL,
	   userID mediumint(9),
	   PRIMARY KEY (id),
	   KEY id (id),
	   UNIQUE id (id)
	);
	
	CREATE TABLE u_session_vars (
	   name varchar(30) NOT NULL,
	   session varchar(32) NOT NULL,
	   value varchar(100),
	   id mediumint(8) unsigned DEFAULT '0' NOT NULL auto_increment,
	   PRIMARY KEY (id),
	   KEY sessionID (session),
	   UNIQUE id (id)
	);
*/


class avSession
{

	/// Database link
	var $db;

	/// Max idle time for valid session
	var $MAX_UNAUTH_IDLE = 21600; //3600*6;	// 1h*6
	
	/// Max idle time for valid authorized session (login timeout)
	var $MAX_AUTH_IDLE=9000; // 1800*5; // 30min*5
	
	/// Session id
	var $session;
	
	/// Session ID code lenght. (MAX lenght 32 chars)
	var $session_code_length=20;
	
	/// Load vars from database to GLOBALS or not? 1 = true, 0 = false;
	var $load_vars = 0;
	
	/// Set to GLOBALS $SID or not? 1 = true, 0 = false;
	var $globalID = 0;
	
	/// Session table
	var $session_table = "u_session";
	
	/// Session vars table
	var $session_vars_table = "u_session_vars";
	
	/// inner array for variables
	var $variables;
	
	/// userID
	var $userID = 0;

	/// new session indicator
	var $session_is_new = false;


	/*!
		Class constructor.
		probability to kill old sessions - 3/20 
		From cookies get session id and class variable $session set this ID, after that 
		proceed demand_session()
	*/
	function avSession() 
	{
		global $g_db;
		$this->db = & $g_db;
		
		if (isset($GLOBALS['session'])) 
		{ 
			$this->session = $GLOBALS['session'];
			
			if ($this->globalID == 1) 
			{
				$GLOBALS['SID'] = $this->session;
			}
			
		} 
		else 
		{
			$this->session = false;
		}
	
		$this->demand_session();
	}

	/*!
		Begin session:
		validating session ID if isset ID loadvars from database to globals (if,
		$this->loadvars == 1 ), else if not set session ID or session ID corrupted
		created new session		
	*/	
	function demand_session()
	{
		//$this->killold();

		if (!$this->valid_session($this->session))
		{
	  		$this->session=$this->begin_session();
  		}
		else 
		{
  			if ($this->load_vars == 1) 
			{
  				 $this->loadvars($this->session);
  			}
		 	$this->s_touch($this->session);
  		}
	}
	
	
	/*!
		Validating session ID. Is this ID in database?	
	*/
	function valid_session($sess)
	{
		if (!$sess) return 0;
		if ('INVALID' == $sess) return 0;

		$tmp = $this->db->get_result("SELECT * FROM $this->session_table WHERE id='$sess'");

		if (!empty($tmp))
		{
			$this->userID = $tmp[0]['userID'];
			$GLOBALS['g_user_id'] = $this->userID;
		}
		return $tmp;
	}


	/*!
		Kill old sessions and session vars and logout users from system after MAX_AUTH_IDLE.	
	*/
	function killold()
	{
		// Kill old sessions where idle MAX_UNAUTH_IDLE seconds
		$result = $this->db->get_result("SELECT vars.id 
					FROM $this->session_table AS sess, $this->session_vars_table AS vars 
					WHERE sess.id=vars.session AND sess.LastAction < ". (time() - $this->MAX_UNAUTH_IDLE));
		 
		// DELETE old sessions VARS
		if (is_array($result)) 
		{
			while (list($key,$val) = each($result)) 
			{
		 	 	$this->db->query("DELETE FROM $this->session_vars_table 
					WHERE id=".$val['id']);
		 	}
		}
		 
		// kill Sessions after MAX_UNAUTH_IDLE for the sake of resources!
		$this->db->query("DELETE FROM $this->session_table
					WHERE LastAction < ".(time()-$this->MAX_UNAUTH_IDLE));
		
		// log users out if idle for MAX_AUTH_IDLE seconds
		$this->db->query("UPDATE $this->session_table 
					SET userID=NULL 
					WHERE LastAction < ".(time()-$this->MAX_AUTH_IDLE));

	}

	/*!
		Generating new session ID, inserting to database and set cookie to user
	*/
	function begin_session()
	{
		$sesscode = $this->gencode();
		
		if (!$sesscode) return 0;

		$this->db->query("INSERT INTO $this->session_table 
					VALUES ('$sesscode', ".time().", '".$GLOBALS['REMOTE_ADDR']."', NULL, '$GLOBALS[REQUEST_URI]')");
		
		setcookie("session",$sesscode, false, "/");
		 
		if ($this->globalID == 1) 
		{
			$GLOBALS['SID'] = $sesscode;
		}
		
		$this->session_is_new = true;

		return $sesscode;
	}
	

	/*!
		Generating sessionID (look at $this->session_code_lenght)

		2002.01.31 js
			- killold()
		2001.07.11 js
			+ $sid initialisation
			+ more unique srand
	*/
	function gencode()
	{
	
		//$this->killold();
		$sid = 0;
		mt_srand ((double) microtime() * 1000000);
		$Puddle = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		
		for($index=0; $index < $this->session_code_length - 1; $index++)
		{
			$sid .= substr($Puddle, (mt_rand()%(strlen($Puddle))), 1);
		}
		
		//If by some miracle this id exists, return 0. It will not pass
		//when it is checked next.
		if ($this->valid_session($sid)) { $sid = ''; }

		return $sid;
	}
	
	/*!
		Get data (variables) from database and make it GLOBALS if $this->loadvars is set to 1
	*/
	function loadvars($session)
	{
		$result = $this->db->get_result("SELECT * FROM $this->session_vars_table 
					WHERE session='$session'");
	
		if($result)
		{
		 	while(list($key,$val) = each($result)) 
			{
				$GLOBALS[$val['name']] = $val['value'];
				$this->variables[$val['name']] = $val['value'];
			}
		}
	}

	/*!
		Update session LastAction
	*/	
	function s_touch($sess)
	{
		global $REQUEST_URI;
		isset($REQUEST_URI) || $REQUEST_URI = '';
		 $this->db->query("UPDATE $this->session_table 
					SET LastAction=".time().", url='$REQUEST_URI'
					WHERE id='$sess'");
	}
	
	/*!
		Set new session variable. All variables stored in 
		\param $this->session_vars_table table
		\param $varname - variable name
		\param $value - value of variable
	  
		 TODO: replace

		 js, 2001.08.28
			* removed one select query, changed update/insert to replace
	*/
	function set_var($varname, $value)
	{
		  $this->db->query("REPLACE INTO $this->session_vars_table 
					(name, session, value, id) VALUES 
					('$varname', '$this->session', '$value', NULL)");

		  $GLOBALS[$varname] = $value;
		  $this->variables[$varname] = $value;
	}

	/*!
		Get variable value from inner array
		\param $varname - variable name 	
	*/
	function get_var($varname)
	{
		if (isset($this->variables[$varname])) 
		{
			return $this->variables[$varname];
		}
		else
		{
			return false;
		}
	}	
	
	/*!
		Is variable registered for this session
	*/
	function is_registered($varname)
	{
		$this->db->query("SELECT * FROM $this->session_vars_table 
					WHERE session='$this->session' AND name='$varname'");
		  		
		return $this->db->not_empty();
	}

	/*!
		Return session ID
	*/	
	function return_sessionID()
	{
		return $this->session;	
	}
	
	/*!
		Login User into the system. 
	*/
	function user_login($userID)
	{
		 $this->killold();
		 $this->demand_session();
		 $this->db->query("UPDATE $this->session_table 
					SET userID = '$userID' 
					WHERE id='$this->session'");
	}

	/*!
		Logout user from system and delete all session vars and session ID
	*/
	function logout()
	{
		$this->db->query("DELETE FROM $this->session_table 
					WHERE id='$this->session'");
		
		$this->db->query("DELETE FROM $this->session_vars_table 
					WHERE session='$this->session'");
	 	return true;
	}
	
	/*!
		Is user logged in into system, and if so method returns user ID
	
	function user_logged_in()
	{
		$this->killold();

		$result = $this->db->get_array("SELECT userID 
					FROM $this->session_table 
					WHERE id='$this->session'");

		if (!empty($result['userID'])) 
		{
			return $result['userID'];
		} 
		else 
		{
			return false;
		}
	}
	*/

	/*!
		Returns how many users online
	*/
	function users_online($who = "all", $interval=1800)
	{
		switch ($who) 
		{
			case "all":
					$query = "SELECT COUNT(*) AS kiek 
						FROM $this->session_table 
						WHERE LastAction > ". (time()-$interval);
				break;

			case "registered":
					$query = "SELECT COUNT(*) AS kiek 
						FROM $this->session_table 
						WHERE userID IS NOT NULL AND LastAction > ". (time()-$interval);
				break;
		}
		
		if (empty($query))
		{
				$query= "SELECT COUNT(*) as kiek FROM ".$this->session_table." WHERE LastAction > ". (time()-$interval);
		}

		$result = $this->db->get_array($query);

		if ($result)
		{
			return $result['kiek'];
		}
		else
		{
			return false;
		}
	}

	/*!
		\return true if session is new
	*/
	function is_new()
	{
		return $this->session_is_new;
	}
} //end of class

?>