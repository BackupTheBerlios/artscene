<?
/**
	abstract db driver
	
	Created: pukomuko, 2003.03.20
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package core	
*/


class fuDbDriver
{
	var $conn = null;
	var $result = null;
	
	function fuDbDriver()
	{
	}
	
	function pConnect($server, $user, $password)
	{
	}
	
	function selectDb($dbname)
	{
	}
	
	function errorMsg()
	{
	}
	
	function execute($sql)
	{
	}
	
	function rowCount()
	{
	}
	
	function getArray()
	{
	}
	
	function getInsertId()
	{
	}
	
	function selectLimit($sql, $numrows = -1, $offset = -1)
	{
	}	
}

cvs_id('$Id: fudbdriver.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');
?>