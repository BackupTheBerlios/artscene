<? 
//js, 2001.09.11


//!! blocks
//! info blocks

/*

create table avblock
(
   id int(11) NOT NULL auto_increment,
   name varchar(100) NOT NULL,
   title varchar(200) NOT NULL,
   html text not null,
   template varchar(140) not null,
   visible tinyint not null,
   PRIMARY KEY (id)
);

*/

include_once($RELPATH . $COREPATH . 'avtable.class.php');
include_once($RELPATH . 'control/class/avcid.class.php');
include_once($RELPATH . 'control/class/avctext.class.php');
include_once($RELPATH . 'control/class/avctextarea.class.php');
include_once($RELPATH . 'control/class/avctextarea_html.class.php');
include_once($RELPATH . 'control/class/avcselect.class.php');
include_once($RELPATH . 'control/class/avcactions.class.php');

class avBlock extends avTable
{
	var $version = '$Id: avblock.class.php,v 1.3 2005/01/07 12:30:32 pukomuko Exp $';

	function avBlock()
	{
		$this->constructor();
	}

	function constructor()
	{
		global $g_lang, $g_ini,$HTTP_USER_AGENT;
		avTable::constructor();


		$this->name = 'avblock';

		$this->controls[] = & new avcId( &$this, 'id', '', '0', 0, 1, 1, '', 0);
		$this->controls[] = & new avcText( &$this, 'name', $g_lang['name'], '', 1, 1, 1, $g_lang['name'], 1, 40);
		$this->controls[] = & new avcText( &$this, 'title', $g_lang['blocks_title'], '', 1, 1, 1, $g_lang['blocks_title'], 1, 40);
		

		$this->controls[] = & new avcTextArea( &$this, 'html', $g_lang['blocks_html'], '', 1, 1, 0, $g_lang['blocks_html'], 1, 40, 25);	
		
		
		$this->controls[] = & new avcText( &$this, 'template', $g_lang['blocks_template'], 'block.html', 1, 1, 1, $g_lang['blocks_template'], 1, 40);
		
		$this->controls[] = & new avcSelect( &$this, 'visible', $g_lang['blocks_visible'], 1, 0, 1, 1, $g_lang['blocks_visible'], 1, array('0'=>$g_lang['no'], '1'=>$g_lang['yes']));

		$this->controls[] = & new avcActions( &$this, 'actions', '', '', 0, 0, 1, $g_lang['action'], 0);


		$this->description = $g_lang['blocks'];
		$this->default_order = 'id';
	}

	function show_action_list()
	{
		$out = avTable::show_action_list();
		return $out . '<input type="radio" name="action" value="change_visible"> '. $GLOBALS['g_lang']['action_make_selected_records'] . ' <select name="visibility"><option value="1">'. $GLOBALS['g_lang']['action_visible'] .'</option><option value="0" selected>'. $GLOBALS['g_lang']['action_invisible'] .'</option></select><br>';
	}

	function action_change_visible()
	{
		check_permission('avblock_edit');
		global $id, $g_db, $visibility;

		$g_db->query("UPDATE {$this->name} SET visible = $visibility WHERE id = " . implode(" OR id = ",$id));
	}

}


?>