<?
// hirezpiesiniubuferio browsinimas su thumbnailais

/*	include("include/config.inc");
    include("include/code.inc");

    connect2db();
 */   
    $result = mysql_query("select DISTINCT author, count(author) from hirez group by author");

?>


<table cellspacing="0" cellpadding="0"  border="0"><tr><td class="border-out"><!--baltas krastas-->
<table width="100%" cellspacing="1" border="0">
<tr>
	<td class="table-dark"><b>Autorius</span></b></td>
	<td class="table-dark"><b>kiek</b></td>
</tr>

<? //didelis foras kiekvienai lentelei
   
   while ( $row = mysql_fetch_array( $result )) {
   



// tm 000809 + htmlspecialchars
echo "<tr>\n";
echo "	<td class=\"table-dark\"><a href=\"/scripts/hirez_name.php?vardas=".htmlspecialchars($row[0])."\">$row[0]</td>\n";
echo "	<td class=\"table-dark\" align=\"right\"><span class=\"textj\">$row[1]</span></td>\n";
echo "</tr>\n\n";

//while'o galas
}
?>

</table>
</td></tr></table>


