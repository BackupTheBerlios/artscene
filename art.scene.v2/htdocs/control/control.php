<? 
/*
	Main control script
	
	Created: js, 2001.08.13
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


if (empty($module)) { $module = ''; }
if (empty($table)) { $table = ''; }

$module = clean_name($module);
$table = clean_name($table);

// check if sent class really exists
if (!file_exists($RELPATH . $module . '/class/' . $table . '.class.php')) { redirect('/'); }
include_once($RELPATH . $module . '/class/' . $table . '.class.php');

$handler = new $table();

if (empty($pid)) 
{ 
	$pid = ''; 
	$g_tpl->set_var('back', '');
	$g_tpl->set_var('pid', '');
}
else
{
	$parent_module = $handler->parent_module ? $handler->parent_module : $module;
	$parent_name = $handler->parent;
	include_once($RELPATH . $parent_module . '/class/' . $parent_name . '.class.php');

	$parent = new $parent_name();
	$parent->load($pid);

	$g_tpl->set_var('back', $parent->back());
}



if (empty($page)) { $page = ''; }

if (empty($action)) { $action = ''; }
if (empty($order)) { $order = $handler->default_order; }
if (empty($offset)) { $offset = '0'; }
if (empty($search)) { $search = ''; }

if (empty($new)) { $new = ''; }
if (empty($update)) { $update = ''; }




$g_tpl->set_var('module', $module);
$g_tpl->set_var('offset', $offset);
$g_tpl->set_var('table', $table);
$g_tpl->set_var('order', $order);
$g_tpl->set_var('search', $search);

$g_tpl->set_var('pid', $pid);

$g_tpl->set_var('new', $new);

$g_tpl->set_var('header', $handler->description);

switch ($page)
{
	case 'edit':

			check_permission($table . '_list');

			if (isset($submit))
			{
				// for new record check 'table_new' permission first, if thre is no such, then 'table_edit'

				if ( ('0' == $_f_id) )
				{
					if (!is_permission($table . '_new')) check_permission($table . '_edit');
				}
				else
				{
					check_permission($table . '_edit');
				}

				$handler->pickup_submit();

				if ($handler->validate())
				{
					$handler->change();
					redirect($_SERVER['PHP_SELF'] . "?module=$module&table=$table&offset=$offset&order=$order&search=$search&pid=$pid&page=list");
				}
			}
			else
			{
			
				if (isset($id))
				{
					if (!$handler->load($id))
					{	
						// we have got erroneous id
					}
				}
			}

			$g_tpl->set_var('form', $handler->show_edit());

		break; // $page == 'edit'


	case 'list':

			check_permission($table . '_list');
			
			$handler->process($action);
			$handler->get_list($offset, $g_ini->read_var('control', 'AdminCount'), $order, $search, $pid);

			$g_tpl->set_var('form', $handler->show_list());

		break; // $page == 'list'



	default: $g_error->error('no page definition', 'fatal');
}


echo $g_tpl->process('out', 'main');


?>