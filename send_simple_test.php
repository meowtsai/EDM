<?php

error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

require_once("phpmailer/class.phpmailer.php");
//---Send Mail
	$mail = new PHPMailer();
	//設定使用SMTP發送
	$mail->IsSMTP();
	$mail->SMTPAuth = false;
	//---coozmail.com.tw
	
///*
    $mail->Host = "27.147.16.103";
	$mail->Port = 25;
    //$mail->SMTPDebug = 2; 如果要更詳細的錯誤就要下這個指令
	//$mail->Username = "123@edm.cooz.com.tw";  //LongE_SDKSite@smail.longeplay.com.tw", "54700022
    //$mail->Password = "";
  
  //*/
/*
    $mail->Host = "smail.longeplay.com.tw";
    $mail->Port = 25;
    $mail->Username = "LongE_SDKSite@smail.longeplay.com.tw"; 
	$mail->Password = "54700022";  */

	$mail->CharSet="utf-8";
	$mail->Encoding = "base64";
	$mail->IsHTML(true);
	$mail->WordWrap = 50;

$FormMail="sophie_tsai@longeplay.com.tw";
	$SendUser="喵喵";

			$mail->FromName = $SendUser;
			//寄件人Email
			$mail->From = $FormMail;
			$mail->SetFrom($FormMail, $SendUser);
			$mail->AddReplyTo($FormMail,$SendUser);
			//清除寄信清單
			$mail->ClearAddresses();
			$user_name = "蔡小姐";
			$User_Email = "shihfan.tsai@gmail.com";
			$mail->AddAddress($User_Email,$user_name);
			$mail->Subject="一個簡單的測試";
			$mail->Body="<h3>Hello World</h3>";
			if ($mail->Send())
            {
                echo '成功!';
                
            }


  


?>