<?
$RELPATH = "../";

include_once($RELPATH . "site.ini.php");

// Theme support
if (empty($g_theme)) { $g_theme = $g_ini->read_var('site', 'Theme'); }

if ($g_theme == "default" || !$g_theme) 
{
	$g_theme_dir = "";
} 
else 
{
	if ( file_exists($RELPATH.'/control/tpl/'.$g_theme.'/admin_page.html')) {
		$g_theme_dir = $g_theme."/";
	} else {
		setcookie("g_theme", "default", time() + 360000000, "/");
		$g_theme_dir = "";	
	}
}


$g_tpl->set_file('login', 'control/tpl/'.$g_theme_dir.'login_page.html', 1);
$g_tpl->set_var('error', '');

if (!isset($cookie_user_name)) { $cookie_user_name = ''; }
$g_tpl->set_var('last_user_name', $cookie_user_name);

if (!$g_sess->userID) 
{

		if (empty($user_name)||empty($user_password)) 
		{
			if (isset($submit)) {
				$g_tpl->set_var("error","<font color=red>" . $g_lang['login.error_empty'] . "</font>");
			}
			echo $g_tpl->process('out', 'login');
			exit;
		}
		else 
		{
			$g_usr = new avUser();

			$rez = $g_usr->login_user($user_name, $user_password);

			if (empty($rez)) 
			{
				$g_tpl->set_var("error","<font color=red>" . $g_lang['login.error'] . "</font>");
				echo $g_tpl->process("out","login");
				exit;
			} 
			else 
			{
				
				$g_sess->set_var("g_user_name",$rez["username"]);
				$g_sess->set_var("g_user_id",$rez["id"]);
				$g_sess->set_var("g_user_groupID",$rez["group_id"]);
				
				$g_sess->user_login($rez["id"]);
				setcookie ("cookie_user_name", $user_name);
				redirect('admin.php'); exit;				
			}
		}
} 
else 
{
		redirect('admin.php'); exit;	
}

?>
