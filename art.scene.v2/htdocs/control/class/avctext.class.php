<? 
/*
	input type text
	
	Created: js, 2001.08.16
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/



include_once($RELPATH . 'core/avcontrol.class.php');


//!! controls
//! input type text		


/*!
	input type text
*/
class avcText extends avControl
{
	var $size;

	/*!
		\param $size - size of input field
	*/
	function avcText(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $size)
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $size);
	}
	
	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $size)
	{
		avControl::constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
		$this->size = $size;
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
		$this->tpl->set_var('size', $this->size);
		
		$out = $this->tpl->process('temp', 'avcText_edit');

		$this->tpl->drop_var('name');
		$this->tpl->drop_var('description');
		$this->tpl->drop_var('value');
		$this->tpl->drop_var('error');
		$this->tpl->drop_var('size');

		return $out;
	}


}

?>