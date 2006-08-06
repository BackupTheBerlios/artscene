<html>
<head>
<META http-equiv="Content-Type" content="text/html; charset=windows-1257">
<title>komentaro įdėjimas į galeriją [art.scene]</title>
<link href="/artscene.css" media="screen" rel="STYLESHEET" type="text/css">
</HEAD>
<BODY bgcolor="#000000" text="#C5C0B7" link="#ADBCCD" vlink="#B39595">
Dėl bet kokių klaidų rašykite į <a href="mailto:artscene@fluxus.lt">artscene@fluxus.lt</a>
<br>
<?
//submit_hirez_talk - kometaru pridejimas
	
	include("include/config.inc");
	include("include/code.inc");
//	include("include/class.Validator.inc");
    
	clearstatcache();
	
	
	if ( !$comment ) { die("error: kur tavo komentaras?");}
	if ( !$realname ) { die("error: kur tavo vardas? ");}
	
	connect2db();
	
	// convert strings
	$realname=htmlspecialchars($realname);
	$email=htmlspecialchars($email);
	$comment=htmlspecialchars($comment);
	
	$comment=AddSlashes($comment);
	$realname=AddSlashes($realname);
	$email=AddSlashes($email);


	if($ret=mysql_query("insert into hirez_talk values ('$realname','$email','$iid','$comment',NOW(),0)")) {
		echo "atsiliepimas įdėtas, eikit <a href=\"javascript:history.back()\">atgal</a> ir darykit reload <br> \n";
		echo "<br>\n";
	} else {
		echo "unable to insert the comment to the database ($ret)<P>\n";
		echo mysql_errno()." -- ".mysql_error()."<br>\n";
		echo "rašykit į artscene@fluxus.lt dėl šitos problemos";
	}
	

	// jeigu atejom iki cia, galim siusti laiska
	$zinute = "Autorius:   $realname\nE-mail:     $email\nPiesinys:   $iid $pname\nKomentaras: $comment\nhttp://artscene.fluxus.lt/scripts/hirez_browse.php?iid=$iid\n\npašto automatas"; 
//	mail("artscene@fluxus.lt","naujas:atsiliepimas", $zinute, "From:artscene@fluxus.lt\r\nReply-to:artscene@fluxus.lt");
?>