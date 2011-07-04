<? 

//!! content
//! menuitem



include_once( $RELPATH . $COREPATH . 'avcolumn.class.php');

class menuitem extends avColumn
{

	var $table = 'menuitem';
	var $info;
	var $component;

	function menuitem()
	{
		avColumn::constructor();

		$this->tpl->set_file('temp', 'content/tpl/menuitem.html', 1);

		if (!empty($GLOBALS['menuitem'])) 
		{
			$this->info = $this->get_info($GLOBALS['menuitem']);
			$GLOBALS['menuname'] = $this->info['iname'];
		}
		elseif (!empty($GLOBALS['menuname'])) 
		{
			$this->info = $this->get_info_iname($GLOBALS['menuname']);
			$GLOBALS['menuitem'] = $this->info['id'];
		} 
		else 
		{
			$GLOBALS['menuitem'] = 0;
			$GLOBALS['menuname'] = '';
		}

		if (!empty($this->info)) $this->create_component();
		$this->tpl->set_var('menuitem', $GLOBALS['menuitem']);
	}

	function create_component()
	{
		global $RELPATH, $COREPATH;

		if (5 != $this->info['type']) return false;

		$names = explode('-', $this->info['column_id']);
		include_once($RELPATH . $names[0] . '/class/' . $names[1] . '.class.php');
		$this->component = new $names[1]('component');
	}

	/*!
		\return array with root menu items
	*/
	function get_menu_list()
	{
		return $this->db->get_result("SELECT * FROM $this->table WHERE visible !=0 and pid=0 ORDER BY sort_number");
	}


	function get_submenu_list($pid = false)
	{
		if (!$pid) return false;
		return $this->db->get_result("SELECT * FROM $this->table WHERE visible !=0 and pid=$pid ORDER BY sort_number");
	}


	/*!
		\return menu item $id	
	*/
	function get_info($id)
	{
		return $this->db->get_array("SELECT * FROM $this->table WHERE id=$id");
	}

	/*!
		\return menu item $iname	
	*/
	function get_info_iname($iname)
	{
		return $this->db->get_array("SELECT * FROM $this->table WHERE iname='$iname'");
	}



	function show_menu($input)
	{
		$list = $this->get_menu_list();
		
		for ($i = 0; isset($list[$i]); $i++)
		{
			if (1 == $list[$i]['type']) 
			{ 
				$list[$i]['url'] = $list[$i]['link']; 
			}
			else
			{
				$list[$i]['url'] = $_SERVER['SCRIPT_NAME'] . '/page.' . $list[$i]['page'] . ';menuitem.' . $list[$i]['id'];
			}
		}
		
		$this->tpl->set_loop('menu_list', $list);

		return $this->tpl->process('temp', 'menu_block', 2);
	}

	function show_menu_image($input = false) { 
		global $menuitem;
		
		if (isset($menuitem)&&!empty($menuitem)) {
			$info = $this->get_info($menuitem);
			if (isset($info['file'])&&!empty($info['file'])) {
				$this->tpl->set_var("file",$info["file"]);
				return $this->tpl->process("temp","menu_image");
			} else {
				return "";
			}			
		} else {
			return "";
		}		
	}


	function show_submenu($input = false)
	{
		global $menuitem;
		
		
		if (!isset($this->info) && $input) 
		{ 
			$this->info = $this->get_info_iname($input); 
			$menuitem = $this->info['id'];
		}
		
		if ($this->info['pid'])
		{
			$list = $this->get_submenu_list($this->info['pid']);
			$this->tpl->set_var('submenu_id', $this->info['pid']);

		}
		else
		{
			$list = $this->get_submenu_list($menuitem);
			$this->tpl->set_var('submenu_id', $menuitem);
		}
		
		for ($i = 0; isset($list[$i]); $i++)
		{
			if (1 == $list[$i]['type']) 
			{ 
				$list[$i]['url'] = $list[$i]['link']; 
			}
			else
			{
				$list[$i]['url'] = $_SERVER['SCRIPT_NAME'] . '/page.' . $GLOBALS['page'] . ';menuitem.' . $list[$i]['id'];
			}
		}
		
		$this->tpl->set_loop('submenu_list', $list);

		if (!$list) return '';

		return $this->tpl->process('temp', 'submenu_block', 2);
	}


	/*!
		iskvieciam sena ebent manageri, ir kvieciam blokui kuris includinamas	
	*/
	function event_manager($event)
	{
		avColumn::event_manager($event);

		global $RELPATH, $COREPATH;
		
		if (!isset($this->info)) 
		{ 
			return false;
		}
		
		if (5 == $this->info['type'])
		{
			return $this->component->event_manager($event);
		}
	
	}

	/*!
		\return string with content
	*/
	function show_output($input)
	{
		global $RELPATH, $COREPATH, $menuitem;

		if (!isset($this->info) && $input) 
		{
			$this->info = $this->get_info_iname($input); 
			$menuitem = $this->info['id'];
		}

		if (!$this->info) { redirect($RELPATH); }

		$this->tpl->set_var('page_title', $this->info['name']);
		
		switch($this->info['type'])
		{
			case 2: // html
					return $this->info['html'];
				break;
			case 3: // block

					include_once($RELPATH . 'blocks/class/block.class.php');

					$table =  new block();
					
					return $table->show($this->info['block_id']);
	
				break;
			case 4:	// include
					return implode(" ", @file($this->info['include']));
					break;
			case 5: // column
					if (!$this->component) $this->create_component();

					// split module table method
					$names = explode('-', $this->info['column_id']);
					
					if (empty($names[2])) { $names[2] = 'show_output'; }
					if (empty($names[3])) { $names[3] = ''; }

					$method = $names[2];
					$param = $names[3];

					return $this->component->$method($param);

				break;
		}
		
	}

}


?>