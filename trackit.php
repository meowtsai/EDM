<?php


include "./lib/connect_mysql_local.php";

if (!empty($_GET['mail']) && !empty($_GET['acmno'])){
        
$_email = $_GET['mail'];
$_acmno = $_GET['acmno'];
 
    
    $sql = "update sendmail set status='o' where ActionNO=$_acmno and Email='$_email'";
    //echo $sql ."<br />";
    mysqli_query($Conn_local,$sql);     
    
    $Update_actionmail = "update actionmail set OpenedMail=(select count(*) from sendmail where status='o' and ActionNo=$_acmno) where ACMNo=$_acmno";
    //echo $Update_actionmail;
    mysqli_query($Conn_local,$Update_actionmail);     
 
}
else
{
   
 die();
    
}

header("Content-Type: image/jpeg"); // it will return image 
readfile("img/blank.gif");

    
?>