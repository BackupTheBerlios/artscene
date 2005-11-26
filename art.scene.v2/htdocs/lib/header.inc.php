<? 
/*
	Admin side header 
	
	Created: js, 2001.08.13
	
	$Id: header.inc.php,v 1.2 2005/11/26 16:44:04 pukomuko Exp $
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/
/*
	CHANGES:

	2001.09.07 js
		* left just different part from user_header.inc.php
*/

// Theme unsupport
$g_theme = "default";
$g_theme_dir = "";
 

// Global templates
$g_tpl->set_file('main', 'control/tpl/'.$g_theme_dir.'admin_page.html', 1);
$g_tpl->set_file('controls', 'control/tpl/'.$g_theme_dir.'controls.html', 1);


$g_tpl->set_var('user_name',$g_sess->get_var('g_user_name'));


	if (!$g_sess->userID)
	{
		redirect( $RELPATH . 'control/tpl/' . $g_theme_dir . 'timeout.html' );
	}


$tmp = $g_usr->get_group_info();

$g_tpl->set_file('menu_in', 'control/tpl/'.$g_theme_dir . $tmp['menu']);
$g_tpl->process('menu', 'menu_in');

?>
