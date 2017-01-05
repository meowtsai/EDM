<?PHP
session_start();

if (!empty($_SESSION['EDM_User']) || @$_SESSION['login_AUTH'] == 9){
	echo '<html><head><meta http-equiv="refresh" content="0;URL=EDM_List.php"><title>Redirect</title></head><body  bgcolor="#C5E4E9" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"></body></html>';				
	exit();
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cooz EDM</title>
</head>
<body>
<form id="form1" name="form1" method="post" action="EDM_List.php">
<p><img src="img/logo.gif" width="304" height="42" /></p>
<p><b><font size=4>Cooz EDM System (登入)</font></b></p>
<p>帳號 : <input type="text" name="account"></p>
<p>密碼 : <input type="password" name="passwd"></p>
<p>
  <input type="submit" name="ok" id="ok" value="確認" />
</p>
</form>
</body>
</html>