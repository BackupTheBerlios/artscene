<?
/*
	First file to include in work scripts

	Created: js, 2001.08.13
	
	$Id: site.ini.php,v 1.2 2005/12/03 22:45:01 pukomuko Exp $
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/

error_reporting(E_ALL);


// Path config
	$COREPATH="core/";
	$LIBPATH="lib/";
	$TPLPATH="tpl/";
	$LANGPATH = "lang/";

// some constants

  $SQL_DATE_FORMAT_LONG = '%Y.%m.%d %H:%s';
  $SQL_DATE_FORMAT_SHORT = '%Y.%m.%d';

//$bench = 1;

include_once($RELPATH . $COREPATH . "averror.class.php");
include_once($RELPATH . $COREPATH . "avdb.class.php");
include_once($RELPATH . $COREPATH . "avini.class.php");
include_once($RELPATH . $COREPATH . "phemplate.class.php");
include_once($RELPATH . $COREPATH . "avsession.class.php");
include_once($RELPATH . $COREPATH . "avuser.class.php");
include_once($RELPATH . $LIBPATH  . "util.lib.php");


if (isset($GLOBALS['bench'])) { echo "<br>checkpoint[includes]: " . round((getmicrotime() - $pradedam),2); }

$g_error = & new avError('report');

if (isset($GLOBALS['bench'])) { echo "<br>checkpoint[error]: " . round((getmicrotime() - $pradedam),2); }

$g_ini = & new avIni($RELPATH . 'global.ini.php');

if (isset($GLOBALS['bench'])) { echo "<br>checkpoint[ini]: " . round((getmicrotime() - $pradedam),2); }

if (empty($lang)) { $lang = $g_ini->read_var('site', 'Language'); }
include_once($RELPATH . $LANGPATH . $lang . '.inc.php');


if (isset($GLOBALS['bench'])) { echo "<br>checkpoint[lang]: " . round((getmicrotime() - $pradedam),2); }

$g_db = & new avDb();

if (isset($GLOBALS['bench'])) { echo "<br>checkpoint[db]: " . round((getmicrotime() - $pradedam),2); }

$g_sess = & new avSession ();

if (isset($GLOBALS['bench'])) { echo "<br>checkpoint[session]: " . round((getmicrotime() - $pradedam),2); }

$g_tpl = & new phemplate($RELPATH, 'keep');
$g_tpl->set_error_handler(&$g_error);

$g_tpl->set_var('RELPATH', $RELPATH);
$g_tpl->set_var('G_PHP_SELF', $PHP_SELF);
$g_tpl->set_var('lang', $g_lang);

$avms_version = '2.1';

$g_tpl->set_var('avms_version', $avms_version);
$g_tpl->set_var('users_online', $g_sess->users_online("registered"));

if (empty($g_user_id) || !$g_sess->userID) { $g_user_id = false; }

$g_usr = & new avUser($g_user_id);



?>
