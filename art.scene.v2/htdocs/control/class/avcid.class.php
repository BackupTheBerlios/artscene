<? 
/*
	id control
	
	Created: js, 2001.08.17
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/


include_once($RELPATH . 'core/avcontrol.class.php');


//!! controls
//! id control		


/*!
	edit hidden, list - checkbox, header - check all

	js, 2001.08.17
*/
class avcId extends avControl
{

	/*!
		constructor
		\param $header is always overloaded
	*/
	function avcId(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
	}
	
	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{

		// check all checkboxes
		$header = "

<script language='JavaScript'>
<!--

function do_check()
{
	check_all(document.list_form.check_all_button.checked);
}

function check_all(value)
{
	for (var i=0;i<document.list_form.elements.length;i++)
	{
		if (document.list_form.elements[i].type=='checkbox')
		{
			document.list_form.elements[i].checked = value;
		}
	}
}

//-->
</script>

<input type='checkbox' name='check_all_button' onClick='do_check();'>


			";

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

	/*!
		show list cell	
		overwrites 'temp' in template
	*/
	function show_list()
	{
		$this->tpl->set_var('value', $this->get_value_list());
		
		$out = $this->tpl->process('temp', 'avcId_list');

		$this->tpl->drop_var('value');

		return $out;
	}
	
	/*!
		set something like width=1%	
	*/
	function get_header_params()
	{
		return ' width="2" align="center" ';
	}
	
	function get_list_params()
	{
		return ' align="center" ';
	}

	/*!
		set table current id after submit
	*/
	function pickup_submit()
	{
		avControl::pickup_submit();
		$this->table->id = $this->value;
	}

}

?>