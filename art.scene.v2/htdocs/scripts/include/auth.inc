<?  // uzsiautentifikuojame, kad blogi elementai neprikrestu eibiu



$user['kravitz'] = 'kr4vytz';	$level['kravitz'] = 200;
$user['mrfrost'] = 'zodis';		$level['mrfrost'] = 500;

function authenticate() 
{
   Header("WWW-Authenticate: Basic realm=\"art.scene\"");
   Header("HTTP/1.0 401 Unauthorized");
	echo 'Neatspëjai slaptaþodþio. Arba neturi teisës èia prieiti.';
	exit;
}


function auth($l=0)
{
	global $PHP_AUTH_USER, $PHP_AUTH_PW;
	global $user, $level;
	if(!isset($PHP_AUTH_USER)) { authenticate(); } else 
	{	if ( ($user[strtolower($PHP_AUTH_USER)] != $PHP_AUTH_PW) or ($l > $level[strtolower($PHP_AUTH_USER)]) )  
			{authenticate();}
	}
}


if (empty($g_auth))
{

    if(!isset($PHP_AUTH_USER)) 
	{
        authenticate();
    } 
	else 
	{
		if (('mrfrost' != strtolower($PHP_AUTH_USER) ) or
	        ('zodis' != $PHP_AUTH_PW)) 
			{ authenticate(); }
    }
}
    
?>
