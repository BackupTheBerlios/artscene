<?
class testapi
{
	var $kernel = null;
	
	function testapi( &$kernel )
	{
		$this->kernel =& $kernel;
		echo "uzloadyjo testapi";
	}
}
?>