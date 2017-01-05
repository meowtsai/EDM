<?php
//-----connect_mysql.inc-----
$DB_Name = "molibeegl";
$Conn=mysql_connect("61.67.213.200","4urkD4u4X4jd","ez78rwmqX38QELW7")or die("Could not connent to sql server.");
if (!mysql_select_db("$DB_Name",$Conn)){die("Problem opening database");}
?>