<?
/**
*	@version $Id: session.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/

define('RELPATH', '../');

include_once( RELPATH . 'site.header.php');

//sess = new fuSession(&$kernel);
	
//session_save_path('./tmp');
//ini_set('session.gc_probability',0);


//session_register('new');

$_SESSION['new']++;
//$_SESSION['insert'] = 'naujas';
// session_destroy();

echo "Sessijos ID: ". session_id();
echo "<br>";
echo "Ini session.auto_start value: " . ini_get('session.auto_start');
echo "<br>";
echo "session.gc_probability: " . ini_get('session.gc_probability');
echo "<br>";
echo "GC maxlifetime: " . ini_get('session.gc_maxlifetime');
echo "<br>";
echo "Session superglobal kint.: <br>";
print_r($_SESSION);
echo "<br>";
echo "Session module name: ".session_module_name();
echo "<br>";
	
//session_register("new");
//$new = "infostring";
//session_destroy();
?>