<?
/**
	user preferences
	
	Created: js, 2002.11.06
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package core	
*/

/**
* user tracking and logging
* @version $Id: fuuser.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/
class fuUser
{
	var $kernel = null;
	
	var $id = false;
	var $username = '';
	var $group_id = false;
	var $email = '';
	var $lastlogin = false;
	var $lasthost = false;
	var $active = false;
	var $name = false;
	var $groupinfo = false;
	
	var $properties = array();
	
	function fuUser( &$kernel, $id = false )
	{
		debug('fuUser: starting...');
		$this->kernel =& $kernel;
		if (!$id) return;
		
		$this->load($id);
		debug('fuUser: loaded.');
	}
	
	function load($id)
	{
		if (!is_array($id))
		{
			debug("fuUser: loading user $id.");
			$tmp = $this->getInfo($id);
		}
		else 
		{
			$tmp = $id;
		}
		if ($tmp)
		{
			$this->id = $tmp['id'];
			$this->username = $tmp['username'];
			$this->group_id = $tmp['group_id'];
			$this->email = $tmp['email'];
			$this->name = $tmp['name'];
			$this->phone = $tmp['phone'];
			$this->lastlogin = $tmp['lastlogin'];
			$this->lasthost = $tmp['lasthost'];
			$this->active = $tmp['active'];
			$this->properties = unserialize($tmp['properties']);
		}		

		$this->groupinfo = $this->kernel->db->selectRow("SELECT * FROM fu_groups WHERE id='$this->group_id'");	
	}
	
	function getInfo($id)
	{
		return $this->kernel->db->selectRow("SELECT * FROM fu_users WHERE id='$id'");
	}
	
	
	function setProperty($name, $value)
	{
		$this->properties[$name] = $value;
	}
	
	function getProperty($name)
	{
		return isset($this->properties[$name]) ? $this->properties[$name] : false;
	}
	
	function saveProperties()
	{
		$prop = $this->kernel->db->addSlashes(serialize($this->properties));
		$this->kernel->db->query("UPDATE fu_users SET properties='$prop' WHERE id='$this->id'");
	}
	
	/**
	* names of enabled modules for active user
	*/
	function getEnabledModules()
	{
		if (!$this->id) return false;
		
		return $this->kernel->db->select("SELECT m.id, m.iname FROM fu_modules m, fu_group_module_link l WHERE l.group_id = '$this->group_id' AND m.id = l.module_id");
	}
	
	/**
	*	return false if no user exists
	*	return user info else
	*
	*	update lasthost, lastip if user exists
	*/
	function login( $username, $password )
	{
		global $g_user_id;
		
		$password = md5($password);
		$username = $this->kernel->db->addSlashes($username);

		$tmp = $this->kernel->db->selectRow("SELECT *
							FROM fu_users 
							WHERE username='$username' AND password='$password' AND active!=0");

		if ($tmp)
		{
			$this->load($tmp);
			// get hostname
			$host = remote_addr();
			
			$this->kernel->db->query("UPDATE fu_users 
							SET lasthost='$host', lastlogin=NOW() 
							WHERE id='$this->id'");
			
			$this->log("login from $host");
		
			$g_user_id = $this->id;	
			session_register('g_user_id');
			
			// get group info
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	* log message about user activity 
	* @todo - mssql support
	*/
	function log($msg, $module = 'control')
	{
		
		$msg = $this->kernel->db->addSlashes($msg);
		
		$this->kernel->db->query("INSERT INTO fu_users_log (user, timehit, ip, module, message) VALUES ('$this->id', NOW(), '$_SERVER[REMOTE_ADDR]', '$module', '$msg')");
	}
	
	function isLoggedIn()
	{
		return empty($this->id) ? false : true;
	}
}

cvs_id('$Id: fuuser.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');

?>