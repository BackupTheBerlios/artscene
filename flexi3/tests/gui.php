<?php
// $Id: gui.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
// naujas branch'as niu o mes einam toliau?

define('RELPATH', '../');
include('../site.header.php');

// Set the name of your testsuite class
$testName = "flexiUpdate3 tests";
// Set the path of your testsuite file
$testFile = "test_tpl.php";

require_once "PHPUnit/PHPUnit.php";
require_once 'dbtest.php';
require_once 'xmlinitests.php';
require_once 'sessiontest.php';

// run test
$suite = new PHPUnit_TestSuite();

//$suite->addTestSuite('dbtest');
$suite->addTestSuite('xmliniTest');
$suite->addTestSuite('sessionTest');

$result = PHPUnit::run($suite);

// do some calculations
$per = 100/$result->runCount();
$notOkWidth = ($per*$result->errorCount())+($per*$result->failureCount());
$okWidth = 100 - $notOkWidth ;

?>

<html>
<head>
    <title>unitTests - flexiUpdate 3.0 pre0</title>
</head>
<body style="font-family:Verdana;"><center>
	<h2><?php echo $testName; ?></h2>
    <table>
        <tr><td>Runs:</td><td> <?php echo $result->runCount(); ?></td></tr>
        <tr><td>Errors:</td><td> <?php echo $result->errorCount(); ?></td></tr>        
        <tr><td>Failures: </td><td><?php echo $result->failureCount(); ?></td></tr>
    </table><br>
    <table width="50%">
        <tr>
            <td width="20%" align="left">0%</td>
            <td width="20%" align="center">25%</td>
            <td width="20%" align="center">50%</td>
            <td width="20%" align="center">75%</td>            
            <td width="20%" align="right">100%</td>                                    
        </tr>
    </table>    
    <table width="50%" height="30px" cellspan="0" cellpadding="0">
        <tr>
            <td width="<?php echo $okWidth; ?>%" bgcolor="green"></td>
            <td width="<?php echo $notOkWidth; ?>%" bgcolor="red"></td>            
        </tr>
    </table>
    <table cellspan="0" cellpadding="0" border="0">
    <tr><td><br>
    
    <h3>Failures</h3>
        <form>
            <pre>
<?php
// print the failures
$fails = $result->failures();
foreach($fails as $failure) {
	echo $failure->toHtml();
	echo "-------------------------------\n";
}
?></pre>
        </form>        
    <h3>Errors</h3>
        <form>
            <pre><?php
// print the errors
$errs = $result->errors();
foreach($errs as $error) {
	echo $errors->toString();
	echo "-------------------------------\n";
}
?></pre>
        </form>

    <h3>Log</h3>
        <form>
            <pre>
<?php

	echo $result->toHtml();

?></pre>
        </form>        
        </td></tr>
     </TABLE>
</center>
</body>
</html>