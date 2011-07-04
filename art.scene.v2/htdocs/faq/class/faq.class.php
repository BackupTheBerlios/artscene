<?
/*
	faq component
	
	Created: js, 2001.10.18
	
	$Id: faq.class.php,v 1.3 2011/07/04 21:00:49 pukomuko Exp $
  ___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/


//!! faq
//! userside



include_once( $RELPATH . $COREPATH . 'avcolumn.class.php');

class faq extends avColumn
{

	var $db;
	var $tpl;
	var $table = 'avfaq';

	function faq()
	{

		avColumn::constructor();

	}

	/*!
		\return array with all visible news	
	*/
	function get_list()
	{
		return $this->db->get_result("SELECT *, DATE_FORMAT(posted, '%Y.%m.%d') as posted FROM $this->table WHERE visible !=0 ORDER BY posted DESC");
	}

	/*!
		\return news item $id	
	*/
	function get_info($id)
	{
		return $this->db->get_array("SELECT * FROM $this->table WHERE id=$id");
	}

	/*!
		\return string with 	
	*/
	function show_output($input)
	{
		global $question;

		$list = $this->get_list();
		
		$this->tpl->set_loop('list_index', $list);
		$this->tpl->set_loop('list', $list);
		
		$this->tpl->set_var('url', $_SERVER['REQUEST_URI']);
		$this->tpl->set_var('menuitem', $GLOBALS['menuitem']);
		$this->tpl->set_file('faq', 'faq/tpl/faq_list.html', 1);

		if (empty($question))
		{
			$this->tpl->process('faq_footer', 'faq_form');
		}
		else
		{
			$this->tpl->process('faq_footer', 'faq_thanks');
		}
		return $this->tpl->process('out', 'faq', 2);
		
	}

	/*!
		naujo klausimo uzdavimas	
	*/
	function event_faq_new()
	{
		global $question, $name, $email;

		if (!empty($question))
		{
			empty($name) && $name = '';
			empty($email) && $email = '';

			$this->db->query("INSERT INTO $this->table (question, name, email, posted, visible) VALUES ('$question', '$name', '$email', NOW(), 0)");

			$this->tpl->set_file('mail', 'faq/tpl/mail_new_faq.txt');
			$this->tpl->set_var('name', $name);
			$this->tpl->set_var('email', $email);
			$this->tpl->set_var('question', $question);

      mail("artscene-admin-talk@googlegroups.com", 'naujas klausimas svetainëje', $this->tpl->process('temp', 'mail'), "MIME-Version: 1.0\nContent-Type: text/plain; charset=Windows-1257\nContent-Transfer-Encoding: 8bit\nFrom: art.scene automatas <pukomuko@gmail.com>\n");
		}

		return true;
	}
}


?>
