<? 
/*
	Actions for list row
	
	Created: js, 2001.08.20
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/



include_once($RELPATH . 'core/avcontrol.class.php');


//!! controls
//! actions for list row		


/*!
	Actions for list row
	Aways make derivative
*/
class avcActions extends avControl
{

	/*!
		constructor
		no additional parameters
	*/
	function avcActions(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
	}
	
	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		avControl::constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
		$this->visible = false;
	}


	/*!
		show form control	
	*/
	function show_edit()
	{
		return '';
	}

	/*!
		show on list
	*/
	function show_list()
	{
		global $g_lang;

		return "<a href='". self_url(array('page')) ."page=edit&id=" . $this->table_id() . "'>". $g_lang['list_edit'] ."</a>";
	}

	function pickup_submit()
	{
		return true;
	}
}

?>