<? 
/*
	Input type password
	(2 password fields and hidden old password value)


	Created: js, 2001.08.09
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/



include_once($RELPATH . 'core/avcontrol.class.php');


//!! controls
//! input type password


/*!
	Input type password
	(2 password fields and hidden old password value)
*/
class avcPassword extends avControl
{
	var $size = 20;

	/*!
		constructor	
	*/
	function avcPassword(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $size = 20)
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $size);
	}
	
	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $size = 20)
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
		
		$out = $this->tpl->process('temp', 'avcPassword_edit');

		$this->tpl->drop_var('name');
		$this->tpl->drop_var('description');
		$this->tpl->drop_var('value');
		$this->tpl->drop_var('error');
		$this->tpl->drop_var('size');

		return $out;
	}
	
	/*!
		check if we need update
	*/
	function pickup_submit()
	{
		$name1 = '_f_' . $this->name . '1';
		$name2 = '_f_' . $this->name . '2';
		global $$name1, $$name2;

		avControl::pickup_submit();

		$this->value1 = $$name1;
		$this->value2 = $$name2;
	}

	/*!
		both fields must be equal
	*/
	function validate()
	{
		if ($this->value1)
		{
			if ($this->value1 == $this->value2)
			{
				$this->value = md5($this->value1);
			}
			else
			{
				$this->error = '*';
				return false;
			}
		}
		return true;
	}

}

?>