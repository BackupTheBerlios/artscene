<? 
//js, 2001.09.02

$RELPATH = "../";

include_once($RELPATH . 'site.ini.php');
include_once($RELPATH . $LIBPATH . 'header.inc.php');

check_permission('settings_edit');

$g_tpl->set_var('table_inner_name', 'settings_edit');

// process

if (isset($submit))
{
	if (!empty($theme)&&!empty($language)) 
	{	
		if (('default' == $theme) || file_exists($RELPATH.'/control/tpl/'.$theme.'/admin_page.html')) {
			setcookie("g_theme", $theme, time() + 360000000, "/");
		}
		if (file_exists($RELPATH.'/lang/'.$language.'.inc.php')) {
			setcookie("lang", $language, time() + 360000000, "/");
		}
		redirect($GLOBALS['SCRIPT_NAME']);
	}
}

// show

if (empty($g_theme)) { $g_theme = $g_ini->read_var('site', 'Theme'); }
$g_tpl->set_loop('theme', get_theme_select($g_theme));

if (empty($lang)) { $lang = $g_ini->read_var('site', 'Language'); }
$g_tpl->set_loop('language', get_language_select($lang));

$g_tpl->set_file('settings_edit', 'control/tpl/'.$g_theme_dir.'settings_edit.html', 1);
$g_tpl->set_var('header', $g_lang['personal_settings']);


$g_tpl->process('form', 'settings_edit', 1);

echo $g_tpl->process('out', 'main');


?>