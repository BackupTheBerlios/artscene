<?
/**
	control api
	
	Created: js, 2002.11.07
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package core	
*/

/**
*/
include_once( RELPATH . COREDIR . 'fuapi.class.php' );

/**
*/
class controlapi extends fuApi 
{
	var $modulename = '';
	var $module = null;
	var $controletname = '';
	
	/**
	* @todo error :) kai ner modulio ka daryti
	*/
	function controlapi( &$kernel )
	{
		parent::fuApi(&$kernel);
		
		$module = $this->kernel->user->getEnabledModules();
		if ($module) foreach ($module as $nameid) $this->kernel->loadModule($nameid['iname']);
	}
	

	/**
	* cia visa logika admin puses
	* is kur ateina popup ?
	* issiaishkinam active module ir active controlet
	* uzkraunam menu
	* uzkraunam submenu
	* atiduodam valdyma controletui
	*/
	function process()
	{
		if (!empty($GLOBALS['control']))
		{
			$tmp = explode('.', clean_name($GLOBALS['control']));
			$this->modulename = $tmp[0];
			isset($tmp[1]) && $this->controletname = $tmp[1];
		}
		
		if (empty($this->modulename))
		{
			$this->modulename = $this->kernel->user->groupinfo['default_module'];
		}
		
		if (!isset($this->kernel->modules[$this->modulename])) 
			$this->kernel->errorPage( sprintf($this->kernel->lang['error.str.nomodule'], $this->modulename ) );
		
		if (empty($this->controletname))
		{
			$this->controletname = $this->kernel->modules[$this->modulename]->getDefaultControletName();
		}

		$this->module =& $this->kernel->modules[$this->modulename];
		
		$this->module->loadControlet($this->controletname);
		
		if ($this->module->controlet->isPopUp())
		{
			return $this->module->controlet->process();
		}
		
		$this->kernel->tpl->set_file('control.page', MODDIR . 'control/tpl/page.control.html', 1);
		
		$this->kernel->tpl->set_var('module_menu', $this->getMenu());
		
		$this->kernel->tpl->set_var('module_submenu', $this->module->getSubMenu());
		
		$this->kernel->tpl->set_var('controlet_space', $this->module->controlet->process());
		
		return $this->kernel->tpl->process('', 'control.page');
	}
	
	function getMenu()
	{
		$menu = '';
		foreach ($this->kernel->modules_names as $modname)
		{
			if (!$this->kernel->modules[$modname]->isOnMenu()) continue;
			
			if ($modname == $this->modulename)
			{
				$menu .= $this->kernel->modules[$modname]->getMenuActive();
			}
			else 
			{
				$menu .= $this->kernel->modules[$modname]->getMenu();	
			}
		}
		return $menu;
	}
	
}

cvs_id('$Id: controlapi.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');
?>