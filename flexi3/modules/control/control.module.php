<?
/**
	control module
	
	Created: js, 2002.11.07
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package control
*/

/**
*/
include_once( RELPATH . COREDIR . 'fumodule.class.php' );

/**
* @version $Id: control.module.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/
class control extends fuModule 
{
	function control(&$kernel)
	{
		parent::fuModule(&$kernel);
	}
	
	function getDefaultControletName()
	{
		return 'users';
	}
	
	function getSubMenu()
	{
		return 'sudai sudai ojojoj';
	}
}

cvs_id('$Id: control.module.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');
?>