<?

include_once($RELPATH . $COREPATH . 'avcolumn.class.php');

class messages extends avColumn
{
	var $version = '$Id: messages.class.php,v 1.2 2004/09/23 21:42:19 pukomuko Exp $';

	var $table = 'blah';

	var $error = '';

	var $component = false;

	var $result = '';

	function messages($comp = false)
	{
		avColumn::constructor($comp);
	}

	function get_messages($user)
	{
		return $this->db->get_result("SELECT c.id, c.subject AS subject, u.username AS username, user_id, c.info AS info, DATE_FORMAT(posted, '%Y.%m.%d&nbsp;%H:%i') AS posted, c.new
			FROM avcomments c, u_users u
			WHERE c.parent_id='$user' AND c.user_id=u.id AND c.table_name='u_users'
			ORDER BY posted DESC, c.id DESC");
	}

	function update_messages($user)
	{
		$this->db->query("UPDATE avcomments SET new=0 WHERE parent_id='$user' AND table_name='u_users'");
	}

	
	function show_messages()
	{
		global $g_user_id;
		// rodom vyruko zinutes, jei jis turi id
		
		if ($g_user_id)
		{
			$list = $this->get_messages($g_user_id);
			$this->update_messages($g_user_id); // pazymim, kad jau perskaite
			
			for($i = 0; isset($list[$i]); $i++)
			{
				// ce jei nauja pazymim kazkaip :]
			}
			
			$this->tpl->set_loop('msg', $list);
			$this->tpl->set_file('temp', 'users/tpl/msg_list.html', 1);
			
			return $this->tpl->process('out', 'msg_list', 2);
		}
		else
		{
			$this->tpl->set_file('temp', 'users/tpl/msg_list.html', 1);
			return $this->tpl->process('out', 'nomsg');
		}
	}

	function event_delete_message()
	{
		global $g_user_id, $user, $message;

		if (!$g_user_id || !$message) return true;

		// tikrinam ar priklauso zinute sitam useriui

		$tmp = $this->db->query("SELECT id FROM avcomments WHERE id='$message' AND parent_id='$g_user_id' AND table_name='u_users'");

		if ($this->db->is_empty()) return true;
		
		$this->db->query("DELETE FROM avcomments WHERE id='$message' AND parent_id='$g_user_id' AND table_name='u_users'");

		return true;
	}

	function show_message_submit()
	{
		global $g_user_id, $user, $subject, $comment;

		isset($subject) || $subject ='noriu paklausti';
		isset($comment) || $comment ='';

		$this->tpl->set_file('temp', 'users/tpl/msg_list.html', 1);

		if ($g_user_id)
		{
			if ($g_user_id == $user)
			{
				//parasom kokios naujausios zinutes
				return $this->tpl->process('out', 'msg_info');
			}
			else
			{
				// ismetam submit box'a
				$this->tpl->set_var('comment', $comment);
				$this->tpl->set_var('subject', $subject);
				$this->tpl->set_var('error_str', $this->error);
				$this->tpl->set_var('url', $GLOBALS['REQUEST_URI']);
				return $this->tpl->process('out', 'send_msg');
			}
		}
		else
		{
			//pagaidinam kad registruotusi
			return $this->tpl->process('out', 'msg_register');
		}
	}
	
	function event_send_message()
	{

		global $url, $subject, $comment, $parent_id, $g_user_id, $g_usr, $g_tpl;


		if (empty($g_user_id))
		{
			$this->error .= 'reikia prisijungti prie sistemos<br>';
		}

		if ($this->error) return true;

		$comment = do_ubb($comment);
		$subject = htmlchars($subject);

		$this->db->query("INSERT INTO avcomments (subject, info, posted, parent_id, table_name, user_id, new) 
			VALUES ('$subject', '$comment', NOW(), $parent_id, 'u_users', $g_user_id, 1)");

		// siunciam meila autoriui

		$user_info = $this->db->get_array("SELECT * FROM u_user_info WHERE uid='$parent_id'");
		
		if ($user_info['mail_comments'])
		{
			$user = $this->db->get_array("SELECT * FROM u_users WHERE id='$parent_id'");

			$g_tpl->set_file('comment', 'users/tpl/mail_message.txt');
						
			$g_tpl->set_var('title', $subject);
			$g_tpl->set_var('username', $g_usr->username);
			$g_tpl->set_var('user_id', $g_user_id);
			$g_tpl->set_var('info', undo_ubb($comment));
			$g_tpl->set_var('date', date('Y.m.d'));

			mail($user['email'], "asmeninë þinutë nuo $g_usr->username", $g_tpl->process('','comment'), "MIME-Version: 1.0\nContent-Type: text/plain; charset=Windows-1257\nContent-Transfer-Encoding: 8bit\nFrom: art.scene automatas <artscene@fluxus.lt>\n", "-fart@scene.lt");


		}
		redirect($url);
	}

	function get_message_info($id)
	{
		return $this->db->get_array("SELECT c.id, c.subject AS subject, u.username AS username, c.parent_id, user_id, c.info AS info, DATE_FORMAT(posted, '%Y.%m.%d&nbsp;%H:%i') AS posted, c.new
			FROM avcomments c, u_users u
			WHERE c.id='$id' AND c.user_id=u.id AND c.table_name='u_users'");
	}

	function show_reply_message()
	{
		global $g_user_id, $message, $comment, $subject;

		if (!$g_user_id) return 'prisijunk';

		// tikrinam ar ciuvo
		$info = $this->get_message_info($message);

		if (!$info) return 'nër tokios þinutës';

		if ($g_user_id != $info['parent_id']) return 'þinutë ne tau';
		
		$this->tpl->set_file('temp', 'users/tpl/msg_list.html', 1);
		
			$comment = undo_ubb($info['info']);
			$lines = explode("\n", $comment);

			$comment = '';
			foreach ($lines as $line)
			{
				$comment .= "> ". $line ."\n";
			}

			$subject = "re: ". $info['subject'];

		
		$subject = htmlchars(stripslashes($subject));

		$this->tpl->set_var('msg', $info);
		$this->tpl->set_var('comment', $comment);
		$this->tpl->set_var('subject', $subject);

		$this->tpl->set_var('error_str', $this->error);
		$this->tpl->set_var('url', $GLOBALS['REQUEST_URI']);

		return $this->tpl->process('out', 'reply_msg');
		
	}

	function event_reply_message()
	{
		global $message, $url, $parent_id, $g_user_id;

		$info = $this->get_message_info($message);

		$GLOBALS['parent_id'] = $info['user_id'];
		$url = 'page.userinfo;menuname.usermessages;user.'.$g_user_id;

		return $this->event_send_message();
	}
}
?>