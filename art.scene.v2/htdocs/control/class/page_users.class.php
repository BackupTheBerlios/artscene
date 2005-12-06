<? 
//js, 2001.08.17
// $Id: page_users.class.php,v 1.4 2005/12/06 08:29:07 pukomuko Exp $

//!! admin
//! vartotojai


include_once($RELPATH . 'core/avtable.class.php');

include_once($RELPATH . 'control/class/avcid.class.php');
include_once($RELPATH . 'control/class/avctext.class.php');
include_once($RELPATH . 'control/class/avcpassword.class.php');
include_once($RELPATH . 'control/class/avcdbselect.class.php');
include_once($RELPATH . 'control/class/avcselect.class.php');
include_once($RELPATH . 'control/class/avctimestamp.class.php');
include_once($RELPATH . 'control/class/avcactions.class.php');
include_once($RELPATH . 'control/class/avchidden.class.php');
include_once($RELPATH . 'control/class/avcdate.class.php');
include_once($RELPATH . 'control/class/avcdateplus.class.php');


class page_users extends avTable
{

	function page_users()
	{
		$this->constructor();
	}

	function constructor()
	{
		global $g_lang;
		avTable::constructor();


		$this->name = 'u_users';
		$this->pid = 'group_id';
		$this->parent = 'page_groups';

		$this->controls[] = & new avcId( &$this, 'id', '', '0', 0, 1, 1, '', 0);
		$this->controls[] = & new avcText( &$this, 'username', $g_lang['users_username'], '', 1, 1, 1, $g_lang['login.username'], 1, 20);
		$this->controls[] = & new avcPassword( &$this, 'password', $g_lang['users_password'], '', 1, 1, 0, $g_lang['users_password'],1, 15, 5);
		$this->controls[] = & new avcDbSelect( &$this, 'group_id', $g_lang['users_group'], '', 1, 1, 1, $g_lang['users_group'], 1, 'u_group', 'id', 'name', '');
		$this->controls[] = & new avcSelect( &$this, 'active', $g_lang['users_active'], '1', 0, 1, 1, $g_lang['users_active'], 1, array('0'=>'ne', '1'=>'taip'));
		$this->controls[] = & new avcText( &$this, 'email', $g_lang['users_email'], '', 0, 1, 1, $g_lang['users_email'], 1, 20);
		$this->controls[] = & new avcTimeStamp( &$this, 'lastlogin', $g_lang['users_lastlogin'], '', 0, 1, 1, $g_lang['users_lastlogin'], 1);
		$this->controls[] = & new avcHidden( &$this, 'lasthost', $g_lang['users_lasthost'], '', 0, 1, 1, $g_lang['users_lasthost'], 1);
		$this->controls[] = & new avcActions( &$this, '', '', '', 0, 0, 1, $g_lang['list_rowactions'], 0);

    $this->controls[] = & new avcDatePlus( &$this, 'may_send_work_after', 'Darbai nuo', date('Y.m.d'), 1, 1, 0, 'temp', 1);
    $this->controls[] = & new avcDatePlus( &$this, 'may_comment_after', 'Komentarai nuo', date('Y.m.d'), 1, 1, 0, 'temp', 1);
    
		$this->description = $g_lang['users_description'];
	}


	function action_delete()
	{
		global $id, $table;

		avTable::action_delete();

		if (!$id) {	return;	}

		if (is_array($id))
		{
			$this->db->query("DELETE FROM u_user_info  WHERE uid = " . implode(" OR uid = ",$id));
			$this->db->query("DELETE FROM avworks  WHERE submiter  = " . implode(" OR submiter  = ",$id));
			$this->db->query("DELETE FROM avworks_stat  WHERE submiter  = " . implode(" OR submiter  = ",$id));
			$this->db->query("DELETE FROM avcomments  WHERE user_id  = " . implode(" OR user_id  = ",$id));
			$this->db->query("DELETE FROM avworkvotes  WHERE user_id  = " . implode(" OR user_id  = ",$id));
			$this->db->query("DELETE FROM forum_thread_list WHERE author_id  = " . implode(" OR author_id  = ",$id));
			$this->db->query("DELETE FROM forum_post_list WHERE author_id  = " . implode(" OR author_id  = ",$id));

		}
		else
		{
			$this->db->query("DELETE FROM u_user_info WHERE uid=$id");
		}
	}

}


?>
