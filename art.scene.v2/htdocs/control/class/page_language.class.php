<? 
//js, 2001.08.17

//!! admin
//! languages

include_once($RELPATH . 'core/avtable.class.php');

include_once($RELPATH . 'control/class/avcid.class.php');
include_once($RELPATH . 'control/class/avctext.class.php');
include_once($RELPATH . 'control/class/avclinktext.class.php');
include_once($RELPATH . 'control/class/avcactions.class.php');


class page_language extends avTable
{

	function page_language()
	{
		$this->constructor();
	}

	function constructor()
	{
		global $g_lang, $link_table, $link_module, $module;
		
		empty($link_module) && $link_module = $module;

		avTable::constructor();

		$this->name = 'languages';

		$this->controls[] = & new avcId( &$this, 'id', '', '0', 0, 1, 1, '', 0);

		if (empty($link_table))
		{
			$this->controls[] = & new avcText( &$this, 'name', $g_lang['name'], '', 1, 1, 1, $g_lang['name'], 1, 20);
		}
		else
		{
			$this->controls[] = & new avcLinkText( &$this, 'name', $g_lang['name'], '', 1, 1, 1, $g_lang['name'], 1, 20, $link_table, $link_module);
		}
	
		$this->controls[] = & new avcText( &$this, 'lang_name', $g_lang['info'], '', 1, 1, 1, $g_lang['info'], 1, 40);
		$this->controls[] = & new avcActions( &$this, '', '', '', 0, 0, 1, $g_lang['list_rowactions'], 0);

		$this->description = $g_lang['languages_description'];
	}

}


?>