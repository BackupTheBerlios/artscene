<? 
/*
	timestamp control
	not visible, hidden
	
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
	input type timestamp
	js, 2001.08.22
*/
class avcTimeStamp extends avControl
{
	/*!
		constructor	
	*/
	function avcTimeStamp(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
	}
	
	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		avControl::constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
		$this->visible = false;
	}

	/*!
		DATE FORMAT	
	*/
	function get_name_select_edit()
	{
		
		return "DATE_FORMAT($this->name, '%Y.%m.%d %H:%i') AS $this->name";
	}


	/*!
		show form control
		overwrites 'temp' handle in template
	*/
	function show_edit()
	{
		$out = "<input type='hidden' name='_f_".$this->name."' value='".$this->value."'>";
		return $out;
	}
	


}

?>