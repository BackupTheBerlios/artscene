<? 
//nk, 2001.10.26

//!! admin
//! vartotoju log'as [prisijungusiu prie administravimo]


/*!
	
	DROP TABLE IF EXISTS u_user_log;
	CREATE TABLE u_user_log (
	   id tinyint(4) NOT NULL auto_increment,
	   username varchar(255) NOT NULL,
	   logindate timestamp(14),
	   host varchar(255) NOT NULL,
	   browser varchar(255) NOT NULL,
	   PRIMARY KEY (id),
	   KEY id (id)
	);

*/

include_once($RELPATH . 'core/avtable.class.php');

include_once($RELPATH . 'control/class/avcid.class.php');
include_once($RELPATH . 'control/class/avctext.class.php');
include_once($RELPATH . 'control/class/avctimestamp.class.php');
include_once($RELPATH . 'control/class/avchidden.class.php');
include_once($RELPATH . 'control/class/avcbrowser_type.class.php');


class page_user_log extends avTable
{

	function page_user_log()
	{
		$this->constructor();
	}

	function constructor()
	{
		global $g_lang;
		avTable::constructor();


		$this->name = 'u_user_log';

		$this->controls[] = new avcId( &$this, 'id', '', '0', 0, 1, 0, '', 0);
		$this->controls[] = new avcHidden( &$this, 'username', $g_lang['log.username'], '', 1, 1, 1, $g_lang['log.username'], 1, 20);
		$this->controls[] = new avcTimeStamp( &$this, 'logindate', $g_lang['log.logindate'], '', 0, 1, 1, $g_lang['log.logindate'], 1);
		$this->controls[] = new avcHidden( &$this, 'host', $g_lang['log.host'], '', 0, 1, 1, $g_lang['log.host'], 1);

		//$this->controls[] = new avcHidden( &$this, 'browser', $g_lang['log.browser'], '', 0, 1, 1, $g_lang['log.browser'], 1, 20);
		$this->controls[] = new avcBrowser_type( &$this, 'browser', $g_lang['log.browser'], '', 0, 1, 1, $g_lang['log.browser'], 1, 20);
		$this->description = $g_lang['log.description'];
		
		$this->default_order = 'logindate desc, id desc';
	}

	function show_action_list()
	{
		return '';
	}

}


?>