<?PHP
error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
//--Kenny 2014.7.17 EDM SendMail(Status = w)
//SendMail_Action.php
date_default_timezone_set('Asia/Taipei');
include "/var/www/html/EDM/lib/connect_mysql_local.php";
require_once("/var/www/html/EDM/phpmailer/PHPMailerAutoload.php");
ini_set('max_execution_time', 300000);
ini_set( "memory_limit", "128M" );
//設定每次發送數量
$MailLimit = 300;

//上次執行時間紀錄
$Action_log = "/var/www/html/EDM/logs/SystemAction.log";
$Sys_log = fopen("$Action_log",'w');
$NowDate = date("Y-m-d H:i:s");
fwrite($Sys_log, "Before Action Time".$NowDate);
fclose($Sys_log);

//確認是否有未發出的信件
$sqlMail_Check ="select count(*) from EDM.actionmail A, EDM.sendmail B where A.ACMNo = B.ActionNo and B.Status = 'w' "; 
$sqlMail_Check .="and B.tag = '0' and ( A.Status = 'w' or A.Status = 'a' ) order by A.ACMNo, B.MailNo";
$result_check = mysqli_query($Conn_local,$sqlMail_Check);
List($CheckCount)=mysqli_fetch_row($result_check);
//echo $sqlMail_Check."<br>";
echo "TotalMail : $CheckCount <br>";
if ($CheckCount > 0){		
	//---Send Mail
	$mail = new PHPMailer();
	//設定使用SMTP發送
	$mail->IsSMTP();
	$mail->SMTPAuth =false;
	//---coozmail.com.tw
	//$mail->Host = "smail.longeplay.com.tw";
    //$mail->Host = "edm.cooz.com.tw";
    $mail->Host = "edm.cooz.com.tw";
    
	$mail->Port = 25;
	//$mail->Username = "CoozEDM@edm.cooz.com.tw";  //LongE_SDKSite@smail.longeplay.com.tw", "54700022
	//$mail->Password = "";
	$mail->CharSet="utf-8";
	$mail->Encoding = "base64";
	$mail->IsHTML(true);
	$mail->WordWrap = 50;
	
	$sqlMail ="select A.ACMNo, A.html, A.FormMail, A.Tital, A.SendUser, A.AddFile, B.MailNo, B.EMail, B.UserName, B.Status, B.gift_code "; 
	$sqlMail .="from EDM.actionmail A, EDM.sendmail B where A.ACMNo = B.ActionNo and B.Status = 'w' "; 
	$sqlMail .="and B.tag = '0' and ( A.Status = 'w' or A.Status = 'a' ) order by A.ACMNo, B.MailNo limit 0, $MailLimit";
	$result_MailList = mysqli_query($Conn_local,$sqlMail);
    //echo $sqlMail."<br>";
	$ACMNo = "";
	$i = 1;
	while($row = mysqli_fetch_array($result_MailList)){
		//變更寄件工作狀態
		if ($ACMNo != $row["ACMNo"]){
			$ACMNo = $row["ACMNo"];
			$Update_ACStatus = "Update EDM.actionmail Set Status = 'a' where ACMNo = '".$row["ACMNo"]."'";
			$result_ACStatus = mysqli_query($Conn_local,$Update_ACStatus);
            //echo $Update_ACStatus."<br>";
			$ActionNo[$i] = $ACMNo;
			$i++;
		}
		//確認工作是否有重複
		$sql_check = "Select tag, Status from EDM.sendmail where MailNo = '".$row["MailNo"]."' and EMail = '".$row["EMail"]."' and UserName = '".$row["UserName"]."'";
		$result = mysqli_query($Conn_local,$sql_check);
        //echo "確認工作是否有重複".$sql_check."<br>";
		List($Mail_tag, $Mail_Status)=mysqli_fetch_row($result);
		echo "$Mail_tag - $Mail_Status (".$row["ACMNo"].") \n";
		if ($Mail_Status == "w" && $Mail_tag == "0"){
			$Update_Tag = "Update EDM.sendmail Set tag='1' where MailNo='".$row["ACMNo"]."' and EMail = '".$row["EMail"]."' and UserName = '".$row["UserName"]."'";
			//echo $Update_Tag;
			$result_UPTag = mysqli_query($Conn_local,$Update_Tag);
			//寄件人名稱
			$mail->FromName = $row["SendUser"];
			//寄件人Email
			$mail->From = $row["FormMail"];
			$mail->SetFrom($row["FormMail"], $row["SendUser"]);
			$mail->AddReplyTo($row["FormMail"], $row["SendUser"]);
			//傳送附檔
			if(!empty($row["AddFile"])){
				$AddfileUrl = "AddFile/".$row["AddFile"];
				$mail->AddAttachment($AddfileUrl);
			}
			//清除寄信清單
			$mail->ClearAddresses();
			$user_name = $row["UserName"];
			$User_Email = $row["EMail"];
			$mail->AddAddress($User_Email,$user_name);
			$mail->Subject=$row["Tital"];
            $gift_code="";
            $unsubmessage="<p><a href='http://edm.cooz.com.tw/EDM/cancelsubscribe.php?acmno=$ACMNo&mail=$User_Email'>我不願意再收到活動訊息郵件/ unsubscribe</a></p>";
            $mailBody=$row["html"];
            if (isset($row["gift_code"]))
            {
                $gift_code= $row["gift_code"];
                $mailBody = str_replace("TheCakeIsALie",$gift_code, $mailBody, $count);
            }
            
            
            
			$mail->Body=$mailBody.$unsubmessage; 
			if(!$mail->Send()){
			//SendMaill Error Update DB
				$Update_Status = "Update EDM.sendmail Set Status = 'e1', tag = '0' where ActionNO = '".$row["ACMNo"]."' and EMail = '".$row["EMail"]."' and UserName = '".$row["UserName"]."'";
			}else{
			//SendMail Success Update DB
				$Update_Status = "Update EDM.sendmail Set Status = 's' where ActionNO = '".$row["ACMNo"]."' and EMail = '".$row["EMail"]."' and UserName = '".$row["UserName"]."'";
			}
            echo $Update_Status;
			$result_UStatus = mysqli_query($Conn_local,$Update_Status);
		}
	}
	$j = 1;
	if ($i > 0){
		while(!empty($ActionNo[$j])){
			//變更工作中信件完成與失敗數量
			$sql_action = "Select status, count(Status) as Scount From EDM.sendmail where ActionNO = '$ActionNo[$j]' group by Status";
			$result_Action = mysqli_query($Conn_local,$sql_action);
			$E_Tot=0;
			$E1_Tot=0;
			$E2_Tot=0;
			$E3_Tot=0;
			$W_Tot=0;
			$S_Tot=0;
			$TOT=0;
			while($row = mysqli_fetch_array($result_Action)){
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
				$Update_actionmail = "Update EDM.actionmail Set Status = 'f', SuccessMail = '$S_Tot', ErrorMail = '$E_Tot', WaitMail = '$W_Tot' where ACMNo = '".$ActionNo[$j]."'";
			}else{
				$Update_actionmail = "Update EDM.actionmail Set SuccessMail = '$S_Tot', ErrorMail = '$E_Tot', WaitMail = '$W_Tot' where ACMNo = '".$ActionNo[$j]."'";
			}
			//echo "$Update_actionmail <br>";
			$result_UPactionmail = mysqli_query($Conn_local,$Update_actionmail);
			$j++;
		}
	}

}
?>