<? 
/**
	Global error header 
	
	Created: js, 2001.08.13
	___________________________________________________________
	This file is part of flexiUpdate, content control framework

* @package core
*/


error_reporting(E_ALL);
/**
*/
define ('FU_E_FATAL', 100);
define ('FU_E_WARNING', 101);
define ('FU_E_NODB', 103);

/**
* Global error handler
*
* @version $Id: fuerror.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/
class fuError
{
	var $message = '';
	var $action = 'report';
	var $kernel = false;

	/**
		
	*/
	function fuError( &$kernel, $action = 'report' )
	{
		$this->kernel =& $kernel;
		$this->action = $action;
		$GLOBALS['g_error'] =& $this;
		
		set_error_handler('handler_gateway');
		
		debug('fuError: started.');
	}

	/**
	*	report(long level, string msg, param, param ...)
	*	report(string msg, param, param ...)
	*	param optional
	*	level optional
	*	default level eFATAL
	*/
	function report ()
	{
		$args = func_get_args();
		
		$i = 0;
		$level = FU_E_WARNING;
		if (is_long($args[0]))
		{
			$level = array_shift($args);
		}

		// prepare msg
		$msg = array_shift($args);
		switch (count($args))
		{
			case 0: $out = $msg;
				break;

			case 1:	$out = sprintf($msg, $args[0]);
				break;
					
			case 2:	$out = sprintf($msg, $args[0], $args[1]);
				break;
					
			case 3:	$out = sprintf($msg, $args[0], $args[1], $args[2]);
				break;
					
			default: $out = $msg . implode(';', $args);
		}
		
		switch ($level)
		{
			case FU_E_FATAL: $this->write($out); exit;
				break;

			case FU_E_WARNING: $this->write($out);
				break;
				
			case FU_E_NODB: $this->write($out); exit; redirect( RELPATH . 'html/');
				break;
		}
		 
	}

	function handler($errno, $errstr, $errfile, $errline, $context)
	{
		$errpage = $GLOBALS['REQUEST_URI'];
		$referer = isset($GLOBALS['HTTP_REFERER']) ? $GLOBALS['HTTP_REFERER'] : '';
		$server = $GLOBALS['SERVER_NAME'];
		$msg = "<br><b>ERROR</b>:<br>
				<font color='#CC0000'>$errstr</font>
				<br>
				failas: $errfile [$errline]<br>
				puslapis: $errpage<br>
				referer: $referer<br>
				</font>
				<br><br>";
		$this->report($msg);
	}
	
	function write($msg)
	{
		switch ($this->action)
		{
			case 'report':
					echo "<br><font color=#CC0000>$msg</font><br>";
				break;
			case 'log':
					// write to some log
					debug('fuError: write_error ' . $msg);
				break;

			case 'mail':
					// mail to someone
				break;

		}
	}
	/*!
		empty error message
	*/
	function flush()
	{
		$this->message = '';
	}
 
}

function handler_gateway($errno, $errstr, $errfile, $errline, $context)
{
	$GLOBALS['g_error']->handler($errno, $errstr, $errfile, $errline, $context);
}
		
/**
	temporary simple error handler
*/
function fuSimpleErrorHandler ($errno, $errstr, $errfile, $errline, $context) 
{
	global $HTTP_SERVER_VARS;
	if (!error_reporting()) return false;
	$errpage = $HTTP_SERVER_VARS['REQUEST_URI'];
	$referer = isset($HTTP_SERVER_VARS['HTTP_REFERER']) ? $HTTP_SERVER_VARS['HTTP_REFERER'] : '';
	$server = $HTTP_SERVER_VARS['SERVER_NAME'];
	echo "<br>
	<b>ERROR</b>:<br>
	<font color='#CC0000'>$errstr</font>
	<br>
	failas: $errfile [$errline]<br>
	puslapis: $errpage<br>
	referer: $referer<br>
	<br><br>";
}

set_error_handler("fuSimpleErrorHandler");

cvs_id('$Id: fuerror.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');

?>