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
//! image upload


/*!
	image upload
*/
class avcImage extends avControl
{
	var $dir;
	var $url;
	var $xsize;
	var $ysize;

	/*!
		\param $dir - where to put uploaded files
		\param $url - how to access them by http
	*/
	function avcImage(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $dir, $url, $xsize = false, $ysize = false)
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $dir, $url, $xsize, $ysize);
	}

	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order, $dir, $url, $xsize = false, $ysize = false)
	{
		avControl::constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
		$this->visible = true;

		$this->dir = $dir;
		$this->url = $url;
		$this->xsize = $xsize;
		$this->ysize = $ysize;
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
		
		if (!$this->value)
		{
			$this->tpl->set_var('image', '');
		}
		else
		{
			$this->tpl->set_var('image', '<img src="' . $this->url . $this->value . '" border=0>');
		}


		
		
		$out = $this->tpl->process('temp', 'avcImage_edit', 2);

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
		
//		global $$name, ${"$name"."_name"}, ${"$name"."_size"};

		if (empty($GLOBALS[$change])) return true;


		$file = $GLOBALS[$name];
		if ($file == "none") return true;
		if (!$file) return true;

		if (!empty($this->value)) { unlink ($this->dir . '/' . $this->value); }

		$file_name = $GLOBALS["$name"."_name"];
		$file_size = $GLOBALS["$name"."_size"];
		
		$file_name = clean_name($file_name);
		$dest = $this->dir . "/$file_name";

		if ($this->xsize && $this->ysize)
		{

			while (file_exists($dest . '.jpg')) 
			{ 
				$file_name = "_".$file_name;
				$dest = $this->dir."/$file_name";
			}

			$this->resize_image_IM($file, $dest . '.jpg', $this->xsize, $this->ysize);
			$file_name = $file_name . '.jpg';
		}
		else
		{
			while (file_exists($dest)) 
			{ 
				$file_name = "_".$file_name;
				$dest = $this->dir."/$file_name";
			}

			copy ($file, $dest);
		}

		
		unlink($file);

		$this->value = $file_name;

	}

	function resize_image_IM($filename, $dest, $neww=50, $newh=70)
	{
		global $g_ini;	
		$exec_src = $g_ini->read_var('avnews', 'im_convert') ." -sample ".$neww."x".$newh." $filename jpg:$dest";

		
		exec($exec_src);
	}

}

?>