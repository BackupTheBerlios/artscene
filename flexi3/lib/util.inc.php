<?
/**
	additional functions

	Created: js, 2002.10.15
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
* @version $Id: util.inc.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
* @package core
*/

/**
*/
$g_debug_log = array();
$g_debug_count = 0;
$g_debug_first = getmicrotime();

function debug($msg, $level = 0)
{
	if ($level < $GLOBALS['g_debug_level']) return;
	$GLOBALS['g_debug_log'][$GLOBALS['g_debug_count']]['msg'] = $msg;
	$GLOBALS['g_debug_log'][$GLOBALS['g_debug_count']]['time'] = getmicrotime();
	$GLOBALS['g_debug_count']++;
}

function get_debug_log()
{
	$last = $GLOBALS['g_debug_first'];
	
	$out = "";
	foreach( $GLOBALS['g_debug_log'] as $item )
	{
		$time = $item['time'] - $last;
		$time = round($time, 3);
		if ('0' == $time) $time = '0.000';
		$time = str_pad($time, 5, '0');
		$out .= "\n[$time] $item[msg]"; 
		$last = $item['time'];
	}
	
	$time = $last - $GLOBALS['g_debug_first'];
	$time = round($time, 3);
	$out .= "\n[$time] total"; 
	return $out;
}

function getmicrotime()
{ 
	list($usec, $sec) = explode(" ",microtime()); 
	return ((float)$usec + (float)$sec); 
}


$g_lang = array();
function l($str)
{
	return $GLOBALS['g_lang'][$str];
}

/**
* prints out redirection page
* header, javascript, link
*/
function redirect($page)
{	
	header("Location: $page");
	
	?> 
	<html><head><title>redirect</title>
	<meta http-equiv="Refresh" content="0; URL=<? echo $page ?>">
	</head>

	<body>
	<script language="JavaScript">
	<!--
	window.location = '<? echo $page ?>';
	//-->
	</script>
	<a href="<? echo $page ?>"><b>spauskit èia / click here</b></a>
	
	</body>
	</html>
	<?
	exit;
}

/**
* @return userhost
*/
function remote_addr()
{
	global $HTTP_SERVER_VARS;

	if (!empty($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR']))
	{
		$proxy = @gethostbyaddr($HTTP_SERVER_VARS['REMOTE_ADDR']);
		$host = @gethostbyaddr($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR']);
		
		return "$host [proxy: $proxy]";
	}
	else
	{
		return @gethostbyaddr($HTTP_SERVER_VARS['REMOTE_ADDR']);
	}
}

function clean_name($name)
{
	return ereg_replace("[^0-9a-zA-Z_.]","",$name);	
}

cvs_id('$Id: util.inc.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');

?>