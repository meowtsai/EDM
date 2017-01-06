<?PHP

error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
//--Kenny 2013.1.29 EDM 2
//--SendMail.php
//include "./lib/connect_mysql.php";
include "./lib/connect_mysql_local.php";
include "login.php";
$Sender = $_POST["Sender"];
$SenderMail = $_POST["SenderMail"];
$Title = $_POST["Title"];
$RadioContent = $_POST["RadioContent"];
$EMail_Command = $_POST["EMail_Command"];
$Mail1 = $_POST["Mail1"];
$Mail2 = $_POST["Mail2"];
$Mail3 = $_POST["Mail3"];

if ($RadioContent == 1){
	//內容為檔案
	if (!empty($_FILES["Content_File"]["name"])){
		$Content_File_name = $_FILES["Content_File"]["name"];
		$Content_File_Size = $_FILES["Content_File"]["size"];
		$Content_File_type = $_FILES["Content_File"]["type"];
		$Content_File_tmp_name = $_FILES["Content_File"]["tmp_name"];
		move_uploaded_file($Content_File_tmp_name,"./tmp/".$Content_File_name);
		$fp=fopen("./tmp/$Content_File_name","r");
		while(!feof($fp)){
			if (empty($getcontent)){
				$getcontent=fgets($fp);
			}else{
				$getcontent.=fgets($fp);
			}
		}
		fclose($fp);
  }
}else{
	//內容為文字框
	$getcontent = $_POST["Content_Text"];
}

//附加檔案
if (isset($_FILES["AddFile"]["name"])){
	$AddFile_name = $_FILES["AddFile"]["name"];
	$AddFile_Size = $_FILES["AddFile"]["size"];
	$AddFile_type = $_FILES["AddFile"]["type"];
	$AddFile_tmp_name = $_FILES["AddFile"]["tmp_name"];
	move_uploaded_file($AddFile_tmp_name,"./AddFile/".$AddFile_name);
}
if ($EMail_Command == 1){
	//全部的E-Mail
	$MailSql = "Select distinct email_address From t_user where email_address <> '' and SUBSTRING_INDEX(email_address, '@', -1) like '%.%' and email_address like '%@%'";
	$CountMail = "Select count(distinct email_address) From t_user where email_address <> '' and SUBSTRING_INDEX(email_address, '@', -1) like '%.%' and email_address like '%@%'";
	$SendMailTo = "全部會員";
}else if($EMail_Command == 2){
	//選擇E-Mail Domain Name
	$SendMailTo = "";
	if(isset($_POST["Mail_List"])) {
	  foreach($_POST["Mail_List"] as $key => $value){
	    $SendMailTo .=" [".$value."] ";
	    if (empty($sql_where)){
	    	$sql_where = " email_address like '%".$value."'";
	    }else{
	    	$sql_where .= " or email_address like '%".$value."'";
	    }
	  }
	  $MailSql = "Select distinct email_address From t_user where ( $sql_where ) and email_address <> '' and SUBSTRING_INDEX(email_address, '@', -1) like '%.%' and email_address like '%@%'";
		$CountMail = "Select count(*) From t_user where ( $sql_where ) and email_address <> '' and SUBSTRING_INDEX(email_address, '@', -1) like '%.%' and email_address like '%@%'";
	}
}else if($EMail_Command == 3){
	//自己決定Domain Name
	$DNSMail = $_POST["DNSMail"];
	$MailSql = "Select email_address From t_user where email_address like '%$DNSMail' and email_address <> '' and SUBSTRING_INDEX(email_address, '@', -1) like '%.%' and email_address like '%@%'";
	$CountMail = "Select count(distinct email_address) From t_user where email_address like '%$DNSMail' and email_address <> '' and SUBSTRING_INDEX(email_address, '@', -1) like '%.%' and email_address like '%@%'";
	$SendMailTo = "@".$DNSMail."會員";
}else if($EMail_Command == 4){
    //新增可以匯入有兩個欄位的excel，第一行是email,第二行是序號
    //UploadExcel
    if (!empty($_FILES["UploadExcel"]["name"])){
		$EXCEL_File_name = $_FILES["UploadExcel"]["name"];
		$EXCEL_File_Size = $_FILES["UploadExcel"]["size"];
		$EXCEL_File_type = $_FILES["UploadExcel"]["type"];
		$EXCEL_File_tmp_name = $_FILES["UploadExcel"]["tmp_name"];
        $pos = strpos($EXCEL_File_type, "excel");
        if ($pos == false)
        {
            die("不正確的檔案格式");
            
        }
        
		move_uploaded_file($EXCEL_File_tmp_name,"./Excel/".$EXCEL_File_name);
        
        
        
        //echo $EXCEL_File_name . "<br />";
        //echo $EXCEL_File_Size . "<br />";
        //echo $EXCEL_File_type . "<br />";
        //echo $EXCEL_File_tmp_name . "<br />";
        
        
        $file=fopen("./Excel/$EXCEL_File_name","r");
		$count = 0;    
        //echo $sql."<br />";// add this line
        while (($emapData = fgetcsv($file, 300, ",")) !== FALSE)
        {
            //print_r($emapData);
            //exit();
            
            //echo $count."<br />";// add this line

            if ($count!=0)
            {
                $user_email=$emapData[0];
                $user_code=$emapData[1];
                
              $sql = "INSERT into user_code(email_address,gift_code) values ('$user_email','$user_code')";
                //echo $sql."<br />";
              mysqli_query($Conn_local,$sql);
              //echo $user_email."--".$user_code. "<br />";
             }   
                
            $count++;                                      // add this line// add this line
        }
        $count--;
        echo  "新增".$count."筆<br />";
    $MailSql = "Select email_address,gift_code From user_code";
	$CountMail = "Select count(distinct email_address) From user_code";
	$SendMailTo = "自行上傳名單的會員";
    }
    
}
$result = mysqli_query($Conn_local,$CountMail);
List($CountM)=mysqli_fetch_row($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cooz EDM</title>
</head>
<body>
<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="InsertData.php">
<p><img src="img/logo.gif" width="304" height="42" /></p>
<p><b><font size=4>Cooz EDM System(確認工作)</font></b></p>
<p>發信者 : <?php echo $Sender;?></p>
<p>標題 : <?php echo $Title;?></p>
<p>內容 : </p>
<p>
  <textarea name="Content_Text" id="Content_Text" cols="70" rows="20"><?php echo $getcontent;?></textarea>
</p>
<?PHP
if (!empty($_FILES["AddFile"]["name"])){
?>
<p>附加檔案 : <?php echo $_FILES["AddFile"]["name"];?></p>
<?PHP
}
?>
<p>發信會員 : <?php echo $SendMailTo;?> -共 <?php echo $CountM;?> 位</p>
<p>增加E-Mail : 
<?PHP
if (!empty($Mail1)){
	echo $Mail1."/";
}
if (!empty($Mail2)){
	echo $Mail2."/";
}
if (!empty($Mail3)){
	echo $Mail3;
}
?>
</p>
<!--<p>
	是否要螢幕顯示寄信狀態
	<label>
    <input type="radio" name="printstate" value="Y" />
    要</label>
  <label>
    <input type="radio" name="printstate" value="N" checked="checked"/>
    不要</label>
</p>-->
<p>
  <input type="submit" name="ok" id="ok" value="確認" />
  <input type="hidden" name="Sender" value="<?php echo $Sender;?>">
  <input type="hidden" name="SenderMail" value="<?php echo $SenderMail;?>">
  <input type="hidden" name="Title" value="<?php echo $Title;?>">
  <input type="hidden" name="AddFile" value="<?php echo $AddFile_name;?>">
  <input type="hidden" name="sql" value="<?php echo $MailSql;?>">
  <input type="hidden" name="Mail1" value="<?php echo $Mail1;?>">
  <input type="hidden" name="Mail2" value="<?php echo $Mail2;?>">
  <input type="hidden" name="Mail3" value="<?php echo $Mail3;?>">
  <input type="hidden" name="TotMail" value="<?php echo $CountM;?>">
</p>
</form>
</body>
</html>