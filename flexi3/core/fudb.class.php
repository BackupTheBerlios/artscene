<? 
/**
	db abstraction
	
	Created: js, 2002.10.15
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package core	
*/

/**
*/


/**
* Db abstraction class
*
* 2003.03.20 major rewrite to have no adodb
*
* @version $Id: fudb.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
* @todo values from ini, error reporting
*/
class fuDb
{
	var $kernel = null;
	var $driver = null;
	var $resultRows = 0;
	
	function fuDb( &$kernel )
	{
		debug('fuDb: starting...');
		$this->kernel =& $kernel;
		$GLOBALS['g_db'] =& $this;
				
		include_once( RELPATH . CONFDIR . 'db.conf.php');
		
		$driver_name = DB_TYPE;
		
		include_once( RELPATH . COREDIR . "fudb/fudb_$driver_name.class.php");
		
		$driver_class = "fuDb_$driver_name";
		$this->driver = new $driver_class;
		
		
		
		$this->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		
		debug('fuDb: started.');
	}
	
	/**
	* @return void
	* @desc makes persistent connection
	*/
	function connect($server, $user, $password, $dbname)
	{
		if (!$this->driver->pConnect($server, $user, $password)) $this->error( $this->driver->errorMsg(), FU_E_NODB );
		return $this->selectDb($dbname);
	}
	
	function selectDb($name)
	{
		if (!$this->driver->selectDb($name)) $this->error( $this->driver->errorMsg(), FU_E_NODB );
	}
	
	
	/**
	* @return first row of result or false
	*/
	function query($sql)
	{
		debug('SQL: ' . $sql, 2);
		
		$this->resultRows = 0;
		
		if (!$this->driver->execute($sql))
		{
			$this->error($this->driver->errorMsg() . "<BR>$sql");
			return false;
		}
		$this->resultRows = $this->driver->rowCount();
		
		if (empty($this->resultRows)) return false;
		return $this->driver->getArray();		
	}
	
	/**
	*
	* @return void
	* @param sql string
	* @param numrows int top or number of rows after offset
	* @param offset int
	* @desc query("SELECT
	*/
	function select($sql, $numrows = -1, $offset = -1)
	{
		debug('SQL: ' . $sql, 2);
		$this->resultRows = 0;
		$recordset =& $this->driver->selectLimit($sql, $numrows, $offset);
		
		if ($this->driver->errorMsg())
		{
			$this->error($this->driver->errorMsg() . "<BR>$sql");
			return false;
		}
		$this->resultRows = $this->driver->rowCount();
		
		return $recordset;
	}
	
	/**
	* return one row of result set, or false
	*/
	function selectRow($sql)
	{
		if ($tmp = $this->select($sql, 1)) return $tmp[0];
		return false;	
	}
	
	/**
	* result of last select()
	* after query() true 1
	* @return bool
	* 
	* fix'as MSSQL'ui. $recordset->NumRows() grazhindavo -1 kai nebuo irasu
	*/
	function isEmpty()
	{
		if(empty($this->resultRows) || $this->resultRows <= 0)
			return true;
		else 
			return false;
		
	}
	
	/**
	* get last insert id
	*/
	function getInsertId()
	{
		return $this->driver->getInsertId();
	}
	
	/**
	* add slashes for select statement data
	*/
	function addSlashes($str)
	{
		return str_replace("'", $this->driver->replaceQuote, $str);
	}
	
	/**
	* report error message
	*/
	function error($msg, $level = FU_E_WARNING)
	{
		echo $this->kernel->error->report($level, "<B>SQL</B>: $msg");
	}
}

cvs_id('$Id: fudb.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');

?>