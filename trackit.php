<?php


include "./lib/connect_mysql_local.php";

if (!empty($_GET['mail']) && !empty($_GET['acmno'])){
        
$_email = $_GET['mail'];
$_acmno = $_GET['acmno'];
 
    
    $sql = "update sendmail set status='o' where ActionNO=$_acmno and Email='$_email'";
    //echo $sql;
    mysqli_query($Conn_local,$sql);     
 
}
else
{
   
 die();
    
}


header('Content-Type: image');
    
?>