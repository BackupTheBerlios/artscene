<? 

require_once 'PHPUnit/PHPUnit_TestSuite.php';
include_once( RELPATH . COREDIR . 'fudb.class.php');

/**
* {@link fuComponent} testkeisas
*/
class dbTest extends PHPUnit_TestCase
{
	var $db;

	function dbTest($name) 
	{
		$this->PHPUnit_TestCase($name);
		$this->db =& $GLOBALS['g_kernel']->db;
	}

	function setUp()
	{
	
	}

	function testSelectTrue()
	{
		$res = $this->db->select("SELECT * FROM u_users");
		$this->assertTrue($res);
	}

	function testSelectResult()
	{
		$res = $this->db->select("SELECT * FROM u_users");
		$this->assertEquals($res[0]['username'], 'admin');
	}

	/**
	* selektas turi grazinti irasu, ir tikrinam ar pilna
	*/
	function testNotEmpty()
	{
		$res = $this->db->select("SELECT * FROM u_users WHERE username='admin'");
		$this->assertTrue(!$this->db->isEmpty());
	}

	/**
	* selektas neturi grazinti irasu, ir tikrinam ar nera
	*/
	function testEmpty()
	{
		$res = $this->db->select("SELECT * FROM u_users WHERE username='tokio tikrai nera'");
		$this->assertTrue($this->db->isEmpty());
	}
	
}

set_time_limit(10);
?>