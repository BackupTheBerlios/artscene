<? 
/*
	select box with info from db
	
	Created: js, 2001.08.20
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/



include_once($RELPATH . 'control/class/avcdbselect.class.php');


//!! controls
//! select box with info from database


/*!
	select from database
	select box with info from database

*/
class avcDbText extends avcDbSelect
{
	/*!
		\param $s_table - table to select from
		\param $c_value - column name for values
		\param $c_name - column for names
		\param $s_order - ordering parameters
	*/
	function avcDbText(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $s_table, $c_value, $c_name, $s_order = '', $empty = 'none')
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $s_table, $c_value, $c_name, $s_order, $empty);
	}

	/*!
		show form control	
		overwrites 'temp' handle in template
	*/
	function show_edit()
	{
		global $g_db;
		$tmp = $g_db->get_array("SELECT $this->c_name AS o_name FROM $this->s_table WHERE $this->c_value='$this->value'");

		$this->tpl->set_var('name', '_f_'.$this->name);
		$this->tpl->set_var('description', $this->description);
		$this->tpl->set_var('text', $tmp['o_name']);
		$this->tpl->set_var('error', $this->error);
		$this->tpl->set_var('value', $this->get_value_edit());

		
		$out = $this->tpl->process('temp', 'avcDbText_edit');

		$this->tpl->drop_var('name');
		$this->tpl->drop_var('description');
		$this->tpl->drop_var('text');
		$this->tpl->drop_var('value');
		$this->tpl->drop_var('error');

		return $out;
	}


	/*!
		!!! very slow
		generates query for every row on the list
	*/
	function show_list()
	{
		global $g_db;

		$tmp = $g_db->get_array("SELECT $this->c_name AS o_name FROM $this->s_table WHERE $this->c_value='$this->value'");

		return isset($tmp['o_name']) ? $tmp['o_name'] : '';
	}
}

?>