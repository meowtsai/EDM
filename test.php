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

// �H�󤺮e�]�w  
$mail->From = "kenny_hsu@coozmail.cooz.com.tw";
$mail->FromName = "�t�δ���";
$mail->Subject = "PHPMailer�H�H���ռ��D";
$mail->Body = "�o�O�@�ʴ��O�H��@!";
$mail->IsHTML(true);

// ����H
//$mail->AddAddress("chang_chin_hsu@yahoo.com.tw", "�t�γq���H");

// ��ܰT��
if(!$mail->Send()) {     
echo "Mail error: " . $mail->ErrorInfo;     
}else {     
echo "Mail sent";     
} 
?>