<? 
//js, 2001.08.17

//!! admin
//! teises

include_once($RELPATH . 'core/avtable.class.php');

include_once($RELPATH . 'control/class/avcid.class.php');
include_once($RELPATH . 'control/class/avctext.class.php');
include_once($RELPATH . 'control/class/avcdbselect.class.php');
include_once($RELPATH . 'control/class/avcactions.class.php');


class page_permissions extends avTable
{

	function page_permissions()
	{
		$this->constructor();
	}

	function constructor()
	{
		global $g_lang;
		avTable::constructor();


		$this->name = 'u_permission';
		$this->pid = 'module_id';
		$this->parent = 'page_modules';

		$this->controls[] = new avcId( &$this, 'id', '', '0', 0, 1, 1, 'id', 0);
		$this->controls[] = new avcText( &$this, 'name', $g_lang['name'], '', 1, 1, 1, $g_lang['name'], 1, 20);
		$this->controls[] = new avcText( &$this, 'info', $g_lang['info'], '', 0, 1, 1, $g_lang['info'], 1, 40);
		$this->controls[] = new avcDbSelect( &$this, 'module_id', $g_lang['permissions_module'], '', 1, 1, 1, $g_lang['permissions_module'], 1, 'u_module', 'id', 'name');
		$this->controls[] = new avcActions( &$this, '', '', '', 0, 0, 1, $g_lang['list_rowactions'], 0);

		$this->description = $g_lang['permissions_description'];
	}

}


?>