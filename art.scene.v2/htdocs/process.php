<?
/*
	Main file for userside

	Created: js, 2001.09.04
	__________________________________________________________
	$Id: process.php,v 1.3 2011/07/04 21:00:47 pukomuko Exp $
*/

/*!
	CHANGES
		2001.11.14, nk, js
		- bugfix, dabar tikrai pirma visi eventai tik po show daromas
		2001.10.12, js
		- tikrinam ar egzistuoja nurodytas puslapis.


	TODO: reikia padaryti kad nemestu klaidu nededant jokiu moduliu o tik template
	Dzhibas - 2001 09 17
*/


			// get hostname
			//if (isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR']) && '213.164.96.155' == $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR']) die('labs vakars tamsta. problemos? - <a href="mailto:art@scene.lt">art@scene.lt</a>');

				$proxy = $HTTP_SERVER_VARS['REMOTE_ADDR'];

//				if ($proxy == '213.197.141.238') die('sveikas vladai balsy! kiti rashykit.<a href="mailto:art@scene.lt">art@scene.lt</a>');


Header("Cache-control: private, no-cache");  
Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
Header("Pragma: no-cache");

function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
 } 

$pradedam = getmicrotime();

$RELPATH = './';

include_once($RELPATH . 'site.ini.php');
include_once($RELPATH . $LIBPATH . 'user_header.inc.php');

if (substr($_SERVER['REQUEST_URI'] , - strlen('/process.php')) == '/process.php') redirect ('process.php/');

//if ($_SERVER['HTTP_HOST'] != 'art.scene.lt') redirect('http://art.scene.lt/process.php/page.simple;menuname.address');

if ($_SERVER['REMOTE_ADDR'] == '78.62.16.145') die("This IP is temporary suspended. Please contact art@scene.lt");
//if ($_SERVER['REMOTE_ADDR'] == '217.28.248.89') die("This IP is temporary suspended. Please contact art@scene.lt");


if (isset($GLOBALS['bench'])) { echo "<br>checkpoint[headers]: " . round((getmicrotime() - $pradedam),2);}

if (empty($g_user_id) && isset($HTTP_COOKIE_VARS['fygne_vietoj_passwordo']))
{
	$rez = $g_usr->auto_login_user($HTTP_COOKIE_VARS['fygne_vietoj_passwordo']);
	if ($rez)
	{
		$g_sess->user_login($rez["id"]);
	}
}

$g_tpl->set_var('SCRIPT_NAME', $_SERVER['SCRIPT_NAME'] . '/');

isset($page) || $page = $g_ini->read_var('site', 'DefaultPage');

if (!$g_ini->group_exists($page)) { $page = $g_ini->read_var('site', 'DefaultPage'); }

$g_tpl->set_file( 'main', $RELPATH . $TPLPATH . $g_ini->read_var($page, 'template'), 1 );

$g_tpl->set_file( 'common_blocks', $RELPATH . $TPLPATH . 'common.html', 1 );

$g_tpl->set_var('page', $page);


$event_processed = false;

$columns = $g_ini->read_array($page, 'columns');
$index = 0;
$table = array();

	
foreach ($columns as $column)
{
	$blocks = $g_ini->read_array($page, $column);

	foreach ($blocks as $block)
	{
		// split module table method
		$names = explode('-', $block);
		include_once($RELPATH . $names[0] . '/class/' . $names[1] . '.class.php');

		if (empty($names[2])) { $names[2] = 'show_output'; }
		if (empty($names[3])) { $names[3] = ''; }

		$table[$index]['table'] = new $names[1]();
		$table[$index]['table_name'] = $names[1];
		$table[$index]['method'] = $names[2];
		$table[$index]['param'] = $names[3];
		$table[$index]['column'] = $column;
		
		if (isset($event) && !$event_processed ) { $event_processed = $table[$index]['table']->event_manager($event); }
		$index++;
	}
}	

if (isset($GLOBALS['bench'])) { echo "<br>checkpoint[iki_show_output]: " . round((getmicrotime() - $pradedam),2);}	

for ($index = 0; isset($table[$index]['table']); $index++)
{
	$ts = getmicrotime();
	$g_tpl->set_var($table[$index]['column'], $g_tpl->get_var_silent($table[$index]['column']) . $table[$index]['table']->$table[$index]['method']($table[$index]['param']) ); // :)
	if (isset($GLOBALS['bench'])) { 
		echo "<br>checkpoint[".$table[$index]['table_name']."-".$table[$index]['method']."]: " . 
			round((getmicrotime() - $ts),2);
	}	
}



if (isset($GLOBALS['bench'])) { echo "<br>puslapis generavosi: <b>".round((getmicrotime() - $pradedam),2)."</b> s";}	


if (isset($GLOBALS['bench'])) { echo count($GLOBALS); }

echo $g_tpl->process('out', 'main');

// register page counter /////
/*
	kodel gale? nesvarbu redirektai. nemaishys vartotojui
*/

if (!$g_sess->is_new()) exit;

flush();


/*
isset($HTTP_REFERER) || $HTTP_REFERER = '' ;

$localhost[] = 'http://'. $SERVER_NAME;
$localhost[] = 'http://art.scene.lt';
$localhost[] = 'http://artscene.fluxus.lt';


for ($i=0; isset($localhost[$i]); $i++)
{
	$pos = strpos($HTTP_REFERER, $localhost[$i]);
	if ( !(false === $pos) )
	{
		$HTTP_REFERER = substr($HTTP_REFERER, strlen($localhost[$i]), strlen($HTTP_REFERER));
	}
}

$g_db->query("INSERT DELAYED INTO u_usage
				(timehit, ip, user, agent, page, referrer) VALUES 
				(NOW(), '$REMOTE_ADDR', '". $g_sess->return_sessionID() ."', '$HTTP_USER_AGENT', '$REQUEST_URI', '$HTTP_REFERER')");

*/
?>