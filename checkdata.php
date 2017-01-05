<?PHP

error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

include "./lib/connect_mysql_local.php";
include "login.php";
$sql_TOT = "Select count(*) From EDMUser";

$result = mysqli_query($Conn_local,$sql_TOT);
List($Action_count)=mysqli_fetch_row($result);

echo $Action_count;
?>