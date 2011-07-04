<? 
//js, 2001.08.17

//!! admin
//! vartotoju grupes

include_once($RELPATH . 'core/avtable.class.php');

include_once($RELPATH . 'control/class/avcid.class.php');
include_once($RELPATH . 'control/class/avctext.class.php');
include_once($RELPATH . 'control/class/avclinktext.class.php');
include_once($RELPATH . 'control/class/avcactions.class.php');
include_once($RELPATH . 'control/class/avccheckgroup.class.php');



class page_groups extends avTable
{

	function page_groups()
	{
		$this->constructor();
	}

	function constructor()
	{
		global $g_lang;

		avTable::constructor();

		$this->name = 'u_group';

		$this->controls[] = new avcId( &$this, 'id', '', '0', 0, 1, 1, 'id', 0);
		$this->controls[] = new avcLinkText( &$this, 'name', $g_lang['name'], '', 1, 1, 1, $g_lang['name'], 1, 20, 'page_users');
		$this->controls[] = new avcText( &$this, 'info', $g_lang['info'], '', 1, 1, 1, $g_lang['info'], 1, 40);
		$this->controls[] = new avcText( &$this, 'menu', $g_lang['groups_menu'], '', 1, 1, 0, $g_lang['groups_menu'], 1, 40);
		$this->controls[] = new avcCheckGroup( &$this, 'permissions', $g_lang['groups_permissions']);
		$this->controls[] = new avcActions( &$this, '', '', '', 0, 0, 1, $g_lang['list_rowactions'], 0);

		$this->description = $g_lang['groups_description'];

	}

	function check_permission($perm_id)
	{
		$this->db->query("SELECT id FROM u_permission_link WHERE permission_id=$perm_id AND group_id=$this->id");
		return $this->db->not_empty();
	}

	function drop_permissions()
	{
		$this->db->query("DELETE FROM u_permission_link WHERE group_id=$this->id");
	}

	function create_permission($perm_id)
	{
		$values['group_id'] = $this->id;
		$values['permission_id'] = $perm_id;
		$this->db->insert_query($values, 'u_permission_link');
	}
}


?>