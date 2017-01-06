<?PHP
//--Kenny 2014.7.16 EDM InsertData
//--InsertData.php
date_default_timezone_set('Asia/Taipei');
//include "./lib/connect_mysql.php";
include "./lib/connect_mysql_local.php";
include "login.php";

$Euser = $_SESSION['EDM_User'];
$Sender = $_POST["Sender"];
$SenderMail = $_POST["SenderMail"];
$Title = $_POST["Title"];
$Content_Text = $_POST["Content_Text"];
$sql = $_POST["sql"];
$Mail[1] = $_POST["Mail1"];
$Mail[2] = $_POST["Mail2"];
$Mail[3] = $_POST["Mail3"];
$TotMail = $_POST["TotMail"];

if ($TotMail <= 0 & $Mail[1] == "" & $Mail[2] == "" & $Mail[3] == "" ){
	echo "<script>alert('注意!!寄送郵件為0');</script>";
	echo '<html><head><meta http-equiv="refresh" content="0;URL=EDM_List.php"><title>Redirect</title></head><body  bgcolor="#C5E4E9" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"></body></html>';				
	exit();
}

//取得最大的寄件行動流水號
$sql_Max = "select Max(ACMNo) from EDM.ActionMail";
$result = mysqli_query($Conn_local,$sql_Max);
List($ACMNo_Max)=mysqli_fetch_row($result);
if ($ACMNo_Max > 0 && !empty($ACMNo_Max)){
	$ACMNo = $ACMNo_Max + 1;
}else{
	$ACMNo = 1;
}

$InsertData = "insert into EDM.ActionMail (ACMNo,OwnUser,SuccessMail,ErrorMail,WaitMail,Status,Create_date,html,FormMail,Tital,SendUser,AddFile)values";
$InsertData .= "($ACMNo,'".$_SESSION['EDM_User']."',0,0,0,'w',now(),'$Content_Text','$SenderMail','$Title','$Sender','".$_POST['AddFile']."')";
$result = mysqli_query($Conn_local,$InsertData);

$result_cooz = mysqli_query($Conn_local,$sql);
$i = 0;
$j = 0;
while($row = mysqli_fetch_array($result_cooz)){
	$sql_mail_check = "select count(*) from EDM.ErrorMail where EMail = '".$row["email_address"]."'";
	$result_check = mysqli_query($Conn_local,$sql_mail_check);
	List($CheckCount)=mysqli_fetch_row($result_check);

	if ($CheckCount == 0){
		$insert_Mail = "insert into SendMail (EMail,Status,tag,ActionNo,UserName,gift_code)values";
        $pos = strpos($sql, "gift_code");
        $gift_code="";
        if ($pos !== false)
        {
            $gift_code= $row["gift_code"];
        }
		$insert_Mail .= "('".$row["email_address"]."','a',0,'$ACMNo','','$gift_code')";
		$result_Mail = mysqli_query($Conn_local,$insert_Mail);
		$i++;
	}
	$j++;
}
for ($x=0;$x <= 3;$x++){
	if (!empty($Mail[$x])){
		$insert_Mail = "insert into SendMail (EMail,Status,tag,ActionNo,UserName,gift_code)values";
		$insert_Mail .= "('".$Mail[$x]."','a','','$ACMNo','TestMail','TESTGIFTCODEAAAAA')";
		$result = mysqli_query($Conn_local,$insert_Mail);
		$i++;
		$j++;
	}
}
$Tot_ErrorMail = $j - $i;
$Update_Status = "Update EDM.SendMail set Status = 'w' where ActionNo = '$ACMNo'";
$result_Status = mysqli_query($Conn_local,$Update_Status);
$Update_ACMNo = "Update EDM.ActionMail set WaitMail = '$i' where ACMNo = '$ACMNo'";
$result_ACMNo = mysqli_query($Conn_local,$Update_ACMNo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EDM System</title>
</head>

<body>
<p><img src="img/logo.gif" width="304" height="42" /></p>
<p><b>EDM System</b></p>
<p>完成工作設定</p>
<table width="240" border="0">
  <tr>
    <td width="80"><div align="center"><strong>原始總信件量</strong></div></td>
    <td width="80"><div align="center"><strong>實際總信件量</strong></div></td>
    <td width="80"><div align="center"><strong>無效E-Mail</strong></div></td>
  </tr>
  <tr>
    <td><div align="center"><?PHP echo $j;?></div></td>
    <td><div align="center"><?PHP echo $i; ?></div></td>
    <td><div align="center"><?PHP echo $Tot_ErrorMail; ?></div></td>
  </tr>
</table>
<p><a href="EDM_List.php">回管理頁面</a></p>
</body>
</html>

