<?

define( 'RELPATH', './' );
include( 'site.header.php' );


$g_kernel->loadApi('frontapi');


echo $g_kernel->process();


echo "<pre>".$g_cvs_id_log;
echo get_debug_log();

?>