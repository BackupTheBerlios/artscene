<?
$RELPATH = "../";

include_once($RELPATH . "site.ini.php");

$g_sess->logout();
redirect("index.php");


?>