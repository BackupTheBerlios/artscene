<?
//cia sudetos funkcijos, kuriu prireiks ne viename faile

function connect2db() {
    global $interneka;


    mysql_pconnect(":/var/run/mysqld/mysqld.sock","artscene","password") or die("Unable to connect to SQL server: ".$php_errormsg);
    mysql_select_db("artscene") or die("Unable to select database: ".$php_errormsg);

    return 1;
}


?>
