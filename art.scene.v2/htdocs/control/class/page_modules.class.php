<? 
//js, 2001.08.17

//!! admin
//! moduliai

include_once($RELPATH . 'core/avtable.class.php');

include_once($RELPATH . 'control/class/avcid.class.php');
include_once($RELPATH . 'control/class/avctext.class.php');
include_once($RELPATH . 'control/class/avclinktext.class.php');
include_once($RELPATH . 'control/class/avcactions.class.php');


class page_modules extends avTable
{

	function page_modules()
	{
		$this->constructor();
	}

	function constructor()
	{
		global $g_lang;
		avTable::constructor();


		$this->name = 'u_module';

		$this->controls[] = new avcId( &$this, 'id', '', '0', 0, 1, 1, '', 0);
		$this->controls[] = new avcLinkText( &$this, 'name', $g_lang['name'], '', 1, 1, 1, $g_lang['name'], 1, 20, 'page_permissions');
		$this->controls[] = new avcText( &$this, 'info', $g_lang['info'], '', 1, 1, 1, $g_lang['info'], 1, 40);
		$this->controls[] = new avcActions( &$this, 'info', 'info', '', 0, 0, 1, $g_lang['list_rowactions'], 0);

		$this->description = $g_lang['modules_description'];
	}

}


?>