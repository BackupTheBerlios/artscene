<? 
//js, 2001.11.20



/*!
CREATE TABLE `avworks_delete_log` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
`admin_id` INT( 11 ) UNSIGNED NOT NULL ,
`posted` TIMESTAMP( 14 ) NOT NULL ,
`work_submiter` INT( 11 ) NOT NULL ,
`work_subject` VARCHAR( 255 ) NOT NULL ,
`work_posted` DATETIME NOT NULL ,
`work_votecount` INT NOT NULL ,
`work_summark` FLOAT NOT NULL ,
`work_avgmark` FLOAT NOT NULL ,
`work_category` INT( 11 ) NOT NULL ,
PRIMARY KEY ( `id` ) 
) TYPE = MYISAM ;

*/

//!! works
//! 


include_once($RELPATH . 'core/avtable.class.php');

include_once($RELPATH . 'control/class/avcid.class.php');
include_once($RELPATH . 'control/class/avctext.class.php');
include_once($RELPATH . 'control/class/avclinktext.class.php');
include_once($RELPATH . 'control/class/avctextarea.class.php');
include_once($RELPATH . 'control/class/avctextarea_html.class.php');
include_once($RELPATH . 'control/class/avctextarea_bbcode.class.php');
include_once($RELPATH . 'control/class/avcdate.class.php');
include_once($RELPATH . 'control/class/avcselect.class.php');
include_once($RELPATH . 'control/class/avcdbselect.class.php');
include_once($RELPATH . 'control/class/avcdbtext.class.php');
include_once($RELPATH . 'control/class/avcactions.class.php');
include_once($RELPATH . 'control/class/avcimage.class.php');
include_once($RELPATH . 'control/class/avchidden.class.php');

class avWorks_delete_log extends avTable
{
	var $version = '$Id: avworks_delete_log.class.php,v 1.1 2006/11/08 22:47:07 pukomuko Exp $';

	function avWorks_delete_log()
	{
		$this->constructor();
	}

	function constructor()
	{
		global $g_lang, $g_ini, $pid, $page;
		avTable::constructor();


		$this->name = 'avworks_delete_log';

		$this->controls[] = & new avcId( &$this, 'id', '', '0', 0, 1, 0, '', 0);
		$this->controls[] = & new avcDbText( &$this, 'admin_id', 'Trynikas', '', 1, 1, 1, 'Trynikas', 1, 'u_users', 'id', 'username');
		
		$this->controls[] = & new avcDate( &$this, 'posted', $g_lang['news_date'], date('Y.m.d'), 1, 1, 1, $g_lang['news_date'], 1);		


		$this->controls[] = & new avcDbSelect( &$this, 'work_category', 'Kategorija', '', 1, 1, 1, 'Kategorija', 1, 'avworkcategory', 'id', 'name');
		$this->controls[] = & new avcDbText( &$this, 'work_submiter', 'Autorius', $GLOBALS['g_user_id'], 1, 1, 1, 'Autorius', 1, 'u_users', 'id', 'username');
		$this->controls[] = & new avcHidden( &$this, 'work_subject', 'Pavadinimas', '', 0, 1, 1, 'Pavadinimas', 1);
		$this->controls[] = & new avcDate( &$this, 'work_posted', 'Atsiustas', date('Y.m.d'), 1, 1, 1, 'Atsiustas', 1);		

		$this->controls[] = & new avcHidden( &$this, 'work_votecount', 'Balsai', '', 0, 1, 1, 'Balsai', 1);
		$this->controls[] = & new avcHidden( &$this, 'work_summark', 'Suma', 0, 0, 1, 1, 'Suma', 1);
		$this->controls[] = & new avcHidden( &$this, 'work_avgmark', 'Vid.', 0, 0, 1, 1, 'Vid.', 1);

		$this->description = 'Darbø trynimai';

		$this->default_order = 'posted desc, id desc';
	}



	function show_action_list()
	{
		return '';
	}

}

?>