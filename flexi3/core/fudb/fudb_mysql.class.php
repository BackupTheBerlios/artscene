<?
/**
	db driver for mysql
	
	Created: pukomuko, 2003.03.20
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package core	
*/


/**
*/
include_once( RELPATH . COREDIR . 'fudb/fudbdriver.class.php' );

/**
*/

class fuDb_mysql extends fuDbDriver
{
	var $replaceQuote = "\'";
	
	function fuDb_mysql()
	{
	}
	
	function pConnect($server, $user, $password)
	{
		$this->conn = @mysql_pconnect( $server, $user, $password );
		
		if (!$this->conn) return false;
		
		return true;
	}
	
	function selectDb($name)
	{
		 if(!@mysql_select_db( $name )) return false;
		 
		 return true;
	}
	
	function errorMsg()
	{
		return mysql_error();
	}
	
	function execute($sql)
	{
		$this->result = mysql_query($sql, $this->conn);
		return $this->result;
	}
	
	function rowCount()
	{
		if (!is_resource($this->result)) return 0;
		return @mysql_num_rows($this->result);
	}
	
	function getArray()
	{
		return mysql_fetch_assoc($this->result);
	}
	
	function getInsertId()
	{
		return mysql_insert_id($this->conn);
	}
	
	function selectLimit($sql, $numrows = -1, $offset = -1)
	{
		$offsetStr =($offset>=0) ? "$offset, " : '';
		$this->execute($sql . " LIMIT $offsetStr$numrows");
		
		if ($this->rowCount() < 1) return false;
		
		$index = 0;
		while ($row = mysql_fetch_assoc($this->result))
		{
			$res[$index] = $row;
			$index++;
		}
		mysql_free_result($this->result);
		$this->result = null;
		
		return $res;		
	}	
}

cvs_id('$Id: fudb_mysql.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');
?>