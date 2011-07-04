<? 
/*
	select box
	
	Created: js, 2001.08.20
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/



include_once($RELPATH . 'core/avcontrol.class.php');


//!! controls
//! select box


/*!
	\param $values = array('0'=>'no', '1'=>'yes')
	don't set $required if you have value==0
*/
class avcSelect extends avControl
{
	var $s_values;

	/*!

		\param $values - array with names to show and values
	*/
	function avcSelect(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $values)
	{
		avControl::constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
		$this->visible = true;

		$this->s_values = $values;
	}

	/*!
		rodo selecta aktyvus tas kur value sutampa
		overwrites 'temp' handle in template
	*/
	function show_edit()
	{

		$this->tpl->set_var('name', '_f_'.$this->name);
		$this->tpl->set_var('description', $this->description);
		$this->tpl->set_var('error', $this->error);

		$options = array();
		
		while ( list($v, $k) = each ($this->s_values) )
		{
			if ($v == $this->value)
			{
				$options[] = array('value' => $v, 'name' => $k, 'selected' => 'selected');
			}
			else
			{
				$options[] = array('value' => $v, 'name' => $k, 'selected' => '');
			}

		}

		
		$this->tpl->set_loop('options', $options);

		$out = $this->tpl->process('temp', 'avcSelect_edit', 2);

		$this->tpl->drop_var('name');
		$this->tpl->drop_var('description');
		$this->tpl->drop_var('error');

		return $out;
	}

	/*!
		show selected value in list
	*/
	function show_list()
	{
		return isset($this->s_values[$this->value]) ? $this->s_values[$this->value] : '';
	}
}

?>