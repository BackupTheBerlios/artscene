<?
/**
	frontend api
	
	Created: js, 2003.03.23
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package core	
*/

/**
*/
include_once( RELPATH . COREDIR . 'fuapi.class.php' );

/**
*/
class frontapi extends fuApi 
{
	var $pageName = '';
	
	/**
	* string after page name
	*/
	var $paramString = '';
	
	/**
	*
	*/
	function frontapi()
	{
		parent::fuApi();
		
		$this->getPageName();
	}
	
	/**
	*
	*/
	function process()
	{
		echo "<B>$this->pageName - $this->paramString</B>";
		
		$pageInfo = $this->getPageInfo($this->pageName);
		// bad page name? redirect home, home sets default page
		if (!$pageInfo) $this->_redirectHome();
		
		
		
	}	
	
	
	/**
	* deduce page name from request uri
	* prepare param string
	*/
	function getPageName()
	{
		
		// if we have no trailing slash, we get many problems
		if (empty($_SERVER['PATH_INFO']))
		{
			$this->_redirectHome();
		}
		
		// first word in path_info must be page name
		if (strlen($_SERVER['PATH_INFO']) == 1)
		{
			$this->pageName = $this->kernel->ini->getIniValue('site', 'defaultPage');
		}
		else 
		{
			if ($pos = strpos($_SERVER['PATH_INFO'], '/', 2))
			{
				$this->pageName = substr($_SERVER['PATH_INFO'], 1, $pos-1);
				$this->paramString = substr($_SERVER['PATH_INFO'], $pos+1, strlen($_SERVER['PATH_INFO']));
			}
			else
			{
				$this->pageName = substr($_SERVER['PATH_INFO'], 1, strlen($_SERVER['PATH_INFO']));
			}
		}
		
	}
	
	/**
	* get page description from db, unserialize xml
	*/
	function getPageInfo($iname)
	{
		$iname = clean_name($iname);
		
		$result = $this->kernel->db->selectRow("SELECT p.*, t.definition AS tpl_definition
						FROM fu_pages p, fu_templates t
						WHERE p.iname = '$iname' AND p.template = t.id");
		
		if (!$result) return false;
		
		// unserialize xml
		if (!empty($result['definition'])) $result['definition'] = unserialize($result['definition']);
		if (!empty($result['tpl_definition'])) $result['tpl_definition'] = unserialize($result['tpl_definition']);
		if ($result['override'] && !empty($result['override_definition'])) $result['override_definition'] = unserialize($result['override_definition']);		
		
		return $result;
	}

	function _redirectHome()
	{
		//echo "<pre>". print_r($_SERVER); exit;
		$href = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . '/';
		redirect($href);		
	}
	
	
}

cvs_id('$Id: frontapi.class.php,v 1.2 2003/03/24 22:54:26 pukomuko Exp $');
?>