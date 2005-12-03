<? 
/*
	date control
	
	Created: js, 2001.08.22
	
	$Id$
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/



include_once($RELPATH . 'control/class/avcdate.class.php');


//!! controls
//! input type date plus


/*!
	input type date plus
*/
class avcDatePlus extends avcDate
{
  var $value_plus;
	/*!
		constructor	
	*/
	function avcDatePlus(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
	}
	
	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		avControl::constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
		$this->visible = true;
		$this->value_plus = '';
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
		$this->tpl->set_var('value', $this->value);
		$this->tpl->set_var('value_plus', $this->value_plus);
		

		$out = $this->tpl->process('temp', 'avcDatePlus_edit');

		$this->tpl->drop_var('name');
		$this->tpl->drop_var('description');
		$this->tpl->drop_var('value');
		$this->tpl->drop_var('value_plus');
		$this->tpl->drop_var('error');

		return $out;
	}

	/*!
		
	*/
	function pickup_submit()
	{
		$name = '_f_'.$this->name;
		$this->value = $GLOBALS[$name];

		
		$this->value_plus = $GLOBALS[$name.'_plus'];
		
		if (!empty($this->value_plus))
		{
		  $this->value = str_replace(".",'-', $this->value);
      $this->value =  date("Y-m-d",strtotime($this->value . " + ". $this->value_plus . " days" ) );
      $this->value_plus = '';
		  
		}
	}

}

?>
