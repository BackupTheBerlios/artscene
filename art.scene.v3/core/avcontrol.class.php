<? 
/*
	Core control handler
	
	Created: js, 2001.08.09
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/


//!! core lib
//! parent of all controls

/*!

CHANGES

	2001.09.07 js
		+ get_list_params()


*/

class avControl
{
	
	/// name of db column
	var $name;

	/// value
	var $value;

	var $description;

	var $error = '';

	/// is this element required to exist
	var $required;

	/// takes part in queries
	var $quered;

	/// should be shown on the list
	var $list;

	/// header of column in the list
	var $header;

	/// should have order links on the list
	var $order;

	var $order_asc;
	var $order_desc;
	
	var $visible;

	/// template
	var $tpl;

	/// link to table handler
	var $table;


	

	/*!
		\param $name - column name in database
		\param $description - text to show in editing form next to element
		\param $default - default value to show in new form
		\param $required - is record required to be 
		\param $list - show record in list?
		\param $header - how column header in list should be named
		\param $order - boolean, or array
			if true order controls will be shown next to header
			array('ascending sort', 'descending sort')
	*/
	function avControl( &$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
	}

	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		global $g_tpl;

		$this->name = $name;
		$this->value = $default;
		$this->description = $description;
		$this->required = $required;

		$this->quered = $quered;

		$this->list = $list;
		$this->header = $header;

		if (is_array($order))
		{
			$this->order = true;
			list($this->order_asc, $this->order_desc) = $order; 
		}
		else
		{
			$this->order = $order;
			$this->order_asc = $this->name . ' asc ';
			$this->order_desc = $this->name . ' desc ';
		}

		$this->tpl = & $g_tpl;
		$this->table = & $table;

		$this->visible = false;
	}

	/*!
		\return true if control should have it's own <tr> line
	*/
	function is_visible()
	{
		return $this->visible;
	}


	/*!
		value for db	
	*/
	function get_value_db()
	{
		return $this->value;
	}


	/*!
		value for edit	
	*/
	function get_value_edit()
	{
		return $this->value;
	}

	/*!
		value for list	
	*/
	function get_value_list()
	{
		return $this->value;
	}

	/*!
		get column name for select statement
		you'll want to add something like DATE_FORMAT, or IF(), SUM functions to sql
	*/
	function get_name_select_edit()
	{
		return $this->name;
	}

	/*!
		get column name for select for edit form	
	*/
	function get_name_select_list()
	{
		return $this->get_name_select_edit();
	}

	/*!
		get expression for sql where clause	
	*/
	function get_search($search)
	{
		return $this->name . " LIKE '%" . $search. "%'";
	}

	/*!
		header for list	
	*/
	function get_header()
	{
		return $this->header;
	}

	
	/*!
		set something like width=1%	
	*/
	function get_header_params()
	{
		return '';
	}

	/*!
		set something like align=right	
	*/
	function get_list_params()
	{
		return '';
	}

	/*!
		validate element 	
		\return true if everything ok
	*/
	function validate()
	{
		$result = true;
		if ($this->required && !$this->value) { $result = false; }

		if (!$result) { $this->error = '*'; }

		return $result;
	}


	/*!
		set value for control
	*/
	function set_value($value)
	{
		$this->value = $value;
	}

	
	/*!
		show form control	
	*/
	function show_edit()
	{
		return '';
	}


	/*!
		show list cell	
	*/
	function show_list()
	{
		$out = $this->get_value_list();
		return $out;
	}

	/*!
		javascript executed on submit
		formname = 'edit_form'
	*/
	function script_on_submit()
	{
		return '';
	}


	/*!
		get values from edit form	
	*/
	function pickup_submit()
	{
		$name = '_f_'.$this->name;
		$this->value = $GLOBALS[$name];
	}

	/*!
		return id of current row
	*/
	function table_id()
	{
		/*
		$_temp = '__temp_table_' . get_class($this->table) . '_id';
		global $$_temp;

		return $$_temp;
		*/

		return $this->table->id;
	}

	/*!
		additional saving functions	
	*/
	function after_change()
	{
		return true;
	}

}


?>