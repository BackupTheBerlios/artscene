<? 
//js, 2001.11.20



/*!

CREATE TABLE avworks (
   id int(11) unsigned NOT NULL auto_increment,
   subject varchar(255) NOT NULL,
   info text NOT NULL,
   posted datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,

   thumbnail varchar(255) NOT NULL,
   file varchar(255) NOT NULL,

   submiter int(11) unsigned DEFAULT '0' NOT NULL,
   category_id int(11) unsigned DEFAULT '0' NOT NULL,
   
   views int(11) unsigned DEFAULT '0' NOT NULL,
   score int(11) unsigned DEFAULT '0' NOT NULL,

   color varchar(20) not null,
   PRIMARY KEY (id)
);

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

class avWorks extends avTable
{
	var $version = '$Id: avworks.class.php,v 1.4 2004/11/30 23:14:46 pukomuko Exp $';

	function avWorks()
	{
		$this->constructor();
	}

	function constructor()
	{
		global $g_lang, $g_ini, $pid, $page;
		avTable::constructor();


		$this->name = 'avworks';
		$this->pid = 'category_id';
		$this->parent = 'avworkcategory';



		$this->controls[] = & new avcId( &$this, 'id', '', '0', 0, 1, 1, '', 0);
		$this->controls[] = & new avcLinkText( &$this, 'subject', $g_lang['news_subject'], '', 1, 1, 1, $g_lang['news_subject'], 1, 50, 'avcomments');
		$this->controls[] = & new avcTextArea_bbcode( &$this, 'info', 'Apraðymas', '', 1, 1, 0, 'Apraðymas', 1, 50, 10);
		$this->controls[] = & new avcDate( &$this, 'posted', $g_lang['news_date'], date('Y.m.d'), 1, 1, 1, $g_lang['news_date'], 1);


		$this->controls[] = & new avcDbSelect( &$this, 'category_id', $g_lang['news_category'], '', 1, 1, 1, $g_lang['news_category'], 1, 'avworkcategory', 'id', 'name');
		$this->controls[] = & new avcDbText( &$this, 'submiter', $g_lang['news_author'], $GLOBALS['g_user_id'], 1, 1, 1, $g_lang['news_author'], 1, 'u_users', 'id', 'username');


		$this->controls[] = & new avcImage( &$this, 'thumbnail', 'Thumbnail', '', 0, 1, 0, $g_lang['news_image'], 1, $g_ini->read_var('avworks', 'thumbnails_dir'), $g_ini->read_var('avworks', 'thumbnails_url'), 110, 210);

		$this->controls[] = & new avcHidden( &$this, 'file', 'Failas', '', 0, 1, 0, 'Failas', 1);
		$this->controls[] = & new avcHidden( &$this, 'views', 'Perþiûros', 0, 0, 1, 1, 'Perþiûros', 1);
		$this->controls[] = & new avcHidden( &$this, 'score', 'Score', 0, 0, 1, 1, 'Score', 1);

		$this->controls[] = & new avcText( &$this, 'color', 'Spalva', '', 0, 1, 1, 'Spalva', 1, 60);

		$this->controls[] = & new avcActions( &$this, 'actions', '', '', 0, 0, 1, 'Veiksmai', 0);

		$this->description = 'Darbai';

		$this->default_order = 'posted desc, id desc';
	}



	function action_delete()
	{
		global $id, $table, $g_ini;

		if (!$id) {	return;	}

		
		if (is_array($id))
		{
			$list = $this->db->get_result("SELECT file, thumbnail FROM avworks w WHERE (id = " . implode(" OR id = ",$id) . ")", 1);

			print_r($list);
			for ($i = 0; isset($list[$i]); $i++)
			{
				unlink( $g_ini->read_var('avworks', 'works_dir') . $list[$i]['file']);
				if ('nothumbnail.gif' != $list[$i]['thumbnail'])
				{
					unlink( $g_ini->read_var('avworks', 'thumbnails_dir') . $list[$i]['thumbnail']);
				}

			}

			$this->db->query("DELETE FROM avcomments  WHERE table_name='$this->name' AND parent_id = " . implode(" OR parent_id = ",$id));
			$this->db->query("DELETE FROM avworkvotes  WHERE  work_id = " . implode(" OR work_id = ",$id));
			$this->db->query("DELETE FROM avworks_stat WHERE  work_id = " . implode(" OR work_id = ",$id));

		}

		avTable::action_delete();
	}

	function conditions()
	{
		global $badworks;

		if (!empty($badworks))
		{
			return ' score < 0 AND posted < DATE_SUB(NOW(), INTERVAL 7 DAY ) ';
		}
		else
		{
			return '';
		}
	}

}

?>