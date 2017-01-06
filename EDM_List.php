<?PHP
//--Kenny 2013.1.29 EDM 1
//--EDM.php
//include "./lib/connect_mysql.php";
include "./lib/connect_mysql_local.php";
include "login.php";
if($_SESSION['EDM_User'] == "kenny"){
	$sql_count = "SELECT count(*) FROM EDM.actionmail ";
	$sql = "SELECT ACMNo,SuccessMail,ErrorMail,WaitMail,Status,Create_date FROM EDM.actionmail Order by Create_date";
}else{
	$sql_count = "SELECT count(*) FROM EDM.actionmail where OwnUser='".$_SESSION['EDM_User']."'";
	$sql = "SELECT ACMNo,SuccessMail,ErrorMail,WaitMail,Status,Create_date FROM EDM.actionmail where OwnUser='".$_SESSION['EDM_User']."' Order by Create_date";
}
$result = mysqli_query($Conn_local,$sql_count);
List($Action_count)=mysqli_fetch_row($result);

//變更寄送狀態
if (!empty($_GET["Action"]) && !empty($_GET["ACMNo"])){
	$UpdateAction = "Update EDM.actionmail Set Status='".$_GET["Action"]."' where ACMNo='".$_GET["ACMNo"]."' and OwnUser='".$_SESSION['EDM_User']."'";
	$result_UPA = mysqli_query($Conn_local,$UpdateAction);
}

if ($Action_count > 0){
	$result = mysqli_query($Conn_local,$sql);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Basic Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome.min.css">
<title>EDM System</title>
</head>

<body>
<p><img src="img/logo.gif" width="304" height="42" /></p>
<p><b>EDM System</b></p>
<p>工作排程</p>
<table width="700" border="0">
  <tr>
    <td width="30"><div align="center"></div></td>
    <td width="80"><div align="center"><strong>成功發送</strong></div></td>
    <td width="80"><div align="center"><strong>等待發送</strong></div></td>
    <td width="80"><div align="center"><strong>發送失敗</strong></div></td>
    <td width="80"><div align="center"><strong>總數量</strong></div></td>
    <td width="150"><div align="center"><strong>開始時間</strong></div></td>
    <td width="200"><div align="center"><strong>狀態</strong></div></td>
  </tr>
<?PHP
if ($Action_count > 0){
	$i = 1;
	while($row = mysqli_fetch_array($result)){
		$total_mail = $row['SuccessMail'] + $row['ErrorMail'] + $row['WaitMail'];
		if ($row['Status'] == "w"){
			$AStatus = '等待工作中---切換(<a href="EDM_List.php?Action=s&ACMNo='.$row['ACMNo'].'">停止</a>)';
		}elseif($row['Status'] == "a"){
			$AStatus = '工作進行中---切換(<a href="EDM_List.php?Action=s&ACMNo='.$row['ACMNo'].'">停止</a>)';
		}elseif($row['Status'] == "s"){
			$AStatus = '停止發送---切換(<a href="EDM_List.php?Action=a&ACMNo='.$row['ACMNo'].'">發送</a>)';
		}else{
			$AStatus = "完成";
		}
?>
  <tr>
    <td><div align="center"><?PHP echo $i; ?></div></td>
    <td><div align="center"><?PHP echo $row['SuccessMail'];?></div></td>
    <td><div align="center"><?PHP echo $row['WaitMail'];?></div></td>
    <td><div align="center"><?PHP echo $row['ErrorMail'];?></div></td>
    <td><div align="center"><?PHP echo $total_mail; ?></div></td>
    <td><div align="center"><?PHP echo $row['Create_date'];?></div></td>
    <td><div align="center"><?PHP echo $AStatus; ?></div></td>
  </tr>
<?PHP
		$i++;
	}
}else{
?>
  <tr>
    <td><div align="center">1</div></td>
    <td><div align="center">-</div></td>
    <td><div align="center">-</div></td>
    <td><div align="center">-</div></td>
    <td><div align="center">-</div></td>
    <td><div align="center">-</div></td>
    <td><div align="center">No Data</div></td>
  </tr>
<?PHP
}
?>
</table>
<p><a href="EDM.php">新增EDM發送工作</a></p>
</body>
</html>
