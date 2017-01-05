<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cooz EDM</title>
</head>
<body>
<?PHP
//--Kenny 2013.1.29 EDM 2
//--SendMail2.php
date_default_timezone_set('Asia/Taipei');
require_once("phpmailer/class.phpmailer.php");
include "./lib/connect_mysql.php";
include "login.php";
ini_set('max_execution_time', 300000);
ini_set( "memory_limit", "128M" );
$Euser = $_SESSION['EDM_User'];
$Sneder = $_POST["Sneder"];
$SnederMail = $_POST["SnederMail"];
$Title = $_POST["Title"];
$AddFile = "AddFile/".$_POST["AddFile"];
$Content_Text = $_POST["Content_Text"];
$sql = $_POST["sql"];
$Mail[1] = $_POST["Mail1"];
$Mail[2] = $_POST["Mail2"];
$Mail[3] = $_POST["Mail3"];
$printstate = $_POST["printstate"];
$TotMail = $_POST["TotMail"];
$NowDate = date("YmdHis");
$Log_M = date("Ym");
$NowDate2 = date("Y-m-d H:i:s");
$log_sys = "logs/System_".$Log_M.".log";
$log_file = "logs/".$Euser.$NowDate.".log";
$Resend_file = "logs/".$Euser.$NowDate."_mail.log";
//開啟Log File
$Sys_log = fopen("$log_sys",'a+');
fwrite($Sys_log, $NowDate2."-User:".$Euser."-Send-EDM-共".$TotMail."封 \n");
$into_log = fopen("$log_file",'w');
fwrite($into_log, $NowDate2."-EDM-共".$TotMail."封 \n");
//重送Mail List
$Resend_log = fopen("$Resend_file",'w');
//---Send Mail
$mail = new PHPMailer();
//設定使用SMTP發送
$mail->IsSMTP();
//寄件人Email
$mail->From = $SnederMail;
//寄件人名稱
$mail->FromName = $Sneder;
$mail->SMTPAuth = true;
//---coozmail.com.tw
$mail->Host = "coozmail.cooz.com.tw";
$mail->Port = 25;
$mail->Username = "coozdm";
$mail->Password = "25055109";
//---gmail
//$mail->SMTPSecure = "ssl";    
//$mail->Host = "smtp.gmail.com";
//$mail->Port = 465;
//$mail->Username = "cooz_service@cooz.com.tw";
//$mail->Password = "25055109";//---
//---
$mail->SetFrom($SnederMail, $Sneder);
$mail->AddReplyTo($SnederMail, $Sneder);
$mail->CharSet="utf-8";
$mail->Encoding = "base64";
$mail->IsHTML(true);
$mail->WordWrap = 50;
//傳送附檔
if(!empty($_POST["AddFile"])){
	$mail->AddAttachment($AddFile);
}
$mail->Subject=$Title;
$mail->Body=$Content_Text;
$result = mysql_query($sql,$Conn);
$i=0;
$j=0;
$x=0;
while($row = mysql_fetch_array($result)){
	$mail->ClearAddresses();//清除寄信清單
 	//$mail->ClearAttachments();
	$user_name = @$row[email_address];
	$User_Email = @$row[user_name];
	$mail->AddAddress($user_name,$User_Email);
	if(!$mail->Send()){
		$j++;
		if ($printstate == "Y"){
			echo $j.".Error SendMail-".$user_name."--".$User_Email."(".$mail->ErrorInfo.")<br>";
		}
		fwrite($into_log, $j.".Error SendMail-".$user_name."--".$User_Email."(".$mail->ErrorInfo.") \n");
		if (preg_match("/Could not authenticate/i", $mail->ErrorInfo)) {
			//過濾 有Could not authenticate不重寄
			sleep(5);
		}elseif(preg_match("/530/i", $mail->ErrorInfo)){
			//過濾 有530不重寄
			sleep(5);
		}elseif(preg_match("/Data not accepted/i", $mail->ErrorInfo)){
			//不重寄
			sleep(30);
		}else{
			//回收寄件失敗
			fwrite($Resend_log, $j.":".$user_name.":".$User_Email." \n");
		}
	}else{
		$i++;
		if ($printstate == "Y"){
			echo $i.".Success SendMail-".$user_name."--".$User_Email." <br>";
		}
		fwrite($into_log, $i.".Success SendMail-".$user_name."--".$User_Email." \n");
	}
	sleep(1);
	if ($x == 5){
		sleep(5);
		$x = 0;
	}else{
		$x++;
	}
}

//Close重寄名單
fclose($Resend_log);

if (!empty($Resend_log)){
	//重寄開始
	$fresend = file ("$Resend_file"); 
	fwrite($into_log, "Resend Mail Begin------ \n");
	$x=1;
	$a=1;
	$b=1;
	while(list($line_num, $line) = each($fresend)){
		$Minfo = explode(":", $line);
		$mail->ClearAddresses();//清除寄信清單
		$user_name = @$Minfo[1];
		$User_Email = @$Minfo[2];
		$mail->AddAddress($user_name,$User_Email);
		if(!$mail->Send()){
			$j++;
			$a++;
			if ($printstate == "Y"){
				echo $j."-".$a.".Error Re-SendMail-".$user_name."--".$User_Email."(".$mail->ErrorInfo.")<br>";
			}
			fwrite($into_log, $j."-".$a.".Error Re-SendMail-".$user_name."--".$User_Email."(".$mail->ErrorInfo.") \n");
		}else{
			$i++;
			$b++;
			if ($printstate == "Y"){
				echo $i."-".$b.".Success Re-SendMail-".$user_name."--".$User_Email." <br>";
			}
			fwrite($into_log, $i."-".$b.".Success Re-SendMail-".$user_name."--".$User_Email." \n");
		}
		//寄一封休息1秒		
		sleep(1);
		if ($x == 5){
			sleep(5);
			$x = 0;
		}else{
			$x++;
		}		
	}	
}

for ($x=0;$x <= 3;$x++){
	if (!empty($Mail[$x])){
		$mail->ClearAddresses();//清除寄信清單
		$mail->AddAddress($Mail[$x],$Mail[$x]);
		if(!$mail->Send()){
			$j++;
			if ($printstate == "Y"){				
				echo $j.".Error SendMail-".$Mail[$x]."--".$Mail[$x]."(".$mail->ErrorInfo.") <br>";
			}
			fwrite($into_log, $j.".Error SendMail-".$Mail[$x]."--".$Mail[$x]."(".$mail->ErrorInfo.") \n");
		}else{
			$i++;
			if ($printstate == "Y"){
				echo $i.".Success SendMail-".$Mail[$x]."--".$Mail[$x]." <br>";
			}
			fwrite($into_log, $i.".Success SendMail-".$Mail[$x]."--".$Mail[$x]." \n");
		}
	}
}
fwrite($into_log, "Success SendMail Total : ".$i." \n");
fwrite($into_log, "Error SendMail Total : ".$j." \n");
fclose($into_log);
fwrite($Sys_log, "Success SendMail Total : ".$i." \n");
fwrite($Sys_log, "Error SendMail Total : ".$j." \n");
fclose($Sys_log);
echo "Send Mail End<br>";
echo '<a href="'.$log_file.'" target="_blank" >Log_File</a><br>';
echo '<a href="EDM.php"><b>Back To EDM System</b></a>';
?>
</body>
</html>

