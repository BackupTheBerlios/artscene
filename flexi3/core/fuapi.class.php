<?
/**
	api abstraction
	
	Created: js, 2002.11.07
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package core	
*/

/**
* abstract API
* @version $Id: fuapi.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/
class fuApi
{
	var $kernel = null;
	
	function fuApi( &$kernel )
	{
		$this->kernel =& $kernel;
		
		debug('fuApi[' . get_class($this) .']: starting...' );
	}
	
	
	/**
	* @return string
	*/
	function process()
	{
		return '';
	}
}

cvs_id('$Id: fuapi.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');
?>