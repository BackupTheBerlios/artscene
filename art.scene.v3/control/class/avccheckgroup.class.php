<? 
/*
	permission list for a group
	
	Created: js, 2001.08.16
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/



include_once($RELPATH . 'core/avcontrol.class.php');


//!! controls
//! permission list for a group


/*!
	special for users' groups permissions

	rodo ish duombazes visas permisijas uzhselektina tas kurias sako motinine lentele
*/
class avcCheckGroup extends avControl
{
	/*!
		no additional params
		define only first 3
	*/
	function avcCheckGroup(&$table, $name, $description, $default = '', $required = 0, $quered = 0, $list='', $header='', $order='')
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
	}
	
	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		avControl::constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
		$this->visible = true;
	}


	/*!
		name form control	
		overwrites 'temp' handle in template
	*/
	function show_edit()
	{
		global $g_db;

		$this->tpl->set_var('name', '_f_'.$this->name);
		$this->tpl->set_var('description', $this->description);
		$this->tpl->set_var('error', $this->error);

		$this->tpl->set_file('avcCheckGroup', 'control/tpl/'.$GLOBALS["g_theme_dir"].'avccheckgroup.html', 1);
		

		$modules = $this->modules_list();

		for ($index = 0; isset($modules[$index]); $index++)
		{
			$this->tpl->drop_var('permissions');
			$this->tpl->set_var('module', $modules[$index]);
			$permissions = $this->permissions_list($modules[$index]['id']);

			// check permissions
		for ($i = 0; isset($permissions[$i]); $i++)
		{
			if ($this->table->check_permission($permissions[$i]['id'])) 
			{
				$permissions[$i]['checked'] = 'checked';
			}
			else
			{
				$permissions[$i]['checked'] = '';
			}
			}
			

			$i = 0;
			while ( isset($permissions[$i]) ) // group by three
			{
				$this->tpl->set_var('permission1', '');
				$this->tpl->set_var('permission2', '');
				$this->tpl->set_var('permission3', '');

				for( $j = 0; isset($permissions[$i+$j]) && $j < 3; $j++)
				{
					$this->tpl->set_var('permission', $permissions[$i+$j]);
					$number = $j + 1;
					$this->tpl->process('permission' . $number, 'permission_block');
				}

				$i = $i + $j; // move pointer to next line

				$this->tpl->process('permissions', 'permission_row', 0, 0, 1);
		}
		

			
			$this->tpl->process('modules_list', 'module_block', 0, 0, 1);
		}

		$out = $this->tpl->process('temp', 'avcCheckGroup');

		$this->tpl->drop_var('name');
		$this->tpl->drop_var('description');
		$this->tpl->drop_var('error');

		return $out;
	}

	/*!
		make update	
	*/
	function after_change()
	{
		$this->table->drop_permissions();

		for ($i = 0; isset($this->value[$i]); $i++)
		{
			$this->table->create_permission($this->value[$i]);
		}
	}


	function modules_list()
	{
		global $g_db;
		return $g_db->get_result("SELECT id, name, info FROM u_module");
	}

	function permissions_list($module)
	{
		global $g_db;
		return $g_db->get_result("SELECT id, name, info 
									FROM u_permission 
									WHERE module_id=$module");
	}
}

?>