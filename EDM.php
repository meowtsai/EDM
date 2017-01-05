<?PHP
//--Kenny 2013.1.29 EDM 1
//--EDM.php
//include "./lib/connect_mysql.php";
include "./lib/connect_mysql_local.php";
include "login.php";
$sql_TOT = "Select count(distinct email_address) From t_user t where email_address <> '' and SUBSTRING_INDEX(email_address, '@', -1) like '%.%' and email_address like '%@%'";
$result = mysqli_query($Conn_local,$sql_TOT);
List($TOT)=mysqli_fetch_row($result);

$sql = "SELECT distinct email_address,SUBSTRING_INDEX(email_address, '@', -1) as Mail,count(*) as TOT  FROM t_user t where email_address <> '' and SUBSTRING_INDEX(email_address, '@', -1) like '%.%' and email_address like '%@%' group by SUBSTRING_INDEX(email_address, '@', -1) Order by TOT Desc limit 0, 30";
$result = mysqli_query($Conn_local,$sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cooz EDM</title>
</head>
<script  src="http://code.jquery.com/jquery.min.js"></script>
<script language=javascript>
<!--
$(function(){

	$("input[name=RadioContent]").change(function(){
			if ($(this).val() == '1') {
				$("#Content_Text").hide();
				$("#Content_File").show();
			}else{
				$("#Content_File").hide();
				$("#Content_Text").show();
			}
		})

	$("input[name=EMail_Command]").change(function(){
			if ($(this).val() == '1') {
				$("#IEmail").hide();
				$("#SMailList").hide();
                $("#UpLoadMyOwn").hide();
			}else if ($(this).val() == '2'){
				$("#IEmail").hide();
				$("#SMailList").show();  
                $("#UpLoadMyOwn").hide();
            }else if ($(this).val() == '3'){
				$("#IEmail").show();
				$("#SMailList").hide();
                $("#UpLoadMyOwn").hide();
			}else if ($(this).val() == '4'){
				$("#IEmail").hide();
				$("#SMailList").hide();
                $("#UpLoadMyOwn").show();
                
			}
		})
	
})

-->
</script>
<body>
<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="SendMail.php">
<p><img src="img/logo.gif" width="304" height="42" /></p>
<p><b><font size=4>Cooz EDM System(設定工作)</font></b></p>
<p>發信者 : 
  <input type="text" name="Sender" id="Sender" /></p>
<p>E-Mail : 
  <input type="text" name="SenderMail" value="sophie_tsai@longeplay.com.tw" id="Sender"  size=30 /></p>
<p>標題 : 
  <input type="text" name="Title" id="Title" size=80 /></p>
<p>內容 :
  <label>
    <input name="RadioContent" type="radio" value="1" checked="checked"/>
    檔案</label>
  <label>
    <input type="radio" name="RadioContent" value="2"/>
    文字方塊</label>
  <br />
</p>
<p>
  <textarea name="Content_Text" id="Content_Text" cols="70" rows="20" style="display:none"></textarea>
  <input type="file" name="Content_File" id="Content_File"/>
</p>
<p>附加檔案 : <input type="file" name="AddFile" id="AddFile" /></p>
<p>E-Mail(TOTAL : <?php echo $TOT;?>) : </p>
<p>
  <label>
    <input type="radio" name="EMail_Command" value="1" checked="checked"/>
    全部玩家E-Mail</label>
  <label>
    <input type="radio" name="EMail_Command" value="2"/>
    選擇(Domain name)</label>
  <label>
    <input type="radio" name="EMail_Command" value="3"/>
    自行填入需要的Domain Name</label>
    <label>
    <input type="radio" name="EMail_Command" value="4"/>
    玩家名單搭配序號</label>
</p>

<div id="UpLoadMyOwn" style="display:none">
<p>
  上傳Excel: <input type="file" name="UploadExcel" id="UploadExcel" />
</p>
</div>

<div id="IEmail" style="display:none">
<p>
  ALL@<input type="Text" name="DNSMail" id="DNSMail"/>
</p>
</div>
<div id="SMailList" style="display:none">
<table width="200">
<?PHP
$i = 1;
$j = 1;
$Other_TOT = $TOT;
while($row = mysqli_fetch_array($result)){
	$Other_TOT = $Other_TOT - $row["TOT"];
	if ($j == 1){
?>
  <tr>
<?PHP
	}
?>
    <td><label>
      <input name="Mail_List[]" type="checkbox" value="<?php echo $row["Mail"];?>" checked="checked" />
      <?php echo $row["Mail"];?>(<?php echo $row["TOT"];?>)</label></td>
<?PHP
	if ($j == 3){
?>
  </tr>
<?PHP
		$j = 1;
	}else{
		$j++;
	}
	$i++;
}

if ($j != 1){
?>
	 </tr>
<?PHP
}
?>
</table>
</div>
<p>
	增加E-Mail : <input type="text" name="Mail1" id="Mail1" /> / <input type="text" name="Mail2" id="Mail2" /> / <input type="text" name="Mail3" id="Mail3" />
</P>
<p>
  <input type="submit" name="ok" id="ok" value="Send Mail" />
</p>
</form>
</body>
</html>
