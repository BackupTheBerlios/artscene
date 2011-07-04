<?php
/*!
	prints out redirection page
	header, javascript, link
*/
function redirect($page)
{
	header("Location: $page");
	
	?> 
	<html><head><title>redirect</title>
	<meta http-equiv="Refresh" content="0; URL=<? echo $page ?>">
	</head>

	<body>
	<script language="JavaScript">
	<!--
	window.location = '<? echo $page ?>';
	//-->
	</script>
	<a href="<? echo $page ?>"><b>spauskit čia / enter here</b></a>
	
	</body>
	</html>
	<?
	exit;
}

$process = 'process.php';

if (substr($_SERVER['REQUEST_URI'] , - strlen("/$process")) == "/$process") redirect ("$process/");


?><!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title> art.scene.v2 </title>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<link href="../css/artv2.css" rel="stylesheet" type="text/css">
	<LINK REL="SHORTCUT ICON" HREF="http://art.scene.lt/favicon.ico">
</head>

<body topmargin=0 leftmargin=0 marginheight=0 marginwidth=0>

<table width="100%" border=0 cellpadding=0 cellspacing=0 height=""><tr> <!-- outter layout -->
	<td class="table-light" valign="top" align="left" width="769">
	
	
	<table width="100%" border=0 cellpadding=0 cellspacing=0> <!-- logo virsus -->
	<tr>
		<td class="border-out" valign="top" align="left"><img src="../design_images/art.scene.logo.top.gif" width="374" height="10" border=0 alt=""></td>
	</tr>
	</table> <!-- logo virsus -->
	
	<table width="100%" border=0 cellpadding=0 cellspacing=0> <!-- header -->
	<tr>
		<td valign="top" align="left"><a href="../process/"><img src="../design_images/art.scene.logo.bottom.gif" width="377" height="59" border=0 alt=""></a><br>&nbsp;

		
		</td>
		<td valign="bottom" align="right" rowspan=3><img src="../dot.gif" width="1" height="5" border=0 alt=""><br>


		<img src="../design_images/header.bottom.right2.gif" width="262" height="45" border=0 alt=""><!-- <img src="../design_images/header.bottom.right.gif" width="262" height="103" border=0 alt=""> --></td>
	</tr>
	<tr>
		<td valign="bottom">
		
		    <table><tr><td>&nbsp;</td><td>
			šiuo metu vyksta serverio atnaujinimo darbai.<br>
			ateikite už valandos, rytoj, poryt.<br>
			būtinai praneškite apie pastebėtas klaidas, kai artscena atsigaus!<br>
			<a href="mailto:art@scene.lt">art@scene.lt</a>

            </td></tr></table>

		</td>
	</tr>
	<tr>
		<td valign="bottom">

			
			

		</td>
	</tr>
	</table> <!-- header -->

	<table width="100%" border=0 cellpadding=0 cellspacing=0> <!-- linija -->
	<tr>
		<td class="border-out" valign="top" align="left"><img src="../dot.gif" width="769" height="10" border=0 alt=""></td>
	</tr>
	</table> <!-- linija -->
	
	

	</td><!-- vidines celles pabaiga -->

	<td class="border-out" valign="top" align="left" width="*"><table width="100%" cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td width="99%" class="border-out"><img src="../dot.gif" width="1" height="10" border=0 alt=""></td>
		<td rowspan="5" width="106" valign="top"><img src="../design_images/top.right.gif" width="106" height="64" border=0 alt=""></td>
	</tr>
	<tr>
		<td class="table-light"><img src="../dot.gif" width="1" height="14" border=0 alt=""></td>
	</tr>
	<tr>
		<td class="border-out"><img src="../dot.gif" width="1" height="8" border=0 alt=""></td>
	</tr>
	<tr>
		<td class="table-light"><img src="../dot.gif" width="1" height="1" border=0 alt=""></td>
	</tr>
	<tr>
		<td class="border-out"><img src="../dot.gif" width="1" height="30" border=0 alt=""></td>
	</tr>

	</table>

	
	
	</td><!-- isorine celle -->

	<td  class="border-out" valign="top" width="7" background="../design_images/right.background.gif"><img src="../design_images/top.right.right.gif" width="7" height="64" border=0 alt=""></td>


</tr>




</table> <!-- outter layout -->



</body>
</html>
