<?
/**
	module abstraction
	
	Created: js, 2002.11.07
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package core	
*/


/**
* abstract module
* @version $Id: fumodule.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/
class fuModule
{
	var $kernel = null;
	var $name = '';
	
	var $is_on_menu = true;
	
	function fuModule(&$kernel)
	{
		$this->kernel =& $kernel;
		$this->name = get_class($this);
		$this->kernel->loadModuleLanguage($this->name);

		$this->registerControlets();
		$this->registerComponents();
		
		debug("fuModule[$this->name]: loaded.");
	}
	
	/**
	* return html for module menu
	* requires module.menu handle in template
	*/
	function getMenu()
	{
		$this->kernel->tpl->set_var('module.name', $this->name);
		return $this->kernel->tpl->process('', 'module.menu');
	}
	
	/**
	* return html for module menu if active
	* requires module.menu.active handle in template
	*/
	function getMenuActive()
	{
		$this->kernel->tpl->set_var('module.name', $this->name);
		return $this->kernel->tpl->process('', 'module.menu.active');
	}
	
	function getSubMenu()
	{
		return '';
	}
	
	function loadLang()
	{
		global $g_lang;
		include_once( RELPATH . 'modules/' . $this->name . '/lang/'. $this->kernel->lang_name .'.lang.php');
	}
	
	function registerControlets()
	{
	}
	
	function registerComponents()
	{
	}
	
	function getDefaultControletName()
	{
		return '';
	}
	
	/**
	* @todo error check
	*/
	function loadControlet($conname)
	{
		$file = RELPATH . MODDIR . $this->name . '/controlets/'. $conname .'.class.php';
		if (!file_exists($file)) 
			$this->kernel->errorPage( sprintf($this->kernel->lang['error.str.nocontrolet'], $conname) );
		include_once( $file );
		$this->controlet =& new $conname(&$this->kernel);
	}
	
	function isOnMenu()
	{
		return $this->is_on_menu;
	}
}

cvs_id('$Id: fumodule.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');
?>