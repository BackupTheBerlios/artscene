<?
//js, 2004.08.05

//!! darbai
//! userside sarasai pirmame psulapyje

include_once($RELPATH . $COREPATH . 'avcolumn.class.php');
include_once($RELPATH . $COREPATH . 'avnavigator.class.php');

class darbai_submit extends avColumn
{
	var $version = '$Id: darbai_submit.class.php,v 1.17 2008/11/27 02:05:34 lthnnpwr Exp $';
	var $table = 'avworks';
	var $submit_info_block = 'work.submit.info';

	var $result = '';
	var $error = '';
	var $flash_category = 6; // dublicate
	var $thumb_x = 120;
	var $thumb_y = 90;

	function darbai_submit()
	{
		avColumn::constructor();
	}

	/**
	* dublikatas is darbai.class
	* submit selectui naudojamas.
	*/
	function get_simple_category_list()
	{
		return $this->db->get_result("SELECT *
				FROM avworkcategory
				ORDER BY sort_number");
	}


	/**
	* ar gali siøsti darbus?
	*/
	function check_cannot_post() {
		global  $g_user_id, $g_usr;

		$tmp = $this->db->get_array("SELECT COUNT(*) AS kiekis  FROM avworks WHERE submiter='$g_user_id' AND DATE_ADD(posted, INTERVAL 1 DAY) > NOW()");
		if ($tmp['kiekis'] > 2 ) return 'per ðias 24 valandas jau ádëjai tris darbus, lauk rytdienos.';

		// tiems kurie neturi devyniø darbø senesniø uþ savaitæ
		$tmp = $this->db->get_array("SELECT COUNT(*) AS kiekis  FROM avworks WHERE submiter='$g_user_id' AND DATE_SUB(NOW(), INTERVAL 7 DAY) > posted ");
		if ($tmp['kiekis'] < 9 ) {
			$tmp = $this->db->get_array("SELECT COUNT(*) AS kiekis  FROM avworks WHERE submiter='$g_user_id' AND  DATE_ADD(posted, INTERVAL 18 HOUR) > NOW()");
			if ($tmp['kiekis'] > 0 ) return 'per ðias 18 valandø jau ádëjai vienà darbà, lauk rytdienos.';
		}
		
		if (!$g_usr->can_i_send_work())
		{
		  return "darbus galësi siøsti tik nuo " . $g_usr->may_send_work_after;
    }
		return false;
	}

	function show_submit()
	{
		global $url, $subject, $info, $file, $category, $thumbnail, $color, $g_user_id;

		$this->tpl->set_file('temp', 'darbai/tpl/submit.html', 1);

		if (empty($g_user_id)) return $this->tpl->process('out', 'not_logged_in');


		$submit_block = $this->db->get_array("SELECT * FROM avblock WHERE name='$this->submit_info_block'");
		$this->tpl->set_var('submit_info', $submit_block['html']);


		if (!$this->result)
		{
			if ($error = $this->check_cannot_post()) return $error;

			$this->tpl->set_var('error', $this->error);

			isset($subject) || $subject = '';
			isset($info) || $info = '';
			isset($file) || $file = '';
			isset($category) || $category = '';
			isset($thumbnail) || $thumbnail = '';
			isset($color) || $color = '';

			$list = $this->get_simple_category_list();
			for ($i = 0; isset($list[$i]); $i++)
			{
				$list[$i]['selected'] = '';
				if ($list[$i]['id'] == $category) $list[$i]['selected'] = 'selected';
			}
			$this->tpl->set_var('subject', stripslashes(htmlchars($subject)));
			$this->tpl->set_var('info', stripslashes(htmlchars($info)));
			$this->tpl->set_var('color', stripslashes(htmlchars($color)));
			$this->tpl->set_loop('category', $list);
			//$this->tpl->set_var('fi', stripslashes(htmlchars($keywords)));
			
			//$this->tpl->set_var('submit_info', '');
			return $this->tpl->process('out', 'submit_form', 2);
		}
		else
		{
			return $this->tpl->process('out', 'thank_you');
		}

		return $this->tpl->process('out', 'submit_form', 1);
	}

	function event_work_submit()
	{
		global $url, $subject, $info, $work, $category, $thumbnail, $color, $g_user_id, $g_usr, $g_tpl;

		if (empty($subject))
		{
			$this->error = 'reikia pavadinimo<br>';
		}

		if (empty($category))
		{
			$this->error .= 'reikia kategorijos<br>';
		}

		if (empty($work) || 'none' == $work)
		{
			$this->error .= 'reikia atsiøsti darbà<br>';
		}

		if (!isset($g_user_id))
		{
			$this->error .= 'reikia prisijungti prie sistemos<br>';
		}

		if ($error = $this->check_cannot_post()) 
		{
			$this->error .= $error;
		}

		if ($this->error) return true;


		$work_name = $GLOBALS['work_name'];
		$work_size = $GLOBALS['work_size'];

		$work_types = array('gif', 'jpg', 'png', 'swf');
		$work_type = substr($work_name, strlen($work_name) - 3, 3);

		if (!in_array(strtolower($work_type), $work_types))
		{
			$this->error .= 'blogas darbo failas, gali bûti tik .jpg, .gif, .png, .swf<br>';
		}

		if ($thumbnail != '' && $thumbnail != 'none')
		{
			$thumb_name = $GLOBALS['thumbnail_name'];
			$thumb_size = $GLOBALS['thumbnail_size'];

			$thumb_types = array('gif', 'jpg', 'png');
			$thumb_type = substr($thumb_name, strlen($thumb_name) - 3, 3);

			if (!in_array(strtolower($thumb_type), $thumb_types))
			{
				$this->error .= 'blogas maþas paveiksliukas, gali bûti tik .jpg, .gif, .png<br>';
			}

		}


		if ($work_size < 10240)
		{
			$this->error .= 'per maþas darbo failas, limitas 10kb<br>';
		}

		if ( ($this->flash_category != $category) && ($work_size > 307200) )
		{
			$this->error .= 'per didelis darbo failas, limitas 300kb<br>';
		}

		if ($this->error) return true;

		// kopijuojam darba!
		$work_name = clean_name($work_name);
		$work_dest = $this->ini->read_var('avworks', 'works_dir') . $work_name;

		while (file_exists($work_dest)) 
		{ 
			$work_name = "_".$work_name;
			$work_dest = $this->ini->read_var('avworks', 'works_dir') . $work_name;
		}
		
		copy($work, $work_dest);
		unlink($work);

		// gaminam thumbnaila

		// jei ok dedam atsiusta thumbnail
		if ($thumbnail != 'none')
		{
			// vadinam taip pat kaip darba, kad nereiktu tikrinti dublikatu
			$thumb_dest = $this->ini->read_var('avworks', 'thumbnails_dir') . $work_name . '.jpg';
			$exec_src = $this->ini->read_var('avworks', 'convert_exec') ." -resize ". $this->thumb_x ."x". $this->thumb_y ." $thumbnail jpg:$thumb_dest";
			exec($exec_src);

			$thumbnail_name = $work_name . '.jpg';

			if (!file_exists($thumb_dest)) 
			{
				//galbut animuotas gifas? padarom pirma kadra
				if (file_exists($thumb_dest . '.0'))
				{
					$this->error = '';
					rename($thumb_dest . '.0', $thumb_dest);
				}
				else
				{
					$this->error .= 'nepavyko padaryti maþo paveiksliuko<br>';
				}
			}
			else
			{
				$this->error = '';
			}
		}
		
		// jei problemos, gaminam is atsiusto darbo
		if ( (($thumbnail == 'none') || $this->error) 
			&& ($category != $this->flash_category) )
		{
			// vadinam taip pat kaip darba, kad nereiktu tikrinti dublikatu
			$thumb_dest = $this->ini->read_var('avworks', 'thumbnails_dir') . $work_name . '.jpg';
			$exec_src = $this->ini->read_var('avworks', 'convert_exec') ." -resize ". $this->thumb_x ."x". $this->thumb_y ." $work_dest jpg:$thumb_dest";
			exec($exec_src);

			$thumbnail_name = $work_name . '.jpg';

			if (!file_exists($thumb_dest)) 
			{
				//galbut animuotas gifas? padarom pirma kadra
				if (file_exists($thumb_dest . '.0'))
				{
					$this->error = '';
					rename($thumb_dest . '.0', $thumb_dest);
				}
				else
				{
					$this->error .= 'nepavyko padaryti maþo paveiksliuko<br>';
				}

			} 
			else
			{
				$this->error = '';
			}
		}
		elseif ($this->error)
		{
			$this->error .= 'nepavyko padaryti maþo paveiksliuko<br>';
		}

		// jei problemos, dedam default
		if ($this->error || empty($thumbnail_name))
		{
			$thumbnail_name = 'nothumbnail.gif';
		}




		isset($color) || $color = '';
		isset($info) || $info = '';
		
		//wordwrap($comment, 30, " ", true) // senas variantas
		//smartWrap($text,30); // naujas variantas
		$info = smartWrap(do_ubb($info), 30);
		$subject = wordwrap(htmlchars($subject), 20, " ", true); // cia html'o nebus, todel standartinis wordwrap
		$color = clean_hex($color);

		$this->db->query("INSERT INTO avworks (subject, info, posted, thumbnail, file, submiter, category_id, color, file_size)
							VALUES ('$subject', '$info', NOW(), '$thumbnail_name', '$work_name', $g_user_id, $category, '$color', $work_size)");

		// TODO: update avworks_stat
		$last_id = $this->db->get_insert_id();
		$this->db->query("insert into avworks_stat 
  (work_id, subject, info, posted, thumbnail, file, submiter, category_id, 
  views, color, file_size, submiter_name, category_name) 
select w.id, w.subject, w.info, w.posted, w.thumbnail, w.file, w.submiter, w.category_id, 
  w.views, w.color, w.file_size, 
  u.username, c.name from avworks w, u_users u, avworkcategory c
where w.submiter = u.id AND c.id = w.category_id AND w.id=$last_id");

		$g_tpl->set_file('new_work', 'darbai/tpl/mail_new_work.txt');
		$g_tpl->set_var('id', $this->db->get_insert_id());
		$g_tpl->set_var('title', $subject);
		$g_tpl->set_var('username', $g_usr->username);
		$g_tpl->set_var('info', undo_ubb($info));
		$g_tpl->set_var('date', date('Y.m.d'));
		
		$this->db->clear_cache_tables('avworks');
		// $g_usr->mass_mail('art.scene naujas darbas', $g_tpl->process('temp', 'new_work'), 'mail_works');
		$this->result = true;

		return true;
	}



}

?>
