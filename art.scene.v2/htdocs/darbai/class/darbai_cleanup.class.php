<?
include_once($RELPATH . $COREPATH . 'avcolumn.class.php');

/**
* trinam darbus pro èia
*/

class darbai_cleanup extends avColumn
{
	var $version = '$Id: darbai_cleanup.class.php,v 1.13 2006/11/08 22:47:07 pukomuko Exp $';
	var $table = 'avworks';

	var $block_admin = 'work.deleted.admin';
	var $block_system = 'work.deleted.system';


	/**
	* kai useris kliktelna savo puslapyje
	*/
	function delete_image()
	{
		global $g_user_id, $HTTP_REFERER, $work, $g_usr, $g_ini;

		// paziurim ar darbas sito userio
		
		if (!isset($work))
		{
			echo 'fygne tu nepazymejei darbo';
			exit;
		}

		$work_info = $this->db->get_array("SELECT *, vote_count as vcount, vote_avg as avgmark, vote_sum as summark, submiter as user_id FROM avworks_stat w WHERE work_id = $work");
		
		if (empty($work_info)) redirect($HTTP_REFERER);

		if ( (in_array($g_usr->group_id, array(1, 4))) ||
			 ($work_info['submiter'] == $g_user_id) )
		{
			$send_comment = 0;
			if ($work_info['submiter'] != $g_user_id) $send_comment = 1;

			$this->delete_work($work, $work_info['file'], $work_info['thumbnail'], $send_comment, $work_info);

			// reikia pasiusti praneshima vartotojui, kad jo darbas buvo istrintas.

			$this->db->clear_cache_tables(array('avworkvotes', 'avworks', 'avcomments'));
		}
		
		
		$returnURI = $HTTP_REFERER;
		// jei trinant darbus nurodytas sekantis darbas, kuri reikia rodyti
		// po trynimo, ten ir keliaujam.
      	if (isset($GLOBALS['nextwork'])){
      		if ($GLOBALS['nextwork']=='noavail')
      			$returnURI = 'http://art.scene.lt/';
      		else
      			$returnURI = preg_replace('/work\.\d+/','work.'.$GLOBALS['nextwork'],$returnURI);
      	}

		redirect($returnURI);
	}



	/**
	* trina faila ir visus irasus db apie darba
	* TODO: uzloginti kas ir kada tryne
	* @param $send_comment 0 - nieko, 1 - tryne adminas, 2 - tryne sistema
	*/
	function delete_work($work, $image, $thumb, $send_comment, $work_info)
	{
		global $g_ini, $g_user_id;

		$block_name = '';
		switch ($send_comment) {
			case 1: $block_name = $this->block_admin; break;
			case 2: $block_name = $this->block_system; break;
		}

		if (!empty($block_name)) {

			$block = $this->db->get_array("SELECT * FROM avblock WHERE name='$block_name'");
      
			$this->tpl->set_var('comment', $block['html']);
			$this->tpl->set_var('work', $work_info);

			$comment = $this->tpl->process('', 'comment');
			$subject = $block['title'];
			$parent_id = $work_info['submiter'];

			$this->db->query("INSERT INTO avcomments (subject, info, posted, parent_id, table_name, user_id, new) 
				VALUES ('$subject', '$comment', NOW(), $parent_id, 'u_users',1, 1)");
				

		    // gales siusti darba tik sekancia diena 
			// taip pat, registruojam trynima prie userinfo
			$col_name = $send_comment==1?'del_works_admin':'del_works_system';
		    $this->db->query("UPDATE u_users SET $col_name=$col_name+1, may_send_work_after=DATE_ADD(NOW(),INTERVAL 1 DAY)  WHERE id=$parent_id");
		}

		$user_id =  isset($g_user_id) ?  $g_user_id : 1;
		
			unlink( $g_ini->read_var('avworks', 'works_dir') . $image);
			if ('nothumbnail.gif' != $thumb)
			{
					unlink( $g_ini->read_var('avworks', 'thumbnails_dir') . $thumb);
			}
			
			$this->db->query("DELETE FROM avworks  WHERE id = $work");
			$this->db->query("DELETE FROM avworks_stat  WHERE work_id = $work");

			$this->db->query("DELETE FROM avcomments  WHERE table_name='avworks' AND parent_id = $work");
			$this->db->query("DELETE FROM avworkvotes  WHERE  work_id = $work");
			
		$this->db->query("INSERT INTO avworks_delete_log (admin_id, posted, work_submiter, work_subject, work_posted, work_votecount, work_summark, work_avgmark, work_category) 
				VALUES ('$user_id', NOW(), '$work_info[user_id]', '$work_info[subject]', '$work_info[posted]', '$work_info[vcount]', '$work_info[summark]', '$work_info[avgmark]', '$work_info[category_id]')");
	}


	/**
	* cia tas gudrusis trynimo automatas
	* TODO: refactorinti metodà su trynimu, paduoti tik selectà ir apraðymà
	*/
	function daily_cleanup()
	{
		
		// per diena neishlipo ish minuso
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username, u.id AS submiter, thumbnail,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter AND
				DATE_SUB( NOW(), INTERVAL 1 DAY ) > w.posted
			GROUP BY w.id
			HAVING summark < 0
			");

		echo "<b>per dienà neiðlipo ið minuso</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";

		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail'], 2, $badworks[$i]);
		}

		// savaites nepakilo virs 1.5 vidurkis
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username, u.id AS submiter,  w.submiter AS user_id, category_id, thumbnail,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter AND
				DATE_SUB( NOW(), INTERVAL 7 DAY ) > w.posted
			GROUP BY w.id
			HAVING avgmark < 1.5
			");

		
		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail'], 2, $badworks[$i]);
		}

		echo "<b>per savaite < 1.5</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";

		// bet kokio senumo jei balsavo daugiau kaip 3 ir -æ visi 
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, w.submiter AS user_id, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username, u.id AS submiter, category_id, thumbnail,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter
			GROUP BY w.id
			HAVING avgmark < -3 AND vcount > 3
			");

	

		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail'], 2, $badworks[$i]);
		}

		echo "<b>maziau uz -3, balsavo bent 4</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";

	
		// fotografijos per savaite mazesnes uz 3 
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username, u.id AS submiter,  thumbnail, w.submiter AS user_id, category_id,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter AND w.category_id=5 AND
				DATE_SUB( NOW(), INTERVAL 7 DAY ) > w.posted
			GROUP BY w.id
			HAVING avgmark < 3
			");
	

		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail'], 2, $badworks[$i]);
		}

		echo "<b>per savaite fotografija mazesne uz 3 vidurkis</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";


		
		// per diena foto neperlipo per 2
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username, u.id AS submiter, w.submiter AS user_id, category_id, thumbnail,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter AND w.category_id=5 AND
				DATE_SUB( NOW(), INTERVAL 1 DAY ) > w.posted
			GROUP BY w.id
			HAVING avgmark < 2
			");

		echo "<b>per dienà neperlipo per 2 foto</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";

		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail'], 2, $badworks[$i]);
		}


		$this->db->clear_cache_tables(array('avworkvotes', 'avworks', 'avcomments'));

		die();


	}


}
