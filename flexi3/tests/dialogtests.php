<? 

require_once 'PHPUnit/PHPUnit_TestSuite.php';
require_once 'fucomponent.class.php';
require_once 'fucontainer.class.php';
require_once 'fulayout.class.php';

/**
* {@link fuComponent} testkeisas
*/
class componentTest extends PHPUnit_TestCase
{
	var $com;

	function componentTest($name) 
	{
		$this->PHPUnit_TestCase($name);
	}

	function setUp()
	{
		$this->com = new fuComponent();
	}

	function testCreate()
	{
		$com = new fuComponent();
		$this->assertNotNull($com);
	}
	
}


class containerTest extends PHPUnit_TestCase
{
	var $cont;

	function containerTest($name) 
	{
		$this->PHPUnit_TestCase($name);
	}

	function setUp()
	{
		//$this->tpl = new phemplate('./', 'remove_nonjs');
		$this->cont = new fuContainer();
	}

	function testCreate()
	{		
		$cont = new fuContainer();
		$this->assertNotNull($cont);
	}
	
}

class dialogTest extends PHPUnit_TestCase
{
	var $cont;

	function containerTest($name) 
	{
		$this->PHPUnit_TestCase($name);
	}

	function setUp()
	{
		$this->cont = new fuContainer();
	}

	function testCreate()
	{
		$cont = new fuContainer();
		$this->assertNotNull($cont);
	}
	
	function testSetLayout()
	{
		$this->cont->setLayout(new fuLayout());
	}
	
	function testBig()
	{
		$panel = new fuPanel();
		$panel->setLayout(new fuFlowLayout());
		$panel->add( new fuText("name", array('blahah'=>3)));
		
	}
	
}

set_time_limit(10);

?>