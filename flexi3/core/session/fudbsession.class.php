<?
/**
	session DB handler
	
	Created: dzhibas, 2002.10.24
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
* @package core	
* @version $Id: fudbsession.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/

/**
#
# Table structure for table `sessions` - MySQL
#

pukomuko, 2003.03.17 +field user

CREATE TABLE fu_sessions (
  sid varchar(32) NOT NULL default '',
  expire int(11) unsigned NOT NULL default '0',
  ip varchar(255) NOT NULL default '',
  data text NOT NULL,
  user int(11) unsigned NOT NULL default '0'
) TYPE=MyISAM;
*/

class fuDbSession {
	
	var $db;
	var $_gc_maxlifetime;
	
	var $_table = 'fu_sessions';	
	var $_sess_insert = false;
	
	/**
	* @todo error reporting
	*/
	function fuDbSession( &$db ) 
	{
		$this->db =& $db;
		
		$this->_gc_maxlifetime = ini_get('session.gc_maxlifetime');
		if ($this->_gc_maxlifetime <= 1) 
				$this->_gc_maxlifetime = 1440;

		if (!session_set_save_handler(array(&$this,'_open'),
									  array(&$this,'_close'),
									  array(&$this,'_read'),
									  array(&$this,'_write'),
									  array(&$this,'_destroy'),
									  array(&$this,'_gc_sess'))) 
		{
			echo "cannot set session savehandler";
		} 
		return true;
	}

	function _open()
	{
		//echo "atidaro <br>";
	}
	
	function _close()
	{
		//echo "uzdarom <br>";
	}
	
	function _read($id)
	{
		if ($this->db->driver == null) 
			return false;

		$sql = "SELECT data, user FROM $this->_table WHERE sid='$id' AND expire >= " . (time() - $this->_gc_maxlifetime);
		$res = $this->db->selectRow($sql);

		if (!empty($res)) 
		{
			$GLOBALS['g_user_id'] = $res['user'];
			return $res['data'];
		}
		
		$this->_sess_insert = true;
		return "";
	}
	
	/**
	* @todo reikia padaryti tikrinima duomenu crc32, jei nepasikeite reikia updatint tik expire data 
	*/
	function _write($id, $data)
	{
		if ($this->db->driver == null) 
			return false;
		
		$data = $this->db->addSlashes($data);
		if ($this->_sess_insert == true)
		{
			$user_id = $GLOBALS['g_user_id'];
			$sql = "INSERT INTO $this->_table (sid, expire, data, user) VALUES ('$id',".time().",'$data', '$user_id')";
			$this->db->query($sql);
		} else 
		{
			$sql = "UPDATE $this->_table SET expire=".time().", data='$data' WHERE sid='$id'";
			$this->db->query($sql);
		}
	}
	
	function _destroy($id)
	{
		$sql = "DELETE FROM ".$this->_table." WHERE sid = '$id'";
		$res = $this->db->query($sql);
		return $res ? true : false;
	}
	
	function _gc_sess($maxlifetime)
	{
		$sql = "DELETE FROM ".$this->_table." WHERE expire < ". (time() - $this->_gc_maxlifetime);
		$res = $this->db->query($sql);
		return $res ? true : false;
	}
	
} // end of class

cvs_id('$Id: fudbsession.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');

?>