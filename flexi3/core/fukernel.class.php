<?
/**
	kernel
	
	Created: js, 2002.10.18
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package core	
*/

/**
*/

include_once( RELPATH . COREDIR . 'fudb.class.php' );
include_once( RELPATH . COREDIR . 'fusession.class.php' );
include_once( RELPATH . COREDIR . 'fuuser.class.php' );
include_once( RELPATH . COREDIR . 'futemplate.class.php' );
include_once( RELPATH . COREDIR . 'fuxmlini.class.php' );

/**
* system Kernel
*
* @version $Id: fukernel.class.php,v 1.2 2003/03/23 21:45:27 pukomuko Exp $
*/
class fuKernel
{
	var $db = null;
	var $error = null;
	var $tpl = null;
	var $session = null;
	var $perm = null;
	var $user = null;
	var $ini = null;
	
	var $lang = null;
	var $lang_name = '';
	
	var $api = null;
	var $apiname = '';
	
	var $modules = array();
	var $modules_names = array();
	
	
	function fuKernel( $apiname = false )
	{
		debug('fuKernel: starting...');
		$this->apiname = $apiname;
		
		$this->registerGlobals();
		$this->createObjects();
		
		$this->configure();
		
		$this->loadLanguage();
		
		if ($apiname) $this->loadApi($apiname);
		debug('fuKernel: started.');
	}
	
	
	/**
	* this method cannot be called from kernel contructor,
	* that's why you have to pass &$this for core objects.
	*
	* @return refrence global kernel
	*/
	function &getInstance()
	{
		return $GLOBALS['g_kernel'];
	}
	
	
	/**
	* put cookie post and get vars to global array
	*/
	function registerGlobals()
	{
		$this->_fix_magic_quotes_gpc();
		
		// set global variables if needed
		global $HTTP_SERVER_VARS, $HTTP_COOKIE_VARS, $HTTP_POST_VARS, $HTTP_GET_VARS;
		
		if (isset($_SERVER))
		{
			foreach ($_SERVER as $key=>$val) isset($GLOBALS[$key]) || $GLOBALS[$key] = $val;
		}
		else
		{
			foreach ($HTTP_SERVER_VARS as $key=>$val) isset($GLOBALS[$key]) || $GLOBALS[$key] = $val;
		}
		
		foreach ($HTTP_COOKIE_VARS as $key=>$val) isset($GLOBALS[$key]) || $GLOBALS[$key] = $val;
		foreach ($HTTP_POST_VARS as $key=>$val) isset($GLOBALS[$key]) || $GLOBALS[$key] = $val;
		foreach ($HTTP_GET_VARS as $key=>$val) isset($GLOBALS[$key]) || $GLOBALS[$key] = $val;
	}
	
	/**
	* create db error and others
	*/
	function createObjects()
	{
		debug('fuKernel: creating objects...');
		
		$this->error =& new fuError(&$this);
		$this->db =& new fuDb(&$this);
		$this->session =& new fuSession(&$this);
		
		$this->tpl =& new fuTemplate(&$this, RELPATH);
	
		$this->ini =& new fuXmlIni(&$this, RELPATH . CONFDIR . INI_FILE);
		
		$this->user =& new fuUser(&$this, $GLOBALS['g_user_id']);
		
		$this->lang =& $GLOBALS['g_lang'];
	}
	
	function configure()
	{
		debug('fuKernel: configuring...');
		
		if (!($this->lang_name = $this->user->getProperty('lang')))
		{
			$this->lang_name = $this->ini->getIniValue('control', 'lang');
		}
		
		$this->tpl->set_var('site.name', $this->ini->getIniValue('site', 'name'));
		
	}
	
	/**
	* load API class file
	*/
	function loadApi( $apiname )
	{
		require_once( RELPATH . APIDIR . "$apiname.class.php" );
		$this->api =& new $apiname();
	}
	
	/**
	* @return string
	*/
	function process()
	{
		return $this->api->process();
	}
	
	/**
	* @todo error checking
	*/
	function loadLanguage()
	{
		global $g_lang;
		include_once( RELPATH . LANGDIR . $this->lang_name . '.lang.php');
		
		$this->tpl->set_var('lang', $this->lang);
	}
	
	/**
	* @todo error checking
	*/
	function loadModuleLanguage($module)
	{
		global $g_lang;
		include_once( RELPATH . MODDIR . "$module/" . LANGDIR . $this->lang_name . '.lang.php');
	}
	
	/**
	* @todo error?
	*/
	function loadModule($name)
	{
		include_once( RELPATH . MODDIR . "$name/$name.module.php" );
		$this->modules_names[] = $name;
		$this->modules[$name] =& new $name(&$this);
	}
		
	/**
	* clean magic quotes
	* @access private
	*/
    function _fix_magic_quotes_gpc() 
    {
        $needs_fix = array('HTTP_POST_VARS',
                           'HTTP_GET_VARS',
                           'HTTP_COOKIE_VARS',
                           'HTTP_SERVER_VARS',
                           'HTTP_POST_FILES');
        
        // Fix magic quotes.
        if (get_magic_quotes_gpc()) 
       	{
            foreach ($needs_fix as $vars) 
            	$this->_stripslashes($GLOBALS[$vars]);
        }
    }

	/**
	* recursively strip slashes
	* @access private
	*/
    function _stripslashes(&$var) 
   	{
        if (is_array($var)) 
       	{
            foreach ($var as $key => $val)
                $this->_stripslashes($var[$key]);
        }
        elseif (is_string($var))
        {
            $var = stripslashes($var);
        }
    }

	function errorPage($str)
	{
		$this->tpl->set_file('error.page', MODDIR . 'control/tpl/page.error.html');
		$this->tpl->set_var('error.str', $str);
		echo $this->tpl->process('', 'error.page');
		exit;
	}	
}

cvs_id('$Id: fukernel.class.php,v 1.2 2003/03/23 21:45:27 pukomuko Exp $');

?>