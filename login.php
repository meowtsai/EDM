<?PHP
session_start();

//203.73.59.138
$ip=$_SERVER['REMOTE_ADDR'];
if ($ip!='203.73.59.138' && $ip!='::1' && $ip!='61.220.44.200' )
{
    //echo $_SERVER['REMOTE_ADDR'];
    //echo $_SERVER['REMOTE_ADDR']!='::1';
    //echo '<html><head><meta http-equiv="refresh" content="0;URL=index.php"><title>Redirect</title></head><body  bgcolor="#C5E4E9" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"></body></html>';				
    //不合法ip1
    echo '不合法ip:' .$_SERVER['REMOTE_ADDR'];
			exit();
    

    
}
else
{
    //echo $_SERVER['REMOTE_ADDR'];
    
}

if (empty($_SESSION['EDM_User']) || $_SESSION['login_AUTH'] != 9){
	//未登入過
	@$account = $_POST['account'];
	@$password = $_POST['passwd'];
	
	if (!empty($account) && !empty($password)){
		$sql = "select count(*) from EDM.edmuser where UserId='$account' and UserPW='$password'";
		$result = mysqli_query($Conn_local,$sql);
		List($Auth_count)=mysqli_fetch_row($result);
		if ($Auth_count > 0){
			//登入成功
			$_SESSION['EDM_User'] = $account;
			$_SESSION['login_AUTH'] = 9;
			$sql_User = "select UserName from EDM.edmuser where UserId='$account' and UserPW='$password'";
			$result_User = mysqli_query($Conn_local,$sql_User);
			List($UserName)=mysqli_fetch_row($result_User);
			$_SESSION['UserName'] = $UserName;
		}else{
            //echo $sql_User;
			echo "<script>alert('注意!!你的帳號或密碼有誤');</script>";
			echo '<html><head><meta http-equiv="refresh" content="0;URL=index.php"><title>Redirect</title></head><body  bgcolor="#C5E4E9" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"></body></html>';				
			exit();
		}
	}else{
		echo "<script>alert('注意!!你的來源有誤');</script>";
		echo '<html><head><meta http-equiv="refresh" content="0;URL=index.php"><title>Redirect</title></head><body  bgcolor="#C5E4E9" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"></body></html>';				
		exit();
	}
}
?>