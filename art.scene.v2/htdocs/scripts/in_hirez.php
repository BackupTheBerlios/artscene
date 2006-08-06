<?
// hirezpiesiniubuferio browsinimas su thumbnailais
    include("include/config.inc");
    include("include/code.inc");
    
    connect2db();
    
    $result = mysql_query("select * from hirez_buf order by id desc limit 3");
    
    
    
// lenteliu epopeja

while (   $row = mysql_fetch_array( $result ) )
{
   
?>


<a href="/scripts/hirez_buf_browse.php?iid=<? echo $row["id"] ?>"><img src="/hirez_buf/thumbs/<? echo $row["thumbnail"] ?>" border=0 alt="<? echo $row["id"] ?>"></a><br>
<a href="mailto:<? echo $row["email"] ?>" class="vardas"><? echo $row["author"] ?></a><br>
<font size="-2"><? echo $row["laikas"] ?></font><br>
<br>



<?

} // while

?>