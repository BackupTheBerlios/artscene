<?
/**
	abstract datamodel
	
	Created: js, 2002.11.14
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package core
*/

/**
* @version $Id: fudatamodel.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/
class fuDataModel
{
	var $owner = null;
	var $value = false;
	
	function fuDataModel( $value )
	{
		$this->value = $value;
	}
	
	function setValue()
	{
		$this->value = $value;
	}
}

cvs_id('$Id: fudatamodel.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');
?>