<?
/*
	faq admin
	
	Created: dzhibas, 2001.08.29
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/

/*

CREATE TABLE faq (
   id tinyint(4) NOT NULL auto_increment,
   question varchar(255) NOT NULL,
   answer text NOT NULL,
   lang_id tinyint(4) DEFAULT '0' NOT NULL,
   posted date DEFAULT '0000-00-00' NOT NULL,
   visible tinyint(4) DEFAULT '0' NOT NULL,
   name, email
   PRIMARY KEY (id)
);
		
*/
include_once($RELPATH . $COREPATH . 'avtable.class.php');

include_once($RELPATH . 'control/class/avcid.class.php');
include_once($RELPATH . 'control/class/avctext.class.php');
include_once($RELPATH . 'control/class/avctextarea.class.php');
include_once($RELPATH . 'control/class/avctextarea_bbcode.class.php');
include_once($RELPATH . 'control/class/avcdate.class.php');
include_once($RELPATH . 'control/class/avcselect.class.php');
include_once($RELPATH . 'control/class/avcdbselect.class.php');
include_once($RELPATH . 'control/class/avcactions.class.php');

class avFaq extends avTable
{

	function avFaq()
	{
		$this->constructor();
	}

	function constructor()
	{
		GLOBAL $g_lang;
		avTable::constructor();


		$this->name = 'avfaq';
		
		$this->pid = 'lang_id';
		$this->parent = 'page_language';
		$this->parent_module = 'control';

		$this->controls[] = & new avcId( &$this, 'id', '', '0', 0, 1, 1, '', 0);
		$this->controls[] = & new avcTextArea( &$this, 'question', $g_lang['faq_question'], '', 1, 1, 1, $g_lang['faq_question'], 0, 40, 5);
		$this->controls[] = & new avcTextArea_bbcode( &$this, 'answer', $g_lang['faq_answer'], '', 0, 1, 1, $g_lang['faq_answer'], 0, 40, 10);
		$this->controls[] = & new avcDate( &$this, 'posted', $g_lang['date'], date('Y.m.d'), 1, 1, 1, $g_lang['date'], 1);

		$this->controls[] = & new avcText( &$this, 'name', $g_lang['faq_name'], '', 0, 1, 1, $g_lang['faq_name'], 1, 40);
		$this->controls[] = & new avcText( &$this, 'email', $g_lang['faq_email'], '', 0, 1, 0, '', 1, 40);

//		$this->controls[] = & new avcDbSelect( &$this, 'lang_id', 'lang', '', 1, 1, 1, 'Kalba', 1, 'languages', 'id', 'lang_name');

		$this->controls[] = & new avcSelect( &$this, 'visible', $g_lang['faq_visible'], 0, 0, 1, 1, $g_lang['faq_visible'], 1, array('0'=>$g_lang['no'], '1'=>$g_lang['yes']));
		$this->controls[] = & new avcActions( &$this, 'actions', '', '', 0, 0, 1, $g_lang['action'], 0);


		$this->description = $g_lang['faq_description'];
		$this->default_order = 'posted desc, id desc';
	}

	function show_action_list()
	{
		$out = avTable::show_action_list();
		return $out . '<input type="radio" name="action" value="change_visible"> '. $GLOBALS['g_lang']['action_make_selected_records'] . ' <select name="visibility"><option value="1">'. $GLOBALS['g_lang']['action_visible'] .'</option><option value="0" selected>'. $GLOBALS['g_lang']['action_invisible'] .'</option></select><br>';
	}

	function action_change_visible()
	{
		check_permission('avfaq_edit');
		global $id, $g_db, $visibility;

		$g_db->query("UPDATE {$this->name} SET visible = $visibility WHERE id = " . implode(" OR id = ",$id));
	}

}


?>