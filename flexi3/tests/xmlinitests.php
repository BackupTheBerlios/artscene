<? 

require_once 'PHPUnit/PHPUnit_TestSuite.php';
include_once( RELPATH . COREDIR . 'fuxmlini.class.php');
include_once( RELPATH . COREDIR . 'fukernel.class.php');

/**
* 
*/

class xmliniTest extends PHPUnit_TestCase
{
	var $ini;

	function xmliniTest($name) 
	{
		$this->PHPUnit_TestCase($name);
	}

	function setUp()
	{
		
		$this->ini = new fuXmlIni(&$GLOBALS['g_kernel'], "xml_note.xml");
	}

	function testGetValue()
	{
		$var = $this->ini->getValue('to');
		$this->assertEquals('Tove', $var);
	}
	
	function testCdataValue()
	{
		$var = $this->ini->getValue('cdataTo');
		$this->assertEquals('ToveCdata',$var);
	}
	
	function testEncoding()
	{
		$var = $this->ini->getValue('lit');
		$this->assertEquals('אטזכבנרû90-‏',$var);
	}
	
}

set_time_limit(10);

?>