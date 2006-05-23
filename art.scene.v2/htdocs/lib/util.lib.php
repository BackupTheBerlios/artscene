<? 
/*
 $Id: util.lib.php,v 1.8 2006/05/23 13:08:39 pukomuko Exp $
 */

// dzhibas, 2001.07.23
// + added function nl2br() and active_url();
//
// js, 2001.07.09


// Funkcija /n i <br>
function nl2p($text){
	$text = nl2br($text);
	$text = str_replace('<br>','<p>',$text);
	return $text;
}

// Texte randa linkus ir padaro juos aktyviais
function active_url($text,$class=""){
	$c=(strlen($class)) ? " class=\"$class\" ":"";
	$text = &eregi_replace(
		"([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])",
		"<a href=\"\\1://\\2\\3\" $class target=\"_blank\">\\1://\\2\\3</a>", $text);
		$text =&eregi_replace(
		"(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))",
		"<a href=\"mailto:\\1\"  $class target=\"_blank\">\\1</a>", $text);
		return $text;
}


/*!
	prints out redirection page
	header, javascript, link
*/
function redirect($page)
{
	header("Location: $page");
	
	?> 
	<html><head><title>redirect</title>
	<meta http-equiv="Refresh" content="0; URL=<? echo $page ?>">
	</head>

	<body>
	<script language="JavaScript">
	<!--
	window.location = '<? echo $page ?>';
	//-->
	</script>
	<a href="<? echo $page ?>"><b>spauskit èia / enter here</b></a>
	
	</body>
	</html>
	<?
	exit;
}


// js, 2001.07.10
function htmlchars($s)
{
	$s = ereg_replace("'","&#039;", htmlspecialchars($s));
	return $s;
}

// js, 2001.11.06
function clean_username($name)
{
	return ereg_replace("[^0-9a-zA-Z_]","",$name);
}


// js, 2001.07.10
function clean_name($name)
{
	return ereg_replace("[^0-9a-zA-Z_.]","",$name);
}

// js, 2001.11.22
function clean_number($name)
{
	return ereg_replace("[^0-9]","",$name);
}

// js, 2001.11.22
function clean_hex($name)
{
	return ereg_replace("[^0-9a-fA-F]","",$name);
}

// js, 2001.11.07
// from mlemos class
function valid_email($email)
{
	$email_regular_expression = "^([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~ ])+@([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~ ]+\\.)+[a-zA-Z]{2,4}\$";
	return (eregi($email_regular_expression, $email) != 0);
}

/*!
	js, 2001.07.17
	builds date selects (year, month, day)
	\param $name - selects name
	\param $date - default selected, formats: year-month-day, year.month.day
*/
function html_build_date($name, $date = false)
{
	$tmp = split('[-. ]', $date);

	for ($i = 0; $i < 3; $i++)
	{
		if (empty($tmp[$i])) { $tmp[$i] = ''; }
	}

	$out = "<select name='". $name ."_year' class='inputyear'>";
	for ($i = 0; $i < 10; $i++)
	{
		$year = 2000 + $i;
		if ($year == $tmp[0]) { $t = 'selected'; } else { $t = ''; }
		$out .= "<option value='$year' $t>$year</option>";
	}
	$out .= "</select> / ";

	$out .= "<select name='". $name ."_month' class='inputtwo'>";
	for ($i = 1; $i < 13; $i++)
	{	
		if ($i == $tmp[1]) { $t = 'selected'; } else { $t = ''; }
		$out .= "<option value='$i' $t>$i</option>";
	}
	$out .= "</select> / ";

	$out .= "<select name='". $name ."_day' class='inputtwo'>";
	for ($i = 1; $i < 32; $i++)
	{
		if ($i == $tmp[2]) { $t = 'selected'; } else { $t = ''; }
		$out .= "<option value='$i' $t>$i</option>";
	}
	$out .= "</select>";

	return $out;
}

function html_build_select($name, &$array, $value, $text, $sel = false, $class = false)
{
	if ($class)
	{
		$class = "class='$class'";
	}

	$res = "<select name='$name' $class>";

	for( $i = 0; isset($array[$i]); $i++ )
	{
		if ($array[$i][$value] == $sel)
		{
			$t = 'selected';
		}
		else
		{
			$t = '';
		}

		$res .= "<option value='". $array[$i][$value] ."' $t>". $array[$i][$text] ."</option>";
	}
	
	$res .= '</select>';
	return $res;
}

// js, 2001.07.17
function didziosios( $str )
{
	$str = strtoupper($str);

	$search = array ("'à'","'è'","'æ'","'ë'","'á'","'ð'","'ø'","'û'","'þ'");
	$replace = array ('À','È','Æ','Ë','Á','Ð','Ø','Û','Þ');

	return preg_replace($search, $replace, $str);
}

function unhtml($str)
{
	$str = strip_tags($str);
	$search = array (
				 "'&#039;'i",
                 "'&(quot|#34);'i",  // Replace html entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");  // evaluate as php

	$replace = array (
					"'",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");

	$str = preg_replace ($search, $replace, $str);
	
	return $str;
}



/*!
	return url pointing to self
	\param $skip - items to skip
	\param $overwrite - items to overwrite
*/
function self_url( $skip = array(), $overwrite = array())
{
	global $PHP_SELF, $module, $table, $offset, $order, $search, $pid, $page;

	$params['module'] = $module;
	$params['table'] = $table;
	$params['offset'] = $offset;
	$params['order'] = $order;
	$params['search'] = $search;
	$params['pid'] = $pid;
	$params['page'] = $page;

	if (is_array($overwrite))
	{
		while(list($k, $v) = each($overwrite)) { $params[$k] = $v; }
	}

	if (is_array($overwrite))
	{
		while(list($k, $v) = each($skip)) { unset($params[$v]); }
	}

	$url = '';

	while(list($k, $v) = each($params)) 
	{ 
		$url .= $k . '=' . $v . '&';
	}
	

	return $PHP_SELF . '?' . $url;

}


/*!
	tikrina permision'a	
	on no permission redierct
*/
function check_permission($pm_name)
{
	global $g_theme_dir, $RELPATH;
	
	if (!is_permission($pm_name)) 
	{
		redirect($RELPATH . 'control/tpl/' . $g_theme_dir . 'error.html');
	}
		
	return true;
}


/*!
	is permission set? true : false
*/
function is_permission($pm_name)
{
//	return true;
	GLOBAL $g_usr, $g_db;

	$g_user_groupID = $g_usr->group_id;
	
	$result = $g_db->query("SELECT pl.id, pm.id, pm.name 
				FROM u_permission_link AS pl, u_permission AS pm 
				WHERE pl.group_id=$g_user_groupID AND pm.name='$pm_name' AND pl.permission_id=pm.id");
	
	if ($g_db->is_empty()) 
	{
		return false;
	}
		
	return true;
}



/*!
	Dzhibas:
	
	Funkcija decodina shtai tokia URL forma:
	index/page.reiksme;SID.sidreiksme;irtt
	
	funkcija gali grazhinti globalu masyva su kintamaisiais ir ju reikshmemis 
	arba
	padaryti visuos URL kitnamuosius globaliais
	
	$whattodo == "array" || == "global"

	js, 2001.09.04
	sumazinau ifo sluoksniu :]
	ir get_query paimau universalu
	uzglobalina tik tuos kintamuosius kurie dar neapibrezti
*/

function decode_url( $whattodo = "global" ) 
{
	
	//$url = substr(strrchr($GLOBALS['REQUEST_URI'],'/'),1);
	
	$url = get_query();
	$url = explode(";",$url);

		
	if (isset($url)) 
	{
		for ($x=0;$x < sizeof($url);$x++) 
		{
				$vars = explode(".",$url[$x]);
			if (isset($vars)&&sizeof($vars)==2) 
			{
				if ('array' == $whattodo)
				{
					$gb_urlvars[$vars[0]] = $vars[1];
				}
				else
				{
					isset($GLOBALS[$vars[0]])?true:$GLOBALS[$vars[0]] = $vars[1];
				}
			}
			}
		}
		isset($gb_urlvars)?$GLOBALS["gb_urlvars"] = $gb_urlvars:$GLOBALS["gb_urlvars"] = "";
}		
		
		
/*!
	script.php/query
	script.php?query
	dir/?query
	return params on url
	js, 2001.09.04
*/
function get_query()
{
	$request = $GLOBALS['REQUEST_URI'];
	
	if ( is_int(strpos($request, $GLOBALS['SCRIPT_NAME'])) )
	{
		$request = str_replace($GLOBALS['SCRIPT_NAME'], '', $request);

		if ($request) 
		{
			return substr($request, 1, strlen($request));
		} else
		{
			return '';
		}

	} else
	{
		if ( strlen($request) > (strlen(dirname($GLOBALS['SCRIPT_NAME'])) + 1) )
		{	
			return  substr($request, 2 + strlen(dirname($request)), strlen($request));
		} else
		{
			return '';
		}
	}
}




/** removes "http://", if link is of form http://www.something */
function shortenWWWUri($uri){
	if (substr($uri,0,10)=='http://www')
		return substr($uri,7);
	return $uri;
}

/**
 *  callback for replacing url bbcodes with html markup
 */
function callbackReplaceUris($matches){
	if ($matches[1]){
		// custom url tag
		if ($matches[2])
			$uri = $matches[3];
		else
			$uri = $matches[4];
			
		$title = $matches[4];
	}
	else {
		$uri = $matches[5];
	}
	
	$newPage = true;

	// append "http", if user forgot to
	if (!strpos($uri,'://'))
		$uri='http://'.$uri;
	
	// if no link title is assumed, set it to uri
	if (!isset($title) || trim($title)=='')
		$title = shortenWWWUri($uri);
		
	return '<a href="'.$uri.'" '.
		($newPage?'target="_blank"':'').'>'.$title.'</a>';
}





/** callback for replacing email bbcodes with html markup
 * @access private */
function callbackReplaceEmails($matches){
	if ($matches[1]){
		// custom email
		if ($matches[2])
			$email = $matches[3];
		else
			$email = $matches[4];
			
		$title = $matches[4];
	}
	else { 
		$email = $matches[5];
		$title = $email;
	}
	
	return '<a href="mailto:'.$email.'">'.$title.'</a>';
}

define('REG_EXP_URI','(https?\:\/\/|www\.)[^\s\]\,\:\.\;\?\!\-]+([\,\:\.\;\?\!\-]+[^\s\]\,<>\:\.\;\?\!\-]+)*'); 
define('REG_EXP_EMAIL','[^\s\]]+@[^\s\]]+');



/*!
	make html from bb code
*/
function do_ubb ($article) 
{
	$article = str_replace("<", "&lt;", $article);
	$article = str_replace(">", "&gt;", $article);
	$article = str_replace("\n", "<br>", $article);
	$article = str_replace("\r", "", $article);
	#do UBB code
	$article = str_replace("[b]","<b>",$article);
	$article = str_replace("[/b]","</b>",$article);
	$article = str_replace("[i]","<i>",$article);
	$article = str_replace("[/i]","</i>",$article);
	$article=eregi_replace("\\[img=([^\\[]*)\\]","<img src=\"\\1\">",$article);




	// TODO: nelabai grazus workaroundas 
	// preg_match atsisako dirbti su lietuviska stringo koduote
	// dirbam konvertuodami i UTF8 ir atgal. 
	// su situo lietuviskai, rusiskai komentuoti lyg ir leidzia po senovei.
	$article = utf8_encode($article);


//	$article=eregi_replace("\\[url=([^\\[]*)\\]([^\\[]*)\\[/url\\]","<a target=\"_new\" href=\"\\1\">\\2</a>",$article);
//	$article=eregi_replace("\\[url\\]([^\\[]*)\\[/url\\]","<a target=\"_new\" href=\"\\1\">\\1</a>",$article);
	$urlTag = '\[url(=([^\]]+))?\]([^\[]*)\[\/?url\]';
	$article = preg_replace_callback('/('.$urlTag.')|('.REG_EXP_URI.')/ui', 'callbackReplaceUris', $article);

//	$article=eregi_replace("\\[email=([^\\[]*)\\]([^\\[]*)\\[/email\\]","<a href=\"mailto:\\1\">\\2</a>",$article);
	$emailTag = '\[email(=([^\]]+))?\]([^]]+)\[\/?email\]';
	$article = preg_replace_callback('/('.$emailTag.')|('.REG_EXP_EMAIL.')/ui','callbackReplaceEmails',$article);


	$article = utf8_decode($article);


	$article=eregi_replace("\\[icq=([^\\[]*)\\]([^\\[]*)\\[/icq\\]","<a href=\"http://wwp.icq.com/scripts/Search.dll?to=\\1\">\\2</a>",$article);
	$article=eregi_replace("\\[colour=([^\\[]*)\\]([^\\[]*)\\[/colour\\]","<font color=\\1>\\2</font>",$article);
	$article=eregi_replace("quote\\]","quote]",$article);  // make lower case
	$article=str_replace("[quote]\r\n","<blockquote><smallfont>",$article);
	$article=str_replace("[quote]","<blockquote><smallfont>",$article);
	$article=str_replace("[/quote]\r\n","</smallfont></blockquote>",$article);
	$article=str_replace("[/quote]","</smallfont></blockquote>",$article);
	#all done, return the stuff
	return $article;
}


/*!
	back to ubb from html
*/
function undo_ubb ($article) 
{
	#check for rogue apostrophes and remove HTML <BR>
	$article = stripslashes($article);
	$article = str_replace("<br>","\n",$article);
	#undo UBB code
	$article = str_replace("<b>","[b]",$article);
	$article = str_replace("</b>","[/b]",$article);
	$article = str_replace("<i>","[i]",$article);
	$article = str_replace("</i>","[/i]",$article);

	$article=eregi_replace("\\<img src=\"([^>\[]*)\"\\>" ,"[img=\\1]",$article);

	$article=preg_replace("/\\<a target=\"_new\" href=\"(.*?)\"\\>([^<\[]*)<\/a>/i","[url=\\1]\\2[/url]",$article);
	$article=eregi_replace("\\<font color=([^>\[]*)\\>([^<\[]*)</font>" ,"[colour=\\1]\\2[/colour]",$article);
	$article=eregi_replace("\\<a href=\"mailto:([^\\[]*)\"\\>([^<\[]*)</a>","[email=\\1]\\2[/email]",$article);
	$article=str_replace("<blockquote><smallfont>","[quote]",$article);
	$article=str_replace("</smallfont></blockquote>","[/quote]",$article);

	#all done, return the stuff
	return $article;
}


/*!
	generate password
*/
function genpass( $length = 8 )
{
	mt_srand ((double) microtime() * 1000000);
	$puddle = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	
	$out = '';
	for($index=0; $index < $length; $index++)
	{
		$out .= substr($puddle, (mt_rand()%(strlen($puddle))), 1);
	}
	
	return $out;
}


/*!
	return list with all available languages
*/
function get_language_select($current)
{
	$handle = opendir($GLOBALS['RELPATH'] . 'lang/');
	readdir($handle); // .
	readdir($handle); // ..

	$out = array(); $index = 0;
	while($file = readdir($handle))
	{
		$file = substr($file, 0, 2);
		$out[$index]['value'] = $file;
		$out[$index]['name'] = $file;
		$out[$index]['selected'] = '';
		if ($current == $file) { $out[$index]['selected'] = 'selected'; }
		$index++;
	}
	return $out;
}

/*!
	return list with all available themes
*/
function get_theme_select($current)
{
	$handle = opendir($GLOBALS['RELPATH'] . 'control/tpl/');
	readdir($handle); // .
	readdir($handle); // ..

	$out = array(); $index = 1;
	$out[0]['name'] = 'default';
	$out[0]['value'] = 'default';
	$out[0]['selected'] = '';
	if ($current == 'default') { $out[0]['selected'] = 'selected'; }

	while( $file = readdir($handle) )
	{
		if (is_dir($GLOBALS['RELPATH'] . 'control/tpl/' . $file))
		{
			$out[$index]['value'] = $file;
			$out[$index]['name'] = $file;
			$out[$index]['selected'] = '';
			if ($current == $file) { $out[$index]['selected'] = 'selected'; }
			$index++;
		}
	}
	return $out;
}

/*!
	round with 2 decimal places		
*/
function rnd2($a)
{
	return round($a*100)/100;
}

/*!
  strtotime for lithuanian dates
*/
function strtotimelt($date)
{
  $date = str_replace(".",'-', $date);
  return strtotime($date);
}

?>
