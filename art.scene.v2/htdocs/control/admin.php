<? 
/*
	first admin page, just help
	
	Created: js, 2001.09.07
*/

/*!

pagrindinis control scriptas
jam dodam parametrus o jis tada masto ka cia daryti 

$Id: admin.php,v 1.3 2006/10/09 14:04:09 pukomuko Exp $
*/

$RELPATH = '../';

include_once($RELPATH . 'site.ini.php');
include_once($RELPATH . $LIBPATH . 'header.inc.php');

set_time_limit(3600);

isset($page) || $page = '';

$g_tpl->set_var('header', ''); 
$g_tpl->set_var('table_inner_name', 'help');


switch ($page)
{
	case 'users_online': 
		check_permission('page_users_list');
		if (!empty($logout)) 
		{
			$g_db->query("DELETE FROM u_session WHERE userID='$logout'");
		}
		$g_tpl->set_file('temp', 'control/tpl/' . $g_theme_dir . 'admin_users_online.html');
		$g_tpl->set_loop('users', $g_usr->list_online_users());
		$g_tpl->process('form', 'temp', 2);
		break;

	case 'usage':
		include_once('usage/usage.class.php');
		$usage = & new usage();
		$g_tpl->set_var('temp', $usage->show_output());
		$g_tpl->process('form', 'temp');
		break;

	default:
	
	$g_tpl->set_file('form', 'control/tpl/' . $g_theme_dir . 'admin.html');

	
}

echo $g_tpl->process('out', 'main');

?>