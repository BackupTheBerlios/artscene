<? 
/*
	date control
	
	Created: js, 2001.08.22
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/



include_once($RELPATH . 'core/avcontrol.class.php');


//!! controls
//! input type date


/*!
	input type date
*/
class avcDate extends avControl
{
	/*!
		constructor	
	*/
	function avcDate(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
	}
	
	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		avControl::constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
		$this->visible = true;
	}

	/*!
		DATE FORMAT	
	*/
	function get_name_select_edit()
	{
		
		return "DATE_FORMAT($this->name, '%Y.%m.%d') AS $this->name";
	}


	/*!
		show form control
		overwrites 'temp' handle in template
	*/
	function show_edit()
	{
		$this->tpl->set_var('name', '_f_'.$this->name);
		$this->tpl->set_var('description', $this->description);
		$this->tpl->set_var('error', $this->error);
		$this->tpl->set_var('select', html_build_date($this->name, $this->value));
		

		$out = $this->tpl->process('temp', 'avcDate_edit');

		$this->tpl->drop_var('name');
		$this->tpl->drop_var('description');
		$this->tpl->drop_var('select');
		$this->tpl->drop_var('error');

		return $out;
	}

	/*!
		get info from 3 select boxes
	*/
	function pickup_submit()
	{
		$year = $this->name . '_year';
		$month = $this->name . '_month';
		$day = $this->name . '_day';
		global $$year, $$month, $$day;

		$this->value = $$year . "." . $$month . "." . $$day;
	}

}

?>