<?
/**
	session abstraction
	
	Created: js, 2002.11.04
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package core	
*/

/**
*/
include_once( RELPATH . COREDIR . 'session/fudbsession.class.php');

/**
* session abstraction class
*
* built on top of dbsession
* @version $Id: fusession.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/
class fuSession
{
	function fuSession(&$kernel)
	{
		debug('fuSession: starting...');
		
		$this->sess =& new fuDbSession(&$kernel->db);
		session_start();
		
		foreach ($_SESSION as $key=>$val) isset($GLOBALS[$key]) || $GLOBALS[$key] = $val;
		
		if (isset($_SESSION['g_user_id'])) $GLOBALS['g_user_id'] = $_SESSION['g_user_id'];
		
		debug('fuSession: started.');
	}
	
	function logout()
	{
		session_destroy();
	}
	
}

cvs_id('$Id: fusession.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');

?>