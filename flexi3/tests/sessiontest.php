<? 

require_once 'PHPUnit/PHPUnit_TestSuite.php';

/**
*  Session testai
*  @version $Id: sessiontest.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/

class sessionTest extends PHPUnit_TestCase
{
	function sessionTest($name) 
	{
		$this->PHPUnit_TestCase($name);
	}

	function setUp()
	{
		global $try, $test2, $test1, $del;
		
		if (!isset($try)) {
			$test1 = "Testavimas";
			$test2 = "String'quote";
			$del = "Delete me";
			session_register("test1");
			session_register("test2");
			session_register("del");
			header("Location: ".$GLOBALS['PHP_SELF']."?try=1");
			exit;
		}
	}

	function testGetValue()
	{
		if (isset($_SESSION['test1']))
			$var = $_SESSION['test1'];
		else 
			$var = 'negali pasiimti';
			
		$this->assertEquals('Testavimas', $var);
	}

	function testGetQuotedValue()
	{
		if (isset($_SESSION['test2']))
			$var = $_SESSION['test2'];
		else 
			$var = 'negali pasiimti';
			
		$this->assertEquals("String'quote", $var);
	}
	/**
	* kol kas neveikia
	*
	/*
	function testUnregister()
	{
		global $del;
		
		echo $del."1\n";
		if ($del == "Delete me") {
			session_unregister('del');
			echo $del."2\n";
			$this->assertTrue($del);
		} else {
			echo "no\n";
			$this->assertTrue(false);
		}
	}
	*/
	
}

set_time_limit(10);

?>