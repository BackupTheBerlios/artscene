<? 
/**
	Constants and preconfig scripts

	Created: js, 2002.04.29
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
* @version $Id: site.header.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/

$g_cvs_id_log = '';
function cvs_id ($id) { $GLOBALS['g_cvs_id_log'] .= "$id\n"; }
cvs_id('$Id: site.header.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');

define ('COREDIR', 'core/');
define ('APIDIR',  'api/');
define ('LIBDIR',  'lib/');
define ('CONFDIR',  'conf/');
define ('LANGDIR',  'lang/');
define ('MODDIR',  'modules/');

define ('INI_FILE', 'global.ini.php');

define ('FLEXI_VERSION', '3.0');

set_magic_quotes_runtime(0);
error_reporting(E_ALL);

include_once( RELPATH . LIBDIR . 'util.inc.php' );


$g_user_id = false;
$g_debug_level = 0;

include_once( RELPATH . COREDIR . 'fuerror.class.php' );

include_once( RELPATH . COREDIR . 'fukernel.class.php' );


$g_kernel =& new fuKernel();

?>