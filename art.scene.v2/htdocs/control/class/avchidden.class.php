<? 
/*
	hidden parameter control
	
	Created: js, 2001.08.21
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/


include_once($RELPATH . 'core/avcontrol.class.php');


//!! controls
//! input type hidden


/*!
	not vissible for user		
*/
class avcHidden extends avControl
{

	/*!
		constructor
	*/
	function avcHidden(&$table, $name, $description, $default, $required, $quered, $list='', $header='', $order='')
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
	}
	
	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		avControl::constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
	}


	/*!
		show form control	
		hidden field
	*/
	function show_edit()
	{
		$out = "<input type='hidden' name='_f_$this->name' value='$this->value'>";
		return $out;
	}
	
}

?>