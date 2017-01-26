<?PHP
error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
//--Kenny 2014.7.17 EDM SendMail(Status = w)
//SendMail_Action.php
date_default_timezone_set('Asia/Taipei');
include "/var/www/html/EDM/lib/connect_mysql_local.php";

if (!empty($_GET["ACMNo"])){
	$UpdateAction = "Update EDM.actionmail Set Status='a' where ACMNo='".$_GET["ACMNo"]."'";
    //echo $UpdateAction;
	$result_UPA = mysqli_query($Conn_local,$UpdateAction);
}?>