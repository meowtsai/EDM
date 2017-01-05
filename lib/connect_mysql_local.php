<?php
//-----connect_mysql.inc-----
$DB_Name = "EDM";
$Conn_local=mysqli_connect("localhost","root","",$DB_Name)or die("Could not connent to EDM sql server.");
//if (!mysql_select_db("$DB_Name",$Conn_local)){die("Problem opening database");}
?>