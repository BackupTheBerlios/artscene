<? 
/*
	input type textarea with HTML support
	
	
	Created: Dzhibas, 2001.09.18
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
class avcTextArea_html extends avControl
{
	var $cols;
	var $rows;

	/*!
		constructor	
		\param $cols - columns
		\param $rows - rows of textarea
	*/
	function avcTextArea_html(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $cols, $rows)
	{

		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $cols, $rows);

	}
	
	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $cols, $rows)
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
		GLOBAL $g_theme_dir;
		
		$this->tpl->set_file('html_control','control/tpl/'.$g_theme_dir . 'avctextarea_html.html');
		$this->tpl->set_var('name', '_f_'.$this->name);
		$this->tpl->set_var('description', $this->description);
		$this->tpl->set_var('value', $this->get_value_edit());
		$this->tpl->set_var('error', $this->error);
		$this->tpl->set_var('cols', $this->cols);
		$this->tpl->set_var('rows', $this->rows);
	
		$out = $this->tpl->process('temp', 'html_control');

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
		$tmp = ereg_replace("\n|\r","",$this->value);
		return ereg_replace("\"","\\\"",$tmp);
	}
	
	
	function pickup_submit()
	{
		
		GLOBAL ${'_f_'.$this->name};
		
		$pos1 = strpos (${'_f_'.$this->name}, "<BODY>");
		$pos2 = strpos (${'_f_'.$this->name}, "</BODY>");

		$res = substr(${'_f_'.$this->name},$pos1+6,$pos2-20);
		$res = str_replace("</BODY>","",$res);
		$res = str_replace("</HTML>","",$res);
		$this->value = $res;
	}
	
	function script_on_submit()
	{
		return 'send_input();';
	}

}

?>