<?php
require_once("phpmailer/class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
//$mail->SMTPSecure = "ssl";      
$mail->Host = "coozmail.cooz.com.tw";
$mail->Port = 25; 
$mail->CharSet = "utf-8";
$mail->Encoding = "base64";
$mail->Username = "kenny_hsu";
$mail->Password = "29868873";

// 獺ンず甧砞﹚  
$mail->From = "kenny_hsu@coozmail.cooz.com.tw";
$mail->FromName = "╰参代刚";
$mail->Subject = "PHPMailer盚獺代刚夹肈";
$mail->Body = "硂琌代琌獺ン瓳!";
$mail->IsHTML(true);

// Μン
//$mail->AddAddress("chang_chin_hsu@yahoo.com.tw", "╰参硄獺");

// 陪ボ癟
if(!$mail->Send()) {     
echo "Mail error: " . $mail->ErrorInfo;     
}else {     
echo "Mail sent";     
} 
?>