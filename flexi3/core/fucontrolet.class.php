<?
/**
	controlet abstraction
	
	Created: js, 2002.11.14
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package core	
*/


/**
* abstract controlet
* @version $Id: fucontrolet.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/
class fuControlet
{
	var $kernel = null;
	var $name = '';
	
	var $is_pop_up = false;
	
	function fuControlet(&$kernel)
	{
		$this->kernel =& $kernel;
		$this->name = get_class($this);
	
		debug("fuControlet[$this->name]: loaded.");
	}
	
	function isPopUp()
	{
		return $this->is_pop_up;
	}
	
	function process()
	{
		return 'kaip as ce zajabys visko primeistravau prikonstravau nnx :)';
	}
	
}

cvs_id('$Id: fucontrolet.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');
?>