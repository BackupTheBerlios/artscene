<?
// hirezpiesiniubuferio browsinimas su thumbnailais
    include("include/config.inc");
    include("include/code.inc");

    connect2db();
    
    $result = mysql_query("select * from hirez order by id desc");
    
    
    $kiekis = mysql_num_rows( $result ) - 3;
    
    $i_pages = $kiekis / $th_kiek;
    
    $i_pages = floor( $i_pages ) + 1;
    
    if ($kiekis % $th_kiek) { $i_pages++ ;}
    
    	
    echo "[ 1 / ";
	
    for ( $i = 2; $i<$i_pages; $i++ ) {
		if ($i==$page) {echo $i." / ";}
		else { echo "<a href=\"/scripts/hirez.php3?page=".$i."\">$i</a> / ";}
    } //for
    echo "<a href=\"/scripts/hirez.php3?page=$i_pages\">$i_pages</a> ] <a href=\"/scripts/hirez.php3\">pirmyn</a>";
    
    
?>
<br>&nbsp;<br>


<? //didelis foras kiekvienai lentelei
   
   for ($tb=1; $tb<=3; $tb++) {
   $row = mysql_fetch_array( $result );
   if ( !$row ) break;
   
?>
<table cellspacing="0" cellpadding="0" border="0"><tr><td class="border-out"><!--baltas krastas-->
<table width="610" cellspacing="1" cellpadding="1" border="0">
<tr>
	<td rowspan="3" class="table-dark" width="80" align="center">
	<?
	  echo "	<a href=\"/scripts/hirez_browse.php3?iid=".$row["id"]."\"><img src=\"/hirez/thumbs/".$row["thumbnail"]."\" border=0 alt=\"".$row["id"]."\"></a>";
	?></td>
	<td  class="table-dark" width="100%">
	
	<?
	  echo "	<a href=\"mailto:".$row["email"]."\" class=\"nick\">".$row["author"]."</a></td>";
	?>
	
	<td colspan="2" align="right"  class="table-dark" width="2%">
	<?
	  echo "	<span class=\"text\">".$row["laikas"]."</span>";
	?>
	</td>
</tr>
<tr>
	<td  class="table-dark">
	<?
	  echo "	<span class=\"pavadinimas\">".$row["name"]."</span>";
	?>  
	</td>
	<td  class="table-dark" align="right">
	<?
	  // varom uzklausa kiek kometaru yra siam paveikslui
	  $idas = $row["id"];
	  $kom = mysql_query("select * from hirez_talk where hid=$idas order by id desc");
	  $kk = 0;
	  if ($kom) { $kk = mysql_num_rows( $kom ); }
	  echo "	<span class=\"text\">".$kk."&nbsp;komnt.</span></td>";
	  mysql_free_result( $kom );
	?>  
	<td  class="table-dark" align="right">
	<?
	  $size = $row["size"];
	  $size = ceil( $size / 1024);
	  echo "	<span class=\"text\">".$size."kb</span></td>";
	?>  
</tr>
<tr><td colspan="3"  class="table-dark">
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
