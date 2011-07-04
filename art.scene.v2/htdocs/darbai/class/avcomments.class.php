<? 
//js, 2001.08.17


/*
CREATE TABLE avcomments (
   id int(11) unsigned NOT NULL auto_increment,
   subject varchar(200) NOT NULL,
   info text NOT NULL,
   posted datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   parent_id int(11) DEFAULT '0' NOT NULL,
   user_id int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (id)
);
*/
//!! new
//! komentarai

include_once($RELPATH . 'core/avtable.class.php');

include_once($RELPATH . 'control/class/avcid.class.php');
include_once($RELPATH . 'control/class/avctext.class.php');
include_once($RELPATH . 'control/class/avctextarea.class.php');
include_once($RELPATH . 'control/class/avcdbselect.class.php');
include_once($RELPATH . 'control/class/avcactions.class.php');
include_once($RELPATH . 'control/class/avchidden.class.php');
include_once($RELPATH . 'control/class/avcdate.class.php');



class avComments extends avTable
{
	var $version = '$Id: avcomments.class.php,v 1.3 2011/07/04 21:00:48 pukomuko Exp $';

	function avComments()
	{
		$this->constructor();
	}

	function constructor()
	{
		global $g_lang;
		avTable::constructor();

		$this->name = 'avcomments';
		$this->pid = 'parent_id';
		$this->parent = 'avworks';


		$this->controls[] = new avcId( &$this, 'id', '', '0', 0, 1, 1, 'id', 0);
		$this->controls[] = new avcText( &$this, 'subject', 'subjectas', '', 1, 1, 1, 'subjectas', 1, 20);
		$this->controls[] = new avcTextArea( &$this, 'info', 'info', '', 1, 1, 1, 'info', 1, 40, 5);
		$this->controls[] = new avcDate( &$this, 'posted', $g_lang['news_date'], date('Y.m.d'), 1, 1, 1, $g_lang['news_date'], 1);

		$this->controls[] = new avcDbSelect( &$this, 'parent_id', 'tetukas', '', 1, 1, 1, $g_lang['news_category'], 1, 'avnews', 'id', 'subject');
		
		$this->controls[] = new avcDbSelect( &$this, 'user_id', 'useris', '', 1, 1, 1, 'useris', 1, 'u_users', 'id', 'username');
		
		$this->controls[] = new avcHidden( &$this, 'table_name', '', $this->parent, 0, 1);		
		$this->controls[] = new avcActions( &$this, '', '', '', 0, 0, 1, 'Veiksmai', 0);

		$this->description = 'Komentarai';

	}


	function conditions()
	{
		return "table_name='$this->parent'";
	}
}


?>