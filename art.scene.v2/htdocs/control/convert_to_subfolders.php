<pre>
<?php

/**
 * vienkartinis skriptukas darbø failus praskirstyti po subfolderius "metai-menuo"
 * 
 * veikimo budas paprastas - einam per visus avworks failus, ziurim, kurio failas dar
 * ne subfolderyje, rade toki, kopinam jo failus i subfolderi, modifikuojam db, ir
 * galiausiai, jei praejo be erroru, trinam sena faila.
 * 
 * kadangi skripto subuginimo atveju sugriutu visa scena:], tai gal vertetu 
 * pasidaryti kazkokia strachovke, kontrolini DB/failu dumpa ar pan. lyg ir suziurejau,
 * kad viskas butu tvarkoj, bet niekada negali zinoti. 
 * 
 * 
 * konfiguracija reikes pasikopijuoti ish global.ini
 * kol baisu, kad kas nors sugrius, nusirodyti TEST_MODE=false 
 * 
 */

// dirbsim atsargiai
error_reporting(E_ALL);

// dirbsim ilgai
set_time_limit(0);

// setupas. sorry, neintegruota su global.ini
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','vienuolika$');
define('DB_DB','artscene_v2');


// darbu failu folderiai, kur darbai padeti dabar
// nepamirsti trailing backslasho. negali buti tas pats diras
define('DIR_IMG','c:/doc/programinimas/artscene.v2/htdocs/files/');
define('DIR_THUMBS','c:/doc/programinimas/artscene.v2/htdocs/files/thumbs/');


// flagas pasibandymui. jei true, tik sukuria subdirus, perkopijuoja darbu failus,
// nemodifikuoja DB ir netrina failu ish rootinio folderio (palieka viska veikti po senovei)
define('TEST_MODE',false);


define('DEFAULT_THUMB','nothumbnail.gif'); // toki thumba scena irashydavo, kai darbas jo neturedavo


// funkcijos loginimui
function msg($message){
	echo $message.'<br />';
	flush();
}

function error($message){
	echo '<span style="color:red">'.$message.'</span><br />';
	flush();
}

function fatal($error){
	error($error);
	die();
}


function errorHandler($errno, $errstr, $errfile, $errline){
	error("$errstr ($errfile, $errline)");
} 
set_error_handler('errorHandler');




// jungiam duombaze
$db = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or fatal('neprisijungiu prie db serverio');
mysql_select_db('artscene_v2') or fatal('nëra tokios duombazës');

msg('prisijungta prie '.DB_HOST.'/'.DB_DB);





// passiskaiciuojam, kiek turim darbu (progreso rodymui)
$q = mysql_query('select count(*) from avworks order by posted');
$numWorks = mysql_fetch_array($q);
$numWorks = $numWorks[0];





// na, ir pavarom per visus
$q = mysql_query('select id, subject, posted, thumbnail, file from avworks order by posted');
$curr = 0;
while ($work = mysql_fetch_object($q)){
	$curr++;
	msg("$curr/$numWorks: $work->subject ");
	
	convertWork($work);
	$mysqlerr = mysql_error();
	if ($mysqlerr)
		error($mysqlerr);
}
	
	

// apdirba viena darba
function convertWork($work){
	// primityviai patikrinam, ar jau prikabintas datos folderis
	if (strlen($work->file)>7 && $work->file{7}=='/'){
		msg('jau konvertuotas');
		return true;
	}
	
	
	// pasiruoshiam dirus, jei nesukurti
	$subdir = substr($work->posted,0,7).'/';
	if (!is_dir(DIR_IMG.$subdir) && !mkdir(DIR_IMG.$subdir)){
		error('nesukuriu imagu subdiro '.$subdir);
		return false;
	}
	if (!is_dir(DIR_THUMBS.$subdir) && !mkdir(DIR_THUMBS.$subdir)){
		error('nesukuriu thumbnailu subdiro '.$subdir);
		return false;
	}
	
	// kopinam failus (nemovinam). jei failo nera, ignoruojam ta fakta, duombazeje kelia vistiek pakeiciam.
	if (file_exists(DIR_IMG.$work->file) && !copy(DIR_IMG.$work->file,DIR_IMG.$subdir.$work->file)){
		error('nesikopijuoja '.$work->file);
		return false;
	}
	
	if ($work->thumbnail!=DEFAULT_THUMB && file_exists(DIR_THUMBS.$work->thumbnail) && !copy(DIR_THUMBS.$work->thumbnail,DIR_THUMBS.$subdir.$work->thumbnail)){
		error('nesikopijuoja'.$work->thumbnail);
		return false;
	}
	
	if (TEST_MODE)
		return true; // testinis rezimas, darbas tam kartui baigtas
	
	
	// rashom duombaze
	
	// thumbnaila keiciam, jei jis nera defaultinis nothumbnail.gif
	$newThumbSQL ='';
	if ($work->thumbnail!=DEFAULT_THUMB)
		$newThumbSQL = ", thumbnail='$subdir$work->thumbnail' ";  
	
	if (!mysql_query("update avworks set file='$subdir$work->file' $newThumbSQL where id=$work->id"))
		return false;
		
	if (!mysql_query("update avworks_stat set file='$subdir$work->file' $newThumbSQL where work_id=$work->id"))
		return false;


	// viskas pavyko, galima trinti senus failus
	if (is_file(DIR_IMG.$work->file))	
		unlink(DIR_IMG.$work->file);
	if ($work->thumbnail!=DEFAULT_THUMB && is_file(DIR_IMG.$work->thumbnail))	
		unlink(DIR_IMG.$work->thumbnail);
	
	
	return true;
}



?>
</pre>