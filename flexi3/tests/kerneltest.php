<?
define ('RELPATH', '../');

include(RELPATH. 'site.header.php');

$kernel->loadApi('testapi');

//$kernel->db->query('SELECT NOW()');

isset($xui) && print($xui);
echo get_debug_log();

echo "<pre>".$g_cvs_id_log;
?>