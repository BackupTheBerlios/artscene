<?

$test_file = implode("", file('xml_note.xml'));

include_once("../lib/fuxml.class.php");
include_once("../lib/fuxmlsax.class.php");
include_once("../lib/fubench.class.php");

$b = new fuBench();
$b->round = 10;

$b->addPoint("fuXmlSAX");
$xmlpar =& new fuXmlSax();
$tree = $xmlpar->parse($test_file);
$b->endPoint();

nl2br(htmlspecialchars(print_r($tree)));

echo "fuXML<BR><BR>\n\n";

$b->addPoint("fuXml");
$tree2 = fuXml::arrayTree($test_file);
$b->endPoint();

nl2br(htmlspecialchars(print_r($tree2)));

$b->endBench();

?>