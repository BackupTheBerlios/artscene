<? 
/*
	Core table handler 
	
	Created: js, 2001.08.09
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/

//!! core lib
//! core table handler

/*!
	
	!abstract class use only derivatives!

	one of two main control classes

	CHANGES
	2001.09.19, js
	+ var $parent_module

*/

class avTable
{

	/// error handler
	var $error;

	/// db link
	var $db;

	/// template
	var $tpl;

	/// container
	var $controls = array();

	/// holds current list
	var $list;

	/// total number of items
	var $list_count = 0;

	/// db table name
	var $name = '';

	/// parent table name (category, group ...)
	var $parent = '';

	/// parent table module
	var $parent_module = '';

	/// current record id, not working currently, due to php strange behaviour
	var $id = 0;

	/// name to show for user
	var $description;

	var $pid = '';

	var $default_order = 'id';

	/// array with current fields
	var $fields;



	function avTable()
	{
		$this->constructor();
	}

	function constructor()
	{
		global $g_error, $g_db, $g_tpl;

		$this->error = & $g_error;
		$this->db = & $g_db;
		$this->tpl = & $g_tpl;
	}

	/*!
		save inf to db,
		each control must notify about his dbname and value

		if $update is set, will yous UPDATE query instead of REPLACE
		if $new is set, will set $this->id to inserted record id

		this will include only those controls having property $quered=true
		
		after general change operation, every control 
		can do his own commands in 'after_change()' method
	*/	
	function change()
	{
		global $update, $new;

		$values = array();
		for ($i = 0; isset($this->controls[$i]); $i++)
		{
			if ($this->controls[$i]->quered)
			{
				$values[$this->controls[$i]->name] = $this->controls[$i]->get_value_db();
			}
		}

		if (!empty($new))
		{
			$this->db->replace_query($values, $this->name);
		}
		else
		{
			$this->db->update_query($values, $this->name, array('id'=>$this->id));
		}

		if ($new) { $this->id = $this->db->get_insert_id(); }
		
		
		// some controls need additional db operations
		for ($i = 0; isset($this->controls[$i]); $i++)
		{
			$this->controls[$i]->after_change();
		}

	}
	
	/*!
		delete records
		\param $id - array or single id
	*/
	function delete($id)
	{
		if (!$id) {	return;	}

		if (is_array($id))
		{
			$this->db->query("DELETE FROM {$this->name}  WHERE id = " . implode(" OR id = ",$id));
		}
		else
		{
			$this->db->query("DELETE FROM {$this->name} WHERE id=$id");
		}
	}

	/*!
		check if all controls have valid values
	*/
	function validate()
	{
		$result = true;

		for ($i = 0; isset($this->controls[$i]); $i++)
		{
			$result &= $this->controls[$i]->validate();
		}

		return $result;
	}

	/*!
		set controls' variables after submit
	*/
	function pickup_submit()
	{
		for ($i = 0; isset($this->controls[$i]); $i++)
		{
			$this->controls[$i]->pickup_submit();
		}
	}

	/*!
		load one row from db
		set $this->id to current id
	*/
	function load($id)
	{
		$columns = array();
		for ($i = 0; isset($this->controls[$i]); $i++)
		{
			if ($this->controls[$i]->quered)
			{
				$columns[] = $this->controls[$i]->get_name_select_edit();
			}
		}
		
		$select = implode(', ', $columns);

		$tmp = $this->db->get_array("SELECT $select FROM {$this->name} WHERE id=$id");
		if ($this->db->is_empty()) { return false;}
		for ($i = 0; isset($this->controls[$i]); $i++)
		{
			if ($this->controls[$i]->quered)
			{
				$this->controls[$i]->set_value( $tmp[$this->controls[$i]->name] );
			}
		}
		
		$this->id = $tmp['id'];
									
		$this->fields = $tmp;
		return true;
	}


	/*!
		get list from db
		\param $loffset - where to start
		\param $count - how many items (ini(control,admincount))
		\param $order - ORDER BY $order
		\param $dearch - filter by this keyword
		\param $pid - if $this->pid is set, will filter by this parameter

		CHANGES: 
			js, 2001.10.31
			* query all controls, not only those on the list
	*/
	function get_list($loffset, $count, $order, $search = '', $pid = '')
	{
		global $search_old, $offset;

		if (!$order) { $order = $this->default_order; }

		if (isset($search_old) && ($search != $search_old)) { $offset = $loffset = 0; }
		// kazkoks turi buti order validatorius ?
		// select
		$columns = array();
		for ($i = 0; isset($this->controls[$i]); $i++)
		{
			//if ($this->controls[$i]->list && $this->controls[$i]->quered) //js, 2001.10.31
			if ($this->controls[$i]->quered)
			{
				$columns[] = $this->controls[$i]->get_name_select_list();
			}
		}
		$select = implode(', ', $columns);


		// search
		if ($search)
		{
			$columns = array();
			for ($i = 0; isset($this->controls[$i]); $i++)
			{
				if ($this->controls[$i]->quered)
				{
					$tmp = '';
					if ($tmp = $this->controls[$i]->get_search($search)) { $columns[] = $tmp; }
				}
			}
			$search = '(' . implode(' OR ', $columns) . ')';
		}
		else
		{
			$search = '';
		}
			
		if ($pid && isset($this->pid)) 
		{
			$filter = "$this->pid='$pid'";
		}
		else
		{
			$filter = '';
		}
		
		if ($filter && $search) 
		{ 
			$where = ' WHERE ' . $search . ' AND ' . $filter; 
		}
		elseif ($filter)
		{
			$where = ' WHERE ' . $filter;
		}
		elseif ($search)
		{
			$where = ' WHERE ' . $search;
		}
		else
		{
			$where = '';
		}

		if ($where)
		{
			if ($conditions = $this->conditions()) { $where .= " AND $conditions "; }
		}
		else
		{
			if ($conditions = $this->conditions()) { $where = " WHERE $conditions"; }
		}


		$this->list = $this->db->get_result("SELECT $select FROM {$this->name} $where ORDER BY $order LIMIT $loffset, $count");

		$tmp = $this->db->get_array("SELECT count(*) AS list_count FROM {$this->name} $where ORDER BY $order");

		$this->list_count = $tmp['list_count'];

		if (!$this->list) { return false; }

		return $this->list; 
	}


	/*!
		get row from already selected list	
		set all controls to that row
	*/
	function get_row($index)
	{
		if (!isset($this->list[$index])) { return false; }

		for ($i = 0; isset($this->controls[$i]); $i++)
		{
			if ($this->controls[$i]->list && $this->controls[$i]->quered)
			{
				$this->controls[$i]->set_value( $this->list[$index][$this->controls[$i]->name] );
			}
		}
		
		$this->id = $this->list[$index]['id'];

		$this->fields = $this->list[$index];
		
		return true;
	}


	/*!
		action dispatcher
		looks for a method 'action_$action' 
	*/
	function process($action)
	{
		if (!$action) { return true; }

		$name = 'action_' . $action;

		$this->$name();
	}

	/*!
		default action - delete
	*/
	function action_delete()
	{
		global $id, $table;

		check_permission( $table . '_delete');
		
		$this->delete($id);
	}

	/*!
		show edit from
		\return string
	*/
	function show_edit()
	{
		// visible fields
		for ($i = 0; isset($this->controls[$i]); $i++)
		{
			if ($this->controls[$i]->is_visible())
			{
				$this->tpl->set_var('style', $i % 2);
				
				$this->tpl->set_var('field', $this->controls[$i]->show_edit() );
				$this->tpl->process('edit_fields', 'edit_row', 0,0,1);
			}
		}

		// hidden fields
		$out = '';
		for ($i = 0; isset($this->controls[$i]); $i++)
		{
			if (!$this->controls[$i]->is_visible())
			{
				$out .= $this->controls[$i]->show_edit();
			}
		}

		$this->tpl->set_var('edit_fields_hidden', $out);



		// javascript
		$out = '';
		for ($i = 0; isset($this->controls[$i]); $i++)
		{
			$out .= $this->controls[$i]->script_on_submit();
		}

		$this->tpl->set_var('script_on_submit', $out);

		$this->tpl->set_var('table_inner_name', get_class($this));

		return $this->tpl->process('temp', 'edit_form');
	}


	/*!
		show list
		must call get_list first
	*/
	function show_list()
	{
		$this->tpl->set_var('list_headers', '');
		$this->tpl->set_var('list_rows', '');

		// get controls that will be present in the list
		$columns = array();
		for ($i = 0; isset($this->controls[$i]); $i++)
		{
			if ($this->controls[$i]->list)
			{
				$columns[] = & $this->controls[$i];
			}
		}

		// generate headers row
		for ($i = 0; isset($columns[$i]); $i++)
		{

			$this->tpl->set_var('name', $columns[$i]->get_header());
			if ($columns[$i]->order)
			{
				$this->tpl->set_var('order_up_str', $columns[$i]->order_desc);
				$this->tpl->process('order_up', 'order_up_block');
				$this->tpl->set_var('order_down_str', $columns[$i]->order_asc);
				$this->tpl->process('order_down', 'order_down_block');
			}
			else
			{
				$this->tpl->set_var('order_up', '');
				$this->tpl->set_var('order_down', '');
			}
			$this->tpl->set_var('header_params', $columns[$i]->get_header_params());
			$this->tpl->process('list_headers', 'list_header', 0, 0, 1);
		}

		// process rows
		for ($index = 0; $row = $this->get_row($index); $index++)
		{
			$this->tpl->drop_var('list_cells');

			$this->tpl->set_var('style', $index % 2);
			for ($i = 0; isset($columns[$i]); $i++)
			{
				$this->tpl->set_var('item', $columns[$i]->show_list());
				$this->tpl->set_var('list_params', $columns[$i]->get_list_params());
				$this->tpl->process('list_cells', 'list_cell', 0, 0, 1);
			}

			$this->tpl->process('list_rows', 'list_row', 0, 0, 1);
		}
		$this->tpl->set_var('navigator', $this->show_navigator());
		$this->tpl->set_var('list_actions', $this->show_action_list());

		$this->tpl->set_var('table_inner_name', get_class($this));

		return $this->tpl->process('temp', 'list_form');
	}




	/*!
		action list for selected records	
	*/
	function show_action_list()
	{
		return '<input type="radio" name="action" value="delete"> ' . $GLOBALS['g_lang']['list.delete'] . '<br>';
	}


	/*!
		navigator (paging control)
	*/
	function show_navigator()
	{
		global $offset, $g_ini, $g_lang;

		$ipp = $g_ini->read_var('control', 'AdminCount');
		$count = $this->list_count;

		$current_page = floor($offset / $ipp) + 1;
		$last =  floor(($count-1) / $ipp) + 1;

		
		$pages[0] = true;
		$pages[1] = true;
		$pages[$last] = true;

		for ($i = 1; $i <= $last; $i++)
		{
			if (!($i % 5)) { $pages[$i] = true; }
		}

		for ($i = $current_page - 2; $i < $current_page + 3; $i++)
		{
			$pages[$i] = true;
		}


		$link = self_url(array('page'), array( 'offset'=>(($current_page - 2) * $ipp) )) . 'page=list&';

		
		$out = '';

		if (1 == $current_page)
		{
			$out = '';
		}
		else
		{
			$out = "<a href='$link'>&lt;&lt;</a>";
		}

		for ($i = 1; $i <= $last; $i++)
		{

			$link = self_url(array('page'), array( 'offset'=>(($i - 1) * $ipp) )) . 'page=list&';
			if (isset($pages[$i]) && isset($pages[$i-1]))
			{
				if ($i == $current_page)
				{
					$out .= " <b>$i</b>";
				}
				else
				{
					$out .= " <a href='$link'>$i</a>";
				}
			}
			elseif(isset($pages[$i]))
			{
				$out .= " &middot;&middot;&middot; <a href='$link'>$i</a>";
			}
		}

		$link = self_url(array('page'), array( 'offset'=>(($current_page ) * $ipp) )) . 'page=list&';

		if (($last == $current_page) || !$count)
		{
			$out .= '';
		}
		else
		{
			$out .= " <a href='$link'>&gt;&gt;</a>";
		}

		$out .= "<br>". $g_lang['list.navigator.total'] .": $count";
		
		return $out;
	}



	/*!
		additional where conditions	
	*/
	function conditions()
	{
		return false;
	}

	function back()
	{
		global $parent_module, $parent_name, $PHP_SELF;
		if (empty($GLOBALS['pid']))
		{
			return '';
		}
		else
		{
			$pid_value = '';
			if ($this->pid) { $pid_value = $this->fields[$this->pid]; }
			return "<a class='border' href='$PHP_SELF?module=$parent_module&table=$parent_name&page=list&pid=$pid_value'>". $this->controls[1]->value .'</a> :: ';
		}
	}

}

?>