<? 
/*
	ini file editor

	Created: js, 2001.09.02
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/


$RELPATH = "../";

include_once($RELPATH . 'site.ini.php');
include_once($RELPATH . $LIBPATH . 'header.inc.php');
check_permission('ini_edit_view');

$g_tpl->set_var('table_inner_name', 'ini_edit');
$g_ini = & new avIni($RELPATH . 'global.ini.php', true);

if (isset($submit))
{
	check_permission('ini_edit_edit');
	while (list($key, $value) = each($HTTP_POST_VARS)) if (1 == strpos($key, 'ni|'))
	{

		$names = explode('|', $key);
		$g_ini->set_var($names[1], $names[2], stripslashes($value));
		if ($names[2] == "Theme") {
			setcookie("g_theme",$value, time() + 360000000, "/");	
		}
	}

	$g_ini->save_data();
}


$g_tpl->set_file('ini_edit', 'control/tpl/'.$g_theme_dir.'ini_edit.html', 1);
$g_tpl->set_var('header', $g_lang['options']);

$groups = $g_ini->read_groups();

for ($index = 0; isset($groups[$index]); $index++)
{
	$g_tpl->set_var('description', $groups[$index]);
	$g_tpl->process('edit_fields', 'ini_header', 0, 0, 1);

	$items = $g_ini->read_group($groups[$index]);

	$style = 1;
	while ( (list($k, $v) = each($items)) && ($style++) )
	{
		$g_tpl->set_var('style', $style % 2);
		$g_tpl->set_var('name', $k);

		if ('site' == $groups[$index] && 'Language' == $k) 
		{
			$g_tpl->set_loop('select', get_language_select($v));
			$g_tpl->process('edit_fields', 'ini_row_select', 1, 0, 1);
		}
		elseif ('site' == $groups[$index] && 'Theme' == $k)
		{
			$g_tpl->set_loop('select', get_theme_select($v));
			$g_tpl->process('edit_fields', 'ini_row_select', 1, 0, 1);
		}
		elseif (false != strpos($k, 'password'))
		{
			$g_tpl->set_var('value', $v);
			$g_tpl->process('edit_fields', 'ini_row_password', 0, 0, 1);
		}
		else
		{
			$g_tpl->set_var('value', $v);
			$g_tpl->process('edit_fields', 'ini_row', 0, 0, 1);
		}
	}
}

$g_tpl->process('form', 'ini_edit');

echo $g_tpl->process('out', 'main');


?>