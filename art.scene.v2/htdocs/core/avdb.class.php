<?
/*
	Database abstraction layer
	
	Created: js, 2001.07.09
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/
// $Id: avdb.class.php,v 1.2 2005/11/26 16:18:29 pukomuko Exp $
// js, 2003.01.20 cache
// dzhibas, 2001.11.27 - fixed update_query bug with IDS
// js, 2001.08.09 - global error hadler
// dzhibas, 2001.07.09 - class correction
// js, 2001.07.09

//!! core lib
//! database abstraction,  db interface

/*!
	\code
	$DB_HOST = 'localhost';
	$DB_USER = 'username';
	$DB_PASSWD = 'password';
	$DB_DBNAME = 'database_name';

	$db = new Db();
	$result = $db->get_result('select * from table');
	echo $result[0][id];	
	\endcode
	
CREATE TABLE `u_query_cache` (
 `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 200 ) NOT NULL ,
`query` TEXT NOT NULL ,
`result` LONGTEXT NOT NULL ,
`tablenames` VARCHAR( 255 ) NOT NULL ,
`expires` INT( 10 ) NOT NULL
);	
*/

class avDb
{

    /// the server to connect to
    var $server;
    /// the database to use
    var $dbname;
    /// the username to use
    var $user;
    /// the password to use
    var $password;

	/// error handler
	var $error;

	var $connection;
	var $queryresult;

   /*!
      Constructs a new Db object, connects to the db server and
      selects the desired database.

	  login data is taken from gb_ini
    */
	function avDb()
	{
		global $g_error;
		
		$ini =& avIni::globalINI();
		$this->error =& $g_error;

        $this->server = $ini->read_var('db', 'db_host');
        $this->dbname = $ini->read_var('db', 'db_name');
        $this->user = $ini->read_var('db', 'db_user');
        $this->password = $ini->read_var('db', 'db_password');
		
		$this->connect();

	}
	
	/*!
		opens connection to server
	*/
	function connect($server='', $user='', $password='', $dbname='')
	{
		if ($server)
		{
			$this->server = $server;
			$this->dbname = $user;
			$this->user = $password;
			$this->password = $dbname;
		}

        $this->connection = @mysql_pconnect( $this->server, $this->user, $this->password, MYSQL_CLIENT_COMPRESS );

		if (!$this->connection) redirect('/html');

        //or $this->error->error( "could not connect to the database server ($this->server, $this->user): " . mysql_error(), 'fatal' );
        
        @mysql_select_db( $this->dbname )
            or $this->error->error( "could not select the database ($this->dbname): " . mysql_error(), 'fatal' );
	}

	/*!
		executes query, returns query result handle
		\param $print - echo the sql statement
	*/
	function &query($q, $print = 0)
	{
		if (isset($GLOBALS['bench'])) $pradedam = getmicrotime();

		if ($print) { echo "<br><b>query: </b>" . htmlentities($q) . "<br>";}

		($this->queryresult = mysql_query($q, $this->connection)) or 
				$this->error->error("<b>bad SQL query</b>: " . htmlentities($q) . "<br><b>". mysql_error() ."</b>", 'warning');

		if (isset($GLOBALS['bench']))
		{
			echo "<br> query: <br> $q <br> <b>uztruko: ". round((getmicrotime() - $pradedam),4) ."</b><br>";
		}
		return $this->queryresult;
	}

	/*!
		returns assiociative array with one row from query result

		js, 2001.07.10, array -> assoc
		js, 2001.08.13 $sql
	*/
	function get_array( $sql = '', $print = false)
	{
		if ($sql) { $this->query($sql, $print); }
		return mysql_fetch_assoc($this->queryresult);
	}


	/*!
		free the result of query
	*/
	function free_result()
	{
		return mysql_free_result($this->queryresult);
	}

	/*!
		returns two dimensional assoc array
		frees mysql result
	*/
	function &get_result( $sql = '', $print = false )
	{
		if ($sql) { $this->query($sql, $print); }
		$c = 0;
		while ($row = mysql_fetch_assoc($this->queryresult))
		{
			$res[$c] = $row;
			$c++;
		}
		mysql_free_result($this->queryresult);
		return $res;
	}

	/*!
		keshuotas selectas
		$name - vardas selektui, kad sugrupuoti panashius querius
		$select - pats sakinys
		$tables - butinai array() su lentelemis, is kuriu vyksta select
		$expires, sekundes, po kuriu refreshinti informacija

		grazina informacija kaip ir get_result()
	*/
	function cached_select($name, $select, $tables, $expires)
	{
		// TESTING!
		// return $this->get_result($select);
		// ziurim ar yra uzkeshuota
		$tmp = $this->get_array("SELECT result FROM u_query_cache WHERE query='". addslashes($select) ."' AND expires > ". time());
		

		if ($tmp)
		{
			//die ('<br>atsiprasau, tvarkau [pukomuko]');
			return unserialize(gzuncompress($tmp['result']));
		}

		$result = $this->get_result($select);
		
		$statement = "INSERT INTO u_query_cache (name, query, result, tablenames, expires)
					  VALUES ('$name', '". addslashes($select) ."', '". addslashes(gzcompress(serialize($result))) ."',
					 '^". join( $tables, '^' ) ."^', '" . (time()+$expires) . "')";
		
		$this->query($statement);
		
		// nauji prisilogine pratrina cache
		if ($GLOBALS['g_sess']->is_new()) $this->query("DELETE FROM u_query_cache WHERE expires < " . time() );
		
		return $result;
	}

	function clear_cache_name($names)
	{
		if (!is_array($names)) $names = array($names);
		$this->query("DELETE FROM u_query_cache WHERE name='" . join($names, "' OR name='") . "'");
	}
	
	function clear_cache_tables($tables)
	{
		if (!is_array($tables)) $tables = array($tables);
		$this->query("DELETE FROM u_query_cache WHERE tablenames LIKE '%^" . join($tables, "^%' OR name='%^") . "^%'");
	}
	
	
	/*!
		older version of get_result
	*/
	function &get_result_array( $sql = '' )
	{
		if ($sql) { $this->query($sql); }
		$c = 0;
		while ($row = mysql_fetch_array($this->queryresult))
		{
			$res[$c] = $row;
			$c++;
		}
		mysql_free_result($this->queryresult);
		return $res;
	}

	/*!
		is query result set empty ?
	*/
	function is_empty($sql = '')
	{
		if ($sql) { $this->query($sql); }
		if (0 == mysql_num_rows($this->queryresult)) 
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	/*!
		is query result set valid ?
	*/
	function not_empty($sql = '')
	{
		if ($sql) { $this->query($sql); }
		if (0 == mysql_num_rows($this->queryresult)) 
		{
			return false;
		}
		else 
		{
			return true;
		}
	}

	
	/*!
		close db connection
	*/
	function close()
	{
		mysql_close();
	}


	/*!
		get id of last inserted record
	*/
	function get_insert_id()
	{
		return mysql_insert_id();
	}


	/*!
		generate INSERT statement
		\param $mas assiociative array, keys - column names
	*/
	function insert_query($mas, $table)
	{
		while(list($k,$v)=each($mas))
		{
			$to[] = $k;
			$val[] = $v;
		}

		$sql = "INSERT INTO $table (".implode(',',$to).") VALUES ('".implode("','",$val)."')";
		$result =& $this->query( $sql );
		
		if ($result) { return true; } else { return false; }
	}


	/*!
		generate UPDATE statement
		\param $mas assiociative array, keys - column names
	*/
	function update_query($mas, $table, $id)
	{

		if (is_array($id)) 
		{
			while(list($idn,$idv)=each($id)) 
			{
				$where[] = $idn."='$idv'";	
			}
		} 
		else 
		{
			$where[] = "id=$id";	
		}
		
				
		while(list($k,$v)=each($mas))
		{	
			$to[] = $k."='$v'";
		}

		$sql = "UPDATE $table SET ".implode(',',$to)." WHERE ".implode(" AND ",$where);
		
		$result =& $this->query( $sql );

		return $result;
	}


	/*!
		generate REPLACE statement
		\param $mas assiociative array, keys - column names
	*/
	function replace_query($mas, $table, $print = false)
	{
		while(list($k,$v)=each($mas))
		{	
			$to[] = $k;
			$val[] = $v;
		}

		$sql = "REPLACE INTO $table  (".implode(',',$to).") VALUES ('".implode("','",$val)."')";
		
		$result =& $this->query( $sql, $print );

		return $result;
	}


	/*!
	  Prints the error message.

	  if $on_error is set to 'halt' stops script execution
	*/
	function error($errmsg) 
	{ 
		echo  "<br><font color='#CC0066'><b>db</b>: ". $errmsg ."</font><br>";
		if ('halt' == $this->on_error) { exit; }
	}


}


?>
