<?PHP

error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

header('Content-Type: application/json');
//--Kenny 2013.1.29 EDM 1
//--EDM.php
//include "./lib/connect_mysql.php";
include "../lib/connect_mysql_local.php";
include "../login.php";
if($_SESSION['EDM_User'] == "meow"){
	$sql_count = "SELECT count(*) FROM EDM.actionmail ";
	$sql = "SELECT ACMNo,SuccessMail,ErrorMail,WaitMail,Status,Create_date,Tital FROM EDM.actionmail Order by Create_date";
}else{
	$sql_count = "SELECT count(*) FROM EDM.actionmail where OwnUser='".$_SESSION['EDM_User']."'";
	$sql = "SELECT ACMNo,SuccessMail,ErrorMail,WaitMail,Status,Create_date,Tital FROM EDM.actionmail where OwnUser='".$_SESSION['EDM_User']."' Order by Create_date";
}
$result = mysqli_query($Conn_local,$sql_count);
List($Action_count)=mysqli_fetch_row($result);


if ($Action_count > 0){
	$result = mysqli_query($Conn_local,$sql);
}


$rows_edmlist = array();
while($r = mysqli_fetch_assoc($result)) {
    $rows_edmlist[] = $r;
}
echo "{\"data\": " . json_encode($rows_edmlist) ."}";


?>