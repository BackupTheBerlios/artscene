<? 
/*
	Output block handler parent

	Created: js, 2001.09.04
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/

//!! core lib
//! Output block handler parent

class avColumn
{
	var $db;
	var $tpl;
	var $ini;
	var $name;
	var $component = false;


	function avColumn($comp = false)
	{
		$this->constructor($comp);
	}

	function constructor($comp = false)
	{
		global $g_tpl, $g_db, $g_ini;
		$this->db = & $g_db;
		$this->tpl = & $g_tpl;
		$this->ini = & $g_ini;
		if ($comp) $this->component = true;
	}

	/*!
		if exists call method 'event_$event'() 	
	*/
	function event_manager($event)
	{
		if (empty($event)) { return false; }
		$name = 'event_' . $event;
		$methods = get_class_methods(get_class($this));
		while (list($key, $value) = each($methods))
		{
			if ($value == $name) { return $this->$name(); }
		}
		return false;
	}

	/*!
		default output	
	*/
	function show_output($input)
	{
		return '';
	}
}


?>