<? 
//js, 2001.08.17


/*!

CREATE TABLE avnewscategory (
   id int(11) unsigned NOT NULL auto_increment,
   name varchar(200) NOT NULL,
   info varchar(255) NOT NULL,
   file varchar(255) NOT NULL,
   sort_number tinyint(4) DEFAULT '1' NOT NULL,
   PRIMARY KEY (id)
);


*/

//!! news
//! flat news, minimum features


include_once($RELPATH . 'core/avtable.class.php');

include_once($RELPATH . 'control/class/avcid.class.php');
include_once($RELPATH . 'control/class/avctext.class.php');
include_once($RELPATH . 'control/class/avclinktext.class.php');
include_once($RELPATH . 'control/class/avcactions.class.php');
include_once($RELPATH . 'control/class/avcimage.class.php');

class avNewsCategory extends avTable
{

	function avNewsCategory()
	{
		$this->constructor();
	}

	function constructor()
	{
		global $g_lang;
		avTable::constructor();


		$this->name = 'avnewscategory';

		$this->controls[] = & new avcId( &$this, 'id', '', '0', 0, 1, 1, '', 0);
		
		$this->controls[] = & new avcLinkText( &$this, 'name', $g_lang['news_subject'], '', 1, 1, 1, $g_lang['news_subject'], 1, 40, 'avnews');
		
		$this->controls[] = & new avcText( &$this, 'info', $g_lang['news_info'], '', 1, 1, 1, $g_lang['news_info'], 1, 60);
		
		$this->controls[] = & new avcImage( &$this, 'file', $g_lang['news_image'], '', 0, 1, 0, $g_lang['news_image'], 1, 'd:\localhost\avms\files', '../files/');

		$this->controls[] = & new avcText( &$this, 'sort_number', $g_lang['menuitem_sort'], '1',  
                0, 1, 1, $g_lang['menuitem_sort'], 1 , 5); 
		
		$this->controls[] = & new avcActions( &$this, 'actions', '', '', 0, 0, 1, 'Veiksmai', 0);


		$this->description = 'Naujienø kategorijos';//$g_lang['news_description'];
		$this->default_order = 'sort_number';
	}
}


?>