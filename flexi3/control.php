<?

define( 'RELPATH', './' );
include( 'site.header.php' );

if (!$g_kernel->user->isLoggedIn() || !empty($logout))
{
	$g_kernel->loadApi('loginapi');
}
else
{
	$g_kernel->loadApi('controlapi');
}


echo $g_kernel->process();


echo "<pre>".$g_cvs_id_log;
echo get_debug_log();

?>