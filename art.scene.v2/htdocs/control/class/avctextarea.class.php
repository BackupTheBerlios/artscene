<? 
/*
	input type textarea
	nieko nedaro su inputu
	
	Created: js, 2001.08.22
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/



include_once($RELPATH . 'core/avcontrol.class.php');


//!! controls
//! input type textarea


/*!
	input type textarea
*/
class avcTextArea extends avControl
{
	var $cols;
	var $rows;

	/*!
		constructor	
		\param $cols - columns
		\param $rows - rows of textarea
	*/
	function avcTextArea(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $cols, $rows)
	{
		avControl::constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
		$this->cols = $cols;
		$this->rows = $rows;
		$this->visible = true;
	}


	/*!
		show form control
		overwrites 'temp' handle in template
	*/
	function show_edit()
	{
		$this->tpl->set_var('name', '_f_'.$this->name);
		$this->tpl->set_var('description', $this->description);
		$this->tpl->set_var('value', $this->get_value_edit());
		$this->tpl->set_var('error', $this->error);
		$this->tpl->set_var('cols', $this->cols);
		$this->tpl->set_var('rows', $this->rows);
		
		$out = $this->tpl->process('temp', 'avcTextArea_edit');

		$this->tpl->drop_var('name');
		$this->tpl->drop_var('description');
		$this->tpl->drop_var('value');
		$this->tpl->drop_var('error');
		$this->tpl->drop_var('cols');
		$this->tpl->drop_var('rows');

		return $out;
	}
	
	/*!
		substr first 100 characters
	*/
	function get_value_list()
	{
		return substr($this->value, 0, 100);
	}

	/*!
		change html->ubb
	*/
	function get_value_edit()
	{
		return htmlspecialchars($this->value);
	}

}

?>