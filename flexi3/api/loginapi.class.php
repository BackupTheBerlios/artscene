<?
/**
	login api
	
	Created: js, 2002.11.12
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package core	
*/

/**
*/
include_once( RELPATH . COREDIR . 'fuapi.class.php' );

/**
*/
class loginapi extends fuApi 
{
	
	/**
	*/
	function loginapi()
	{
		parent::fuApi();
	}
	

	/**
	* @todo register bad login
	*/
	function process()
	{
		global $username, $password;
		
		$this->kernel->tpl->set_var('login.error', '');
		$this->kernel->tpl->set_var('user.name', '');
				
		if (isset($GLOBALS['logout'])) 
		{
			$this->kernel->session->logout();
			$this->kernel->user->log('logout');	
		}

		if (isset($GLOBALS['cookie_user_name'])) 
		{
			$this->kernel->tpl->set_var('user.name', $GLOBALS['cookie_user_name']); 
		}
		
		if (isset($GLOBALS['submit']))
		{
			if (empty($GLOBALS['username']) || empty($GLOBALS['password'])) 
			{
				$this->kernel->tpl->set_var('login.error', $this->kernel->lang['login.error.empty'] );
			}
			else 
			{
				$result = $this->kernel->user->login($username, $password);

				if (empty($result)) 
				{
					// register bad login
					$host = remote_addr();
							
					$this->kernel->tpl->set_var('login.error', $this->kernel->lang['login.error']);
					$this->kernel->tpl->set_var('user.name', $username);
				} 
				else 
				{
					setcookie ("cookie_user_name", $username, time() + 360000000, "/");

					redirect( $GLOBALS['PHP_SELF'] );
					exit;				
				}
			}

		}
		
		$this->kernel->tpl->set_file('login_tpl', MODDIR . 'control/tpl/page.login.html');
		return $this->kernel->tpl->process('', 'login_tpl');
	}
}

cvs_id('$Id: loginapi.class.php,v 1.2 2003/03/23 21:47:02 pukomuko Exp $');
?>