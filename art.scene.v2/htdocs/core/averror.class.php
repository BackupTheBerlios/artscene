<?
/*
	Global error header 	
	Created: js, 2001.08.13
	$Id: averror.class.php,v 1.4 2007/12/21 23:23:23 pukomuko Exp $
	___________________________________________________________
*/


//!! core lib
//! error handler

/*!
	sitos klases extenderiai gales turet ivairius action
	pas sita tai turetu buti tik trys

	report
	halt
	silent

*/
class avError
{
	var $message = '';
	var $action = 'report';

	/*!
		
	*/
	function avError( $action = 'report' )
	{
		$this->action = $action;
	}

	/*!
		report error
	*/
	function error( $msg, $level = '')
	{
		trigger_error($msg, 256);
		$this->message .= $msg;

		if ('silent' != $this->action)
		{
			//echo "\n<br><font color='#CC0099'><b>$level:</b> {$this->message}</font><br>\n";

			$this->message = '';
		}

		if ('halt' == $this->action || 'fatal' == $level) { exit; }
	}

	function report( $level, $msg ) 
	{
		$this->error($msg, $level);
	}

	/*!
		empty error message
	*/
	function flush()
	{
		$this->message = '';
	}
 
}


// error handler function
function avErrorHandler ($errno, $errstr, $errfile, $errline, $context) 
{
  global $g_user_id, $g_user_name;
	if (!error_reporting()) return false;
	$errpage = $GLOBALS['REQUEST_URI'];
	$text = "<br>
	<b>atsipraðome, bet sistemoje ávyko klaida</b>:<br>
	<font color='#CC0000'>$errstr</font>
	<br>
	failas: $errfile [$errline]<br>
	puslapis: $errpage<br>
	g_user_id: $g_user_id<br>
	g_user_name: $g_user_name<br>
	<br><br>";

	if (isset($GLOBALS['bench'])) { echo $text; }
	else { 
		mail('salna@ktl.mii.lt', 'klaida ant art.scene.lt', $text);
		echo "<b>atsipraðome, bet sistemoje ávyko klaida</b>: ";
		echo "<font color='#CC0000'>$errno</font><br>";		
	}
}


set_error_handler("avErrorHandler");
?>