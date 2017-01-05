<?PHP
//--Kenny 2014.7.17 EDM SendMail(Status = E)
//SendMail_Error.php
date_default_timezone_set('Asia/Taipei');
include "/var/www/html/EDM/lib/connect_mysql_local.php";
require_once("/var/www/html/EDM/phpmailer/class.phpmailer.php");
ini_set('max_execution_time', 300000);
ini_set( "memory_limit", "128M" );

//上次執行時間紀錄
$Action_log = "/var/www/html/EDM/logs/SystemActionError.log";
$Sys_log = fopen("$Action_log",'w');
$NowDate = date("Y-m-d H:i:s");
fwrite($Sys_log, "Before Action Time".$NowDate);
fclose($Sys_log);

//確認是否有發送失敗未超過2次的信件
$sqlMail_Check ="select count(*) from EDM.ActionMail A, EDM.SendMail B where A.ACMNo = B.ActionNo and ( B.Status = 'e1' or  B.Status = 'e2' )"; 
$sqlMail_Check .="and B.tag = '0' and ( A.Status = 'w' or A.Status = 'a' ) order by A.ACMNo, B.MailNo";
$result_check = mysql_query($sqlMail_Check,$Conn_local);
List($CheckCount)=mysql_fetch_row($result_check);
//echo "SQL : $sqlMail_Check <br>";
echo "TotalMail : $CheckCount <br>";
if ($CheckCount > 0){		
	//---Send Mail
	$mail = new PHPMailer();
	//設定使用SMTP發送
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	//---coozmail.com.tw
	$mail->Host = "coozmail.cooz.com.tw";
	$mail->Port = 25;
	$mail->Username = "coozdm";
	$mail->Password = "25055109";
	$mail->CharSet="utf-8";
	$mail->Encoding = "base64";
	$mail->IsHTML(true);
	$mail->WordWrap = 50;
	
	$sqlMail ="select A.ACMNo, A.html, A.FormMail, A.Tital, A.SendUser, A.AddFile, B.MailNo, B.EMail, B.UserName, B.Status "; 
	$sqlMail .="from EDM.ActionMail A, EDM.SendMail B where A.ACMNo = B.ActionNo and ( B.Status = 'e1' or  B.Status = 'e2' ) "; 
	$sqlMail .="and B.tag = '0' and ( A.Status = 'w' or A.Status = 'a' ) order by A.ACMNo, B.MailNo limit 0, 100";
	$result_MailList = mysql_query($sqlMail,$Conn_local);
	$ACMNo = "";
	$i = 1;
	while($row = mysql_fetch_array($result_MailList)){
		//變更寄件工作狀態
		if ($ACMNo != $row["ACMNo"]){
			$ACMNo = $row["ACMNo"];
			$Update_ACStatus = "Update EDM.ActionMail Set Status = 'a' where ACMNo = '".$row["ACMNo"]."'";
			$result_ACStatus = mysql_query($Update_ACStatus,$Conn_local);
			$ActionNo[$i] = $ACMNo;
			//echo "Update Action : $Update_ACStatus <br>";
			$i++;
		}
		//確認工作是否有重複
		$sql_check = "Select tag, Status from EDM.SendMail where MailNo = '".$row["MailNo"]."' and EMail = '".$row["EMail"]."' and UserName = '".$row["UserName"]."' and Status = '".$row["Status"]."'";
		$result_Mailcheck = mysql_query($sql_check,$Conn_local);
		List($Mail_tag, $Mail_Status)=mysql_fetch_row($result_Mailcheck);
		//echo "$sql_check<br>$Mail_tag -- $Mail_Status <br>";
		//exit;
		if (($Mail_Status == "e1" or $Mail_Status == "e2") && $Mail_tag == "0"){
			$Update_Tag = "Update EDM.SendMail Set tag='1' where '".$row["ACMNo"]."' and EMail = '".$row["EMail"]."' and UserName = '".$row["UserName"]."'";
			$result_UPTag = mysql_query($Update_Tag,$Conn_local);
			//echo "SendMail : $Update_Tag <br>";
			//寄件人名稱
			$mail->FromName = $row["SendUser"];
			//寄件人Email
			$mail->From = $row["FormMail"];
			$mail->SetFrom($row["FormMail"], $row["SendUser"]);
			$mail->AddReplyTo($row["FormMail"], $row["SendUser"]);
			//傳送附檔
			if(!empty($row["AddFile"])){
				$AddfileUrl = "/var/www/html/DEM/AddFile/".$row["AddFile"];
				$mail->AddAttachment($AddfileUrl);
			}
			//清除寄信清單
			$mail->ClearAddresses();
			$user_name = $row["UserName"];
			$User_Email = $row["EMail"];
			$mail->AddAddress($User_Email,$user_name);
			$mail->Subject=$row["Tital"];
			$mail->Body=$row["html"];
			if(!$mail->Send()){
			//SendMaill Error Update DB
				if($row["Status"] == "e1"){
					$error_status = "e2";
					$tag_status = "0";
				}else{
					$error_status = "e3";
					$Insert_ErrorMail = "insert into ErrorMail (EMail,Create_date)values('".$row["EMail"]."',now())";
					$result_IEM = mysql_query($Insert_ErrorMail,$Conn_local);
					$tag_status = "1";
				}
				$Update_Status = "Update EDM.SendMail Set Status = '$error_status', tag = '$tag_status' where ActionNO = '".$row["ACMNo"]."' and EMail = '".$row["EMail"]."' and UserName = '".$row["UserName"]."'";
			}else{
			//SendMail Success Update DB
				$Update_Status = "Update EDM.SendMail Set Status = 's' where ActionNO = '".$row["ACMNo"]."' and EMail = '".$row["EMail"]."' and UserName = '".$row["UserName"]."'";
			}
			$result_UStatus = mysql_query($Update_Status,$Conn_local);
		}
	}
	$j = 1;
	if ($i > 0){
		while(!empty($ActionNo[$j])){
			//變更工作中信件完成與失敗數量
			$sql_action = "Select status, count(Status) as Scount From EDM.SendMail where ActionNO = '$ActionNo[$j]' group by Status";
			$result_Action = mysql_query($sql_action,$Conn_local);
			$E_Tot=0;
			$E1_Tot=0;
			$E2_Tot=0;
			$E3_Tot=0;
			$W_Tot=0;
			$S_Tot=0;
			$TOT=0;
			while($row = mysql_fetch_array($result_Action)){
				if ($row["status"] == "w"){
					$W_Tot = $row["Scount"];
				}elseif($row["status"] == "s"){
					$S_Tot = $row["Scount"];
				}elseif($row["status"] == "e1"){
					$E1_Tot = $row["Scount"];
				}elseif($row["status"] == "e2"){
					$E2_Tot = $row["Scount"];
				}else{
					$E3_Tot = $row["Scount"];
				}
				$E_Tot = @$E1_Tot + @$E2_Tot + @$E3_Tot;
			}
			$TOT = $W_Tot + $E1_Tot + $E2_Tot;
			//echo "TOT : $TOT <br>";
			if ($TOT == 0){
				$Update_ActionMail = "Update EDM.ActionMail Set Status = 'f', SuccessMail = '$S_Tot', ErrorMail = '$E_Tot', WaitMail = '$W_Tot' where ACMNo = '".$ActionNo[$j]."'";
			}else{
				$Update_ActionMail = "Update EDM.ActionMail Set SuccessMail = '$S_Tot', ErrorMail = '$E_Tot', WaitMail = '$W_Tot' where ACMNo = '".$ActionNo[$j]."'";
			}
			$result_UPActionMail = mysql_query($Update_ActionMail,$Conn_local);
			$j++;
		}
	}

}
?>