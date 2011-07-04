<? 
/*
	text control with link in list
	
	Created: js, 2001.08.16
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/

include_once($RELPATH . 'control/class/avctext.class.php');


//!! controls
//! text control with link in list


/*!
	text control for categories, list with link

	2001.09.19, js
	+ var $link_module
*/
class avcLinkText extends avcText
{

	/// name of table to link to
	var $link;
	var $link_module;

	/*!
		\param $link - name of table to link to
	*/
	function avcLinkText(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $size, $link, $link_module='')
	{
		$this->constructor_overloaded(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $size, $link, $link_module);
	}
	
	function constructor_overloaded(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $size, $link, $link_module='')
	{
		global $module;
		parent::avcText(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $size);
		$this->link = $link;
		if (empty($link_module))
		{
			$link_module = $module;
		}
		$this->link_module = $link_module;
		
	}


	function show_list()
	{
		$this->tpl->set_var('value', $this->get_value_list());
		$this->tpl->set_var('link', $this->link);
		$this->tpl->set_var('link_module', $this->link_module);

		$this->tpl->set_var('lpid', $this->table_id());

		
		$out = $this->tpl->process('temp', 'avcLinkText_list');

		$this->tpl->drop_var('value');
		$this->tpl->drop_var('link');
		$this->tpl->drop_var('lpid');

		return $out;
	}


}

?>