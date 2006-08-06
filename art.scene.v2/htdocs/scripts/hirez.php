<!-- 
kopijavimo ritė pas mrfrost'ą (c) 1999 <salna@ktl.mii.lt>
šitas failas priklauso art.scene projektui http://artscene.fluxus.lt
-->

<HTML>
<HEAD>
	<TITLE>senoji artscene.fluxus.lt piešinių galerija</TITLE>
	<META http-equiv="Content-Type" content="text/html; charset=windows-1257">
	<meta name="Description" content="">
	<meta name="Keywords" content="artscene art.scene art demo hirez piešiniai">
	<link href="/artscene.css" media="screen" rel="STYLESHEET" type="text/css">
</HEAD>
<BODY bgcolor="#000000" text="#C5C0B7" link="#ADBCCD" vlink="#B39595">
<span class="iheader">PIEŠINIŲ GALERIJA</span><br>
<span class="ilink"><a href="http://art.scene.lt" class="ilink">art.scene</a> &gt;&gt; senoji artscene.fluxus.lt piešinių galerija</span><br><br>

<?
// hirezpiesiniubuferio browsinimas su thumbnailais
    include("include/config.inc");
    include("include/code.inc");
    
    connect2db();
    
    $result = mysql_query("select * from hirez order by id desc");
    
    if (!isset($page)) { $page = 2;}
    
    $kiekis = mysql_num_rows( $result ) - 3;
    
    $i_pages = $kiekis / $th_kiek;
    
    $i_pages = floor( $i_pages ) + 1;
    
    if ($kiekis % $th_kiek) { $i_pages++ ;}
    
    
    $atgal = $page - 1;
	$pirmyn = $page + 1;
	
    if ( $atgal == 1 ) { echo "<a href=\"/i_galerija.php\">atgal</a> [ "; }
    else { echo "<a href=\"hirez.php?page=".$atgal."\">atgal</a> [ "; }
    
	echo "<a href=\"/i_galerija.php\">1</a> / ";
	
    for ( $i = 2; $i<$i_pages; $i++ ) {
	if ($i==$page) {echo $i." / ";}
	else { echo "<a href=\"hirez.php?page=".$i."\">$i</a> / ";}
    } //for
    if ($page==$i_pages) { echo $page." ] pirmyn";}
    else { echo "<a href=\"hirez.php?page=".$i_pages."\">$i_pages</a> ] <a href=\"hirez.php?page=".$pirmyn."\">pirmyn</a>";}
    
    
?>
<br>
<br>

<?
// lenteliu epopeja
$i_seek = ($page - 2) * $th_kiek + 3;
if ($i_seek) mysql_data_seek($result, $i_seek);
?>

<? //didelis foras kiekvienai lentelei
   
   for ($tb=1; $tb<=$th_kiek; $tb++) {
   $row = mysql_fetch_array( $result );
   if ( !$row ) break;
   
?>
<table cellspacing="0" cellpadding="0" width="100%" border="0"><tr><td bgcolor="#A6A090"><!--baltas krastas-->
<table width="100%" cellspacing="1" cellpadding="1" border="0">
<tr>
	<td rowspan="3" bgcolor="#2C2B2A" width="80" align="center">
	<?
	  echo "	<a href=\"hirez_browse.php?iid=".$row["id"]."\"><img src=\"/hirez/thumbs/".$row["thumbnail"]."\" border=0 alt=\"".$row["id"]."\"></a>";
	?></td>
	<td bgcolor="#2C2B2A" width="100%">
	
	<?
	  echo "	<a href=\"mailto:".$row["email"]."\" class=\"vardas\">".$row["author"]."</a></td>";
	?>
	
	<td colspan="2" align="right" bgcolor="#2C2B2A" width="2%">
	<?
	  echo "	<span class=\"text\">".$row["laikas"]."</span>";
	?>
	</td>
</tr>
<tr>
	<td bgcolor="#2C2B2A">
	<?
	  echo "	<span class=\"pavadinimas\">".$row["name"]."</span>";
	?>  
	</td>
	<td bgcolor="#2C2B2A" align="right">
	<?
	  // varom uzklausa kiek kometaru yra siam paveikslui
	  $idas = $row["id"];
	  $kom = mysql_query("select * from hirez_talk where hid=$idas order by id desc");
	  $kk = 0;
	  if ($kom) { $kk = mysql_num_rows( $kom ); }
	  echo "	<span class=\"text\">".$kk."&nbsp;komnt.</span></td>";
	  mysql_free_result( $kom );
	?>  
	<td bgcolor="#2C2B2A" align="right">
	<?
	  $size = $row["size"];
	  $size = ceil( $size / 1024);
	  echo "	<span class=\"text\">".$size."kb</span></td>";
	?>  
</tr>
<tr><td colspan="3" bgcolor="#2C2B2A">
	<?
	  echo "	<span class=\"text\">".StripSlashes($row["descr"])."</span>";
	?>	  
</td></tr>
</table>
</td></tr></table>
<br>

<? //foro galas;
;}

?>

<?

 if ( $atgal == 1 ) { echo "<a href=\"/i_galerija.php\">atgal</a> [ "; }
    else { echo "<a href=\"hirez.php?page=".$atgal."\">atgal</a> [ "; }
    
	echo "<a href=\"/i_galerija.php\">1</a> / ";
	
    for ( $i = 2; $i<$i_pages; $i++ ) { 
	if ($i==$page) {echo $i." / ";}
	else { echo "<a href=\"hirez.php?page=".$i."\">$i</a> / ";}
    } //for
    if ($page==$i_pages) { echo $page." ] pirmyn";}
    else { echo "<a href=\"hirez.php?page=".$i_pages."\">$i_pages</a> ] <a href=\"hirez.php?page=".$pirmyn."\">pirmyn</a>";}
?>