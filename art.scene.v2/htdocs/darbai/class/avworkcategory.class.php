<? 
//js, 2001.08.17


/*!

CREATE TABLE avworkcategory (
   id int(11) unsigned NOT NULL auto_increment,
   name varchar(200) NOT NULL,
   info varchar(255) NOT NULL,
   file varchar(255) NOT NULL,
   sort_number tinyint(4) DEFAULT '1' NOT NULL,
   PRIMARY KEY (id)
);


*/

//!! darbai



include_once($RELPATH . 'core/avtable.class.php');

include_once($RELPATH . 'control/class/avcid.class.php');
include_once($RELPATH . 'control/class/avctext.class.php');
include_once($RELPATH . 'control/class/avclinktext.class.php');
include_once($RELPATH . 'control/class/avcactions.class.php');
include_once($RELPATH . 'control/class/avcimage.class.php');

class avWorkCategory extends avTable
{
	var $version = '$Id: avworkcategory.class.php,v 1.3 2011/07/04 21:00:48 pukomuko Exp $';

	function avWorkCategory()
	{
		$this->constructor();
	}

	function constructor()
	{
		global $g_lang;
		avTable::constructor();


		$this->name = 'avworkcategory';

		$this->controls[] = new avcId( &$this, 'id', '', '0', 0, 1, 1, '', 0);
		
		$this->controls[] = new avcLinkText( &$this, 'name', $g_lang['news_subject'], '', 1, 1, 1, $g_lang['news_subject'], 1, 40, 'avworks');
		
		$this->controls[] = new avcText( &$this, 'info', $g_lang['news_info'], '', 1, 1, 1, $g_lang['news_info'], 1, 60);
		
		$this->controls[] = new avcImage( &$this, 'file', $g_lang['news_image'], '', 0, 1, 0, $g_lang['news_image'], 1, 'd:\localhost\avms\files', '../files/');

		$this->controls[] = new avcText( &$this, 'sort_number', $g_lang['menuitem_sort'], '1',  
                0, 1, 1, $g_lang['menuitem_sort'], 1 , 5); 
		
		$this->controls[] = new avcActions( &$this, 'actions', '', '', 0, 0, 1, 'Veiksmai', 0);


		$this->description = 'Darbø kategorijos';//$g_lang['news_description'];
		$this->default_order = 'sort_number';
	}
}


?>