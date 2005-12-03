<?
/*
	Global error header 	
	Created: js, 2001.08.13
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
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
	if (!error_reporting()) return false;
	$errpage = $GLOBALS['REQUEST_URI'];
	echo "<br>
	<b>atsipraðome, bet sistemoje ávyko klaida</b>:<br>
	<font color='#CC0000'>$errstr</font>
	<br>
	failas: $errfile [$errline]<br>
	puslapis: $errpage<br>
	<b>bûtø labai smagu, jei atsiøstum ðià informacijà <a href='mailto:artscene@fluxus.lt?subject=error on art.scene'>paðtu</a> su prieraðu kà mëginai padaryti.</b>
	<br><br>";
	exit;
}

//set_error_handler("avErrorHandler");
?>
