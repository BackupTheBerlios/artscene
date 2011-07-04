<? 
//js, 2001.11.09



/*!

CREATE TABLE avnews (
   id int(11) unsigned NOT NULL auto_increment,
   subject varchar(255) NOT NULL,
   info text NOT NULL,
   full_text text NOT NULL,
   posted datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   keywords varchar(255) NOT NULL,
   visible tinyint(4) unsigned DEFAULT '0' NOT NULL,
   category_id int(11) unsigned DEFAULT '0' NOT NULL,
   file varchar(255) NOT NULL,
   submiter int(11) unsigned DEFAULT '0' NOT NULL,
   authorizer int(11) unsigned DEFAULT '0' NOT NULL,
   auth_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   PRIMARY KEY (id)
);

*/

//!! news
//! sophisticated news


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
include_once($RELPATH . 'control/class/avcactions.class.php');
include_once($RELPATH . 'control/class/avcimage.class.php');
include_once($RELPATH . 'control/class/avchidden.class.php');

class avNews extends avTable
{

	function avNews()
	{
		$this->constructor();
	}

	function constructor()
	{
		global $g_lang, $g_ini, $pid, $page;
		avTable::constructor();


		$this->name = 'avnews';
		$this->pid = 'category_id';
		$this->parent = 'avnewscategory';



		$this->controls[] = new avcId( &$this, 'id', '', '0', 0, 1, 1, '', 0);
		$this->controls[] = new avcLinkText( &$this, 'subject', $g_lang['news_subject'], '', 1, 1, 1, $g_lang['news_subject'], 1, 50, 'avcomments');
		$this->controls[] = new avcTextArea( &$this, 'info', $g_lang['news_info'], '', 1, 1, 0, $g_lang['news_info'], 1, 50, 10);
		$this->controls[] = new avcTextArea_bbcode( &$this, 'full_text', $g_lang['news_full_text'], '', 0, 1, 0, '', 1, 40, 25);
		$this->controls[] = new avcDate( &$this, 'posted', $g_lang['news_date'], date('Y.m.d'), 1, 1, 1, $g_lang['news_date'], 1);

		$this->controls[] = new avcText( &$this, 'keywords', $g_lang['news_keywords'], '', 0, 0, 1, $g_lang['news_keywords'], 1, 40, 'avcomments');

		$this->controls[] = new avcDbSelect( &$this, 'category_id', $g_lang['news_category'], '', 1, 1, 1, $g_lang['news_category'], 1, 'avnewscategory', 'id', 'name');

		$this->controls[] = new avcDbSelect( &$this, 'submiter', $g_lang['news_author'], $GLOBALS['g_user_id'], 1, 1, 1, $g_lang['news_author'], 1, 'u_users', 'id', 'username');

//		$this->controls[] = new avcImage( &$this, 'file', $g_lang['news_image'], '', 0, 1, 0, $g_lang['news_image'], 1, $g_ini->read_var('avnews', 'image_dir'), $g_ini->read_var('avnews', 'image_url'), 110, 210);

		$this->controls[] = new avcText( &$this, 'file', 'Paveiksliukas', '', 0, 1, 1, 'Failas', 1, 40);

		
//		$this->controls[] = new avcHidden( &$this, 'visible', 'Patvirtinta', 0, 0, 1, 1, 'Patvirtinta', 1);


		if ('list' == $page) // is_permission('avnews_auth') ||
		{
			$this->controls[] = new avcDbSelect( &$this, 'authorizer', 'Tvirtintojas', $GLOBALS['g_user_id'], 1, 1, 1, 'Tvirtintojas', 1, 'u_users', 'id', 'username');
			$this->controls[] = new avcDate( &$this, 'auth_date', 'Tvirtinimo data', date('Y.m.d'), 1, 1, 1, 'Tvirt. data', 1);
			$this->controls[] = new avcSelect( &$this, 'visible', 'Patvirtinta', 1, 0, 1, 1, 'Patvirtinta', 1, array('0'=>'ne', '1'=>'taip'));
		}

		$this->controls[] = new avcActions( &$this, 'actions', '', '', 0, 0, 1, 'Veiksmai', 0);

		if (empty($pid))
		{
			$this->description = 'Nepatvirtintos naujienos';
		}
		else
		{
			$this->description = $g_lang['news_description'];
		}
		$this->default_order = 'posted desc, id desc';
	}


	function show_action_list()
	{
		$out = avTable::show_action_list();

		if (is_permission('avnews_auth'))
		{
			$out .= '<input type="radio" name="action" value="mail"> siøsti þmogënams paðtu<br>';
			$out .= '<input type="radio" name="action" value="change_visible"> '. $GLOBALS['g_lang']['action_make_selected_records'] . ' <select name="visibility"><option value="1" selected>patvirtintus</option><option value="0">nepatvirtintus</option></select><br>';
		}

		return $out;
	}

	function action_change_visible()
	{
		global $id, $g_db, $visibility, $g_user_id;

		check_permission('avnews_edit');

		$g_db->query("UPDATE {$this->name} 
			SET visible = $visibility, authorizer = $g_user_id, auth_date = NOW() 
			WHERE id = " . implode(" OR id = ",$id));
		
		$g_db->clear_cache_name('newslist');
	}

	function conditions()
	{
		global $pid;

		if (empty($pid)) { return ' visible = 0 '; }
	}


	function action_delete()
	{
		global $id, $table;

		avTable::action_delete();

		if (!$id) {	return;	}

		if (is_array($id))
		{
			$this->db->query("DELETE FROM avcomments  WHERE table_name='$this->name' AND ( parent_id = " . implode(" OR parent_id = ",$id) . " )");
		}
		else
		{
			$this->db->query("DELETE FROM avcomments WHERE table_name='$this->name' AND parent_id=$id");
		}
	}

	function action_mail()
	{
		global $id, $g_tpl, $g_usr;


		if (!$id) {	return;	}

		if (is_array($id))
		{
			$list = $this->db->get_result("SELECT id, subject, info, DATE_FORMAT(posted, '%Y.%m.%d') AS posted FROM $this->name WHERE id = " . implode(" OR id = ",$id));

			if (!empty($list))
			{
				for($i = 0; isset($list[$i]); $i++) { $list[$i]['info'] = undo_ubb($list[$i]['info']); }
				$g_tpl->set_file('naujienos', 'news/tpl/mail_naujienos.txt', 1);
				$g_tpl->set_loop('news_list', $list);
				$mail = $g_tpl->process('temp', 'naujienos', 2);
				
				$g_usr->mass_mail('art.scene naujienos', $mail, 'mail_news');
			}

		}

	}

}

?>