<?
// hirezpiesiniu galerijos browsinimas pagal autoriu
    include("include/config.inc");
    include("include/code.inc");
    
    connect2db();
    
	if (!$vardas) {exit;}

    
// tm 000809 + stripslashes($vardas)
    $vardas = stripslashes($vardas);
    $result = mysql_query("select * from hirez where author='$vardas' order by id desc");
    
    
    
    $kiekis = mysql_num_rows( $result );
    
    if (!isset($iid)) { $iid = $kiekis;}
    
    //reikia susirasti atgal ir pirmyn id
    $atgal=0;
    for($i=0; $i!=$kiekis; $i++){
        $row = mysql_fetch_array( $result );
        if ($row["id"] == $iid) break;
	$atgal  = $row["id"];
    }
    $info = $row;
    $pirmyn = 0;
    if ($i<$kiekis) {
	$row = mysql_fetch_array( $result );
        $pirmyn = $row["id"];
    }
    
    mysql_free_result( $result );
?>

<!-- 
kopijavimo ritë pas mrfrost'à (c) 1999 <salna@ktl.mii.lt>
ðitas failas priklauso art.scene projektui http://artscene.fluxus.lt
-->

<HTML>
<HEAD>
<?	echo "<TITLE>".$info["name"]." :: galerija  [art.scene]</TITLE>";
?>
	<META http-equiv="Content-Type" content="text/html; charset=windows-1257">
	<meta name="Description" content="">
	<meta name="Keywords" content="artscene art.scene art demo hirez pieðiniai">
	<link href="/artscene.css" media="screen" rel="STYLESHEET" type="text/css">
</HEAD>
<BODY bgcolor="#000000" text="#C5C0B7" link="#ADBCCD" vlink="#B39595">
<span class="iheader">
<? echo $info["name"]?></span> <? echo "<a href='hirez_name.php3?vardas=". htmlspecialchars($vardas) ."'>$vardas</a>" ?><br>
<span class="ilink"><a href="http://art.scene.lt" class="ilink">art.scene</a> &gt;&gt; <a href="/i_galerija.php" class="ilink">senoji pieðiniø galerija</a></span><br><br>

    
<?
// tm 000809 + htmlspecialchars()
    if ( $atgal ) { echo "&lt; <a class=\"navig\" href=\"hirez_name_browse.php3?iid=".$atgal."&vardas=".htmlspecialchars($vardas)."\">atgal</a> | "; }
    else { echo "&lt; atgal | ";}
    if ( $pirmyn ) { echo "<a class=\"navig\" href=\"hirez_name_browse.php3?iid=".$pirmyn."&vardas=".htmlspecialchars($vardas)."\">pirmyn</a> &gt; | ";}
    else { echo "pirmyn &gt; | ";}
    
?>
<a href="/i_galerija.html">galerija</a><br>
<br>


<center>
<?
echo "<img src=\"/hirez/".$info["filename"]."\" border=0 alt=\"".$info["size"]." baitai\">";
?>
</center>
<br>

<table cellspacing="0" cellpadding="0" width="100%" border="0"><tr><td bgcolor="#A6A090"><!--baltas krastas-->
<table width="100%" cellspacing="1" border="0">
<tr>
	<td bgcolor="#2C2B2A">
	<?
	$pimail = $info["email"];
	echo "<a href=\"mailto:".$info["email"]."\" class=\"vardas\">".$info["author"]."</a>";
	?>
	</td>
	<td bgcolor="#2C2B2A"><span class="pavadinimas">"<?
	echo $info["name"];
	?>"</span></td>
	<td align="right" bgcolor="#2C2B2A"><span class="text"><?
	echo $info["laikas"];
	?></span></td>
</tr>
<tr><td colspan="3" bgcolor="#2C2B2A"><span class="textj"><?
echo StripSlashes($info["descr"]);
?></span></td></tr>
</table>
</td></tr></table>

<br>



<br>
Þiûrovø komentarai:

<? //imsime atsiliepimus is kitos lenteles
   $i=0;
   $result = mysql_query ("select * from hirez_talk where hid=$iid order by laikas, id");
   while ($row = mysql_fetch_array($result) ) {
   $i++;
?>
<table cellspacing="0" cellpadding="0" width="100%" border="0"><tr><td bgcolor="#A6A090"><!--baltas krastas-->
<table width="100%" cellspacing="1" border="0">
<tr>
	<td bgcolor="#2C2B2A">
	<?
	echo "<a href=\"mailto:".$row["email"]."\" class=\"vardas\">".$row["author"]."</a></td>";
	?>
	<td align="right" bgcolor="#2C2B2A"><span class="text">
	<?
	echo $row["laikas"];
	?></span></td>
</tr>
<tr><td colspan="2" bgcolor="#2C2B2A"><span class="text">
<?
    echo StripSlashes($row["message"]);
?>
</span></td></tr>
</table>
</td></tr></table>
<br>
<?
;}//while
 if (!$i) {echo "Þiûrovø atsiliepimø dar nëra <br><br>";}
?>
Tavo komentaras:
<table cellspacing="0" cellpadding="0" border="0"><tr><td bgcolor="#A6A090"><!--baltas krastas-->
<table width="100%" cellspacing="1" border="0"><tr><td  bgcolor="#2C2B2A">
  <form method=POST action="submit_hirez_talk.php3" enctype="multipart/form-data">
  <?        
      echo "<input type=hidden name=iid value=$iid>";
	  echo "<input type=hidden name=pname value=\"".$info["name"]."\">";
	  echo "<input type=hidden name=pmail value=\"".$pimail."\">";
  ?>
<table>
<tr>
	<td align="RIGHT"><span class="text">*vardas/nikas:</span><br></td>
	<td><input type=text name=realname size=50></td>
</tr>
<tr>
	<td align="RIGHT"><span class="text">emailas:</span></td>
	<td><input type=text name=email size=50></td>
</tr>

</table>

  
      
     <span class="text"> *komentaras:<br>
      <div align="right"><textarea name=comment COLS=60 ROWS=6></textarea><br><br></div>
	  	  
      <div align="right"> <input type=submit value="siøsti">  <input type=reset value="iðtrinti"></div>
</span>
    </form>
</td></tr></table>
</td></tr></table>
<br>
<?
if ( $atgal ) { echo "<a href=\"hirez_name_browse.php3?iid=".$atgal."&vardas=$vardas\">atgal</a> | "; }
    else { echo "atgal | ";}
    if ( $pirmyn ) { echo "<a href=\"hirez_name_browse.php3?iid=".$pirmyn."&vardas=$vardas\">pirmyn</a> | ";}
    else { echo "pirmyn | ";}
    
?><a href="/i_galerija.html">galerija</a> 
<br>
<br>


</BODY>
</HTML>
