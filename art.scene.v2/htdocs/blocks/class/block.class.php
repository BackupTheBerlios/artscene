<? 

//!! blocks
//! userside

include_once( $RELPATH . $COREPATH . 'avcolumn.class.php');

class block extends avColumn
{

	var $db;
	var $tpl;
	var $table = 'avblock';

	function block()
	{
		avColumn::constructor();
	}


	function get_block($name)
	{
		$this->db->query("SELECT * FROM {$this->table} WHERE name='$name' AND visible!=0");
		if ($this->db->not_empty())
		{
			return $this->db->get_array();
		}
		else
		{
			return false;
		}
	}

	/*!
		show block	
	*/
	function show($input)
	{
		if (!$input) return '';
		$info = $this->get_block($input);

		if (!$info) return '';
		
		$this->tpl->set_file('block', 'blocks/tpl/'. $info['template']);
		$this->tpl->set_var('info', $info);

		return $this->tpl->process('out', 'block');
	}

	/*!
		\return string with 	
	*/
	function show_output($input)
	{
		return '';
	}

}


?>