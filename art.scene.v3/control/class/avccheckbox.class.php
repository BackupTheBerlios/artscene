<? 
/*
	checkbox control
	
	Created: nk, 2001.11.13
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/



include_once($RELPATH . 'core/avcontrol.class.php');


//!! controls
//! check box controls		


/*!
	input type checkbox
*/
class avcCheckbox extends avControl
{
	var $size;

	/*!
		\param $size - size of input field
	*/
	function avcCheckbox(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
	}
	
	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		avControl::constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);

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
		
		$value = $this->get_value_edit();
		
		if ($value == "Y") {
			$this->tpl->set_var('checked', "checked");
		} else {
			$this->tpl->set_var('checked', "");	
		}
		$this->tpl->set_var('error', $this->error);
		
		$out = $this->tpl->process('temp', 'avcCheckbox_edit');

		$this->tpl->drop_var('name');
		$this->tpl->drop_var('description');
		$this->tpl->drop_var('checked');
		$this->tpl->drop_var('error');

		return $out;
	}
	
	function show_list() {
		
		if ($this->value == "Y") {
			
			$this->tpl->set_var("checked","y");
			$out = $this->tpl->process('temp', 'avcCheckbox_list');
			
			$this->tpl->drop_var("checked");
			
		} elseif ($this->value == "N") {
			$this->tpl->set_var("checked","n");
			$out = $this->tpl->process('temp', 'avcCheckbox_list');
			
			$this->tpl->drop_var("checked");
		}
		
		return $out;
	}
	
	function pickup_submit()
	{
		if(isset($GLOBALS["_f_".$this->name])&&$GLOBALS["_f_".$this->name]=="on") {
			$res = "Y";
		} else {
			$res = "N";	
		}
		
		$this->value = $res;
	}


}

?>