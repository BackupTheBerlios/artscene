<? 
/*
	first admin page, just help
	
	Created: js, 2001.09.07
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/

/*!

pagrindinis control scriptas
jam dodam parametrus o jis tada masto ka cia daryti 

*/

$RELPATH = '../';

include_once($RELPATH . 'site.ini.php');
include_once($RELPATH . $LIBPATH . 'header.inc.php');

empty($topic) && $topic = 'help';

if (!file_exists($RELPATH . 'control/tpl/help_' . $lang . '_' . $topic . '.html'))
{
	$topic = 'help';
}

$g_tpl->set_file('form', 'control/tpl/help_' . $lang . '_' . $topic . '.html');

$g_tpl->set_var('header', $g_lang['help']);

$g_tpl->set_var('table_inner_name', 'help');

echo $g_tpl->process('out', 'main');

?>