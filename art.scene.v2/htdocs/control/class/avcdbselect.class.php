<? 
/*
	select box with info from db
	
	Created: js, 2001.08.20
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/



include_once($RELPATH . 'core/avcontrol.class.php');


//!! controls
//! select box with info from database


/*!
	select from database
	select box with info from database

*/
class avcDbSelect extends avControl
{
	var $s_table;
	var $c_value;
	var $c_name;
	var $s_order;
	var $empty;
	

	/*!
		\param $s_table - table to select from
		\param $c_value - column name for values
		\param $c_name - column for names
		\param $s_order - ordering parameters
	*/
	function avcDbSelect(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $s_table, $c_value, $c_name, $s_order = '', $empty = 'none')
	{
		avControl::constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
		$this->visible = true;

		$this->s_table = $s_table;
		$this->c_value = $c_value;
		$this->c_name = $c_name;
		$this->s_order = $s_order;
		$this->empty = $empty;
	}
	

	/*!
		name form control	
		overwrites 'temp' handle in template
	*/
	function show_edit()
	{
		global $g_db, $new, $pid;

		if (!empty($new)) { $this->value = $pid; }
		
		$this->tpl->set_var('name', '_f_'.$this->name);
		$this->tpl->set_var('description', $this->description);
		$this->tpl->set_var('error', $this->error);
		
		if ($this->s_order) { $this->s_order = " ORDER BY $this->s_order "; }
		$options = $g_db->get_result("SELECT $this->c_value AS o_value, $this->c_name AS o_name FROM $this->s_table $this->s_order");

		if ($this->empty != 'none')
		{
			// pastumiam masyva per viena
			for ($i = count($options); $i != 0; $i--)
			{
				$options[$i] = $options[$i - 1];
			}

			$options[0]['o_value'] = $this->empty;
			$options[0]['o_name'] = '';
		}

		for ($i = 0; isset($options[$i]); $i++)
		{
			if ($options[$i]['o_value'] == $this->value) 
			{
				$options[$i]['selected'] = 'selected';
			}
			else
			{
				$options[$i]['selected'] = '';
			}

		}
		
		$this->tpl->set_loop('options', $options);

		$out = $this->tpl->process('temp', 'avcDbSelect_edit', 2);

		$this->tpl->drop_var('name');
		$this->tpl->drop_var('description');
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