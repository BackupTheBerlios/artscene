<?
include_once($RELPATH . $COREPATH . 'avcolumn.class.php');

/**
* trinam darbus pro èia
*/

class darbai_cleanup extends avColumn
{
	var $version = '$Id: darbai_cleanup.class.php,v 1.1 2004/09/26 20:56:23 pukomuko Exp $';
	var $table = 'avworks';


	/**
	* kai useris kliktelna savo puslapyje
	*/
	function event_delete_image()
	{
		global $g_user_id, $REQUEST_URI, $work, $g_usr, $g_ini;

		// paziurim ar darbas sito userio
		
		if (!isset($work))
		{
			echo 'fygne tu nepazymejei darbo';
			exit;
		}
		$info = $this->get_info($work);

		if ( (in_array($g_usr->group_id, array(1, 4))) ||
			 ($info['user_id'] == $g_user_id) )
		{
			$work_info = $this->db->get_array("SELECT file, thumbnail FROM avworks w WHERE id = $work");
			$this->delete_work($work, $work_info['file'], $work_info['thumbnail']);

			$this->db->clear_cache_tables(array('avworkvotes', 'avworks', 'avcomments'));
			
			$url = substr($REQUEST_URI, 0, strpos($REQUEST_URI, 'event.'));

			redirect($url);

		}
	}



	/**
	* trina faila ir visus irasus db apie darba
	* TODO: uzloginti kas ir kada tryne
	*/
	function delete_work($work, $image, $thumb)
	{
		global $g_ini;

			unlink( $g_ini->read_var('avworks', 'works_dir') . $image);
			if ('nothumbnail.gif' != $thumb)
			{
					unlink( $g_ini->read_var('avworks', 'thumbnails_dir') . $thumb);
			}
			
			$this->db->query("DELETE FROM avworks  WHERE id = $work");

			$this->db->query("DELETE FROM avcomments  WHERE table_name='avworks' AND parent_id = $work");
			$this->db->query("DELETE FROM avworkvotes  WHERE  work_id = $work");
	}


	/**
	* cia tas gudrusis trynimo automatas
	* TODO: refactorinti metodà su trynimu, paduoti tik selectà ir apraðymà
	*/
	function daily_cleanup()
	{
		
		// per diena neishlipo ish minuso
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username, thumbnail,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter AND
				DATE_ADD(w.posted, INTERVAL 1 DAY) < NOW()
			GROUP BY w.id
			HAVING summark < 0
			");

		echo "<b>per dienà neiðlipo ið minuso</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";

		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail']);
		}

		// savaites nepakilo virs 1.5 vidurkis
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username,  thumbnail,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter AND
				DATE_ADD(w.posted, INTERVAL 7 DAY) < NOW()
			GROUP BY w.id
			HAVING avgmark < 1.5
			");

		
		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail']);
		}

		echo "<b>per savaite < 1.5</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";

		// bet kokio senumo jei balsavo daugiau kaip 3 ir -æ visi 
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, w.submiter AS user_id, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username, category_id, thumbnail,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter
			GROUP BY w.id
			HAVING avgmark < -3 AND vcount > 3
			");

	

		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail']);
		}

		echo "<b>maziau uz -3, balsavo bent 4</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";

	
		// fotografijos per savaite mazesnes uz 3 
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username,  thumbnail,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter AND w.category_id=5 AND
				DATE_ADD(w.posted, INTERVAL 7 DAY) < NOW()
			GROUP BY w.id
			HAVING avgmark < 3
			");
	

		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail']);
		}

		echo "<b>per savaite fotografija mazesne uz 3 vidurkis</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";


		
		// per diena foto neperlipo per 2
		$badworks = $this->db->get_result("SELECT COUNT(v.id) AS vcount, SUM(v.mark) AS summark, AVG(v.mark) AS avgmark,
			w.id AS id, subject, DATE_FORMAT(w.posted, '%Y.%m.%d') AS posted,  u.username AS username, thumbnail,  w.file as file
			FROM avworkvotes v, avworks w, u_users u
			WHERE v.work_id=w.id AND u.id=w.submiter AND w.category_id=5 AND
				DATE_ADD(w.posted, INTERVAL 1 DAY) < NOW()
			GROUP BY w.id
			HAVING avgmark < 2
			");

		echo "<b>per dienà neperlipo per 2 foto</b>
			<PRE>";
		print_r($badworks);
		echo "</PRE>";

		for($i = 0; isset($badworks[$i]); $i++)
		{
			$this->delete_work($badworks[$i]['id'], $badworks[$i]['file'], $badworks[$i]['thumbnail']);
		}


		$this->db->clear_cache_tables(array('avworkvotes', 'avworks', 'avcomments'));

		die();


	}


}