<? 
/*
	file upload control
	
	Created: js, 2001.09.03
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/



include_once($RELPATH . 'core/avcontrol.class.php');


//!! controls
//! file upload


/*!
	file upload
*/
class avcFile extends avControl
{
	var $dir;
	var $url;

	/*!
		\param $dir - where to put uploaded files
		\param $url - how to access them by http
	*/
	function avcFile(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $dir, $url)
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $dir, $url);
	}

	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $dir, $url)
	{
		avControl::constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
		$this->visible = true;

		$this->dir = $dir;
		$this->url = $url;
	}


	/*!
		name form control	
		overwrites 'temp' handle in template
	*/
	function show_edit()
	{
		global $new;

		if ($new) 
		{
			$this->tpl->set_var('checked','checked');
		}
		else
		{
			$this->tpl->set_var('checked', '');
		}

		$this->tpl->set_var('name', '_f_'.$this->name);
		$this->tpl->set_var('value', $this->value);
		$this->tpl->set_var('upload_name', '_f_new_'.$this->name);

		$this->tpl->set_var('description', $this->description);
		$this->tpl->set_var('error', $this->error);

		
		
		$out = $this->tpl->process('temp', 'avcFile_edit', 2);

		$this->tpl->drop_var('name');
		$this->tpl->drop_var('description');
		$this->tpl->drop_var('error');

		return $out;
	}


	/*!
		pick file	
	*/
	function pickup_submit()
	{
		avControl::pickup_submit();
	
		$name = '_f_new_'.$this->name;
		$change = 'change_file_' . $name;
		
		global $$name, ${"$name"."_name"}, ${"$name"."_size"}, $$change;

		if (empty($$change)) return true;

		$file = $$name;
		if ($file == "none") return true;
		if (!$file) return true;

		if ($this->value) { unlink ($this->dir . '/' . $this->value); }

		$file_name = ${"$name"."_name"};
		$file_size = ${"$name"."_size"};
		
		$file_name = clean_name($file_name);
		$dest = $this->dir . "/$file_name";
		while (file_exists($dest)) 
		{ 
			$file_name = "_".$file_name;
			$dest = $this->dir."/$file_name";
		}
		copy ($file, $dest);
		unlink($file);

		$this->value = $file_name;

	}
}

?>