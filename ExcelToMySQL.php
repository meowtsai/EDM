<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cooz EDM</title>
</head>

<body>
<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="ExcelToMySQL.php">
    <label>請匯入玩家名單與序號</label>


<p>
  上傳Excel: <input type="file" name="UploadExcel" id="UploadExcel" />
</p>
<p>
  <input type="submit" name="del" id="del" value="將舊有資料刪除" /> <input type="submit" name="ok" id="ok" value="上傳到資料表" />
</p>
</form>
</body>
</html>


<?PHP

$str = str_replace("TheCakeIsALie", "TKFJSCMSUDOWE", "good golly miss molly! TheCakeIsALie", $count);
echo $count."<br />";
echo $str."<br />";
//2
//good goy miss moy!

//--Kenny 2013.1.29 EDM 1
//--EDM.php
//include "./lib/connect_mysql.php";
include "./lib/connect_mysql_local.php";
include "login.php";
//$sql_TOT = "Select count(distinct email_address) From t_user t where email_address <> '' and SUBSTRING_INDEX(email_address, '@', -1) like '%.%' and email_address like '%@%'";
//$result = mysqli_query($Conn_local,$sql_TOT);
//List($TOT)=mysqli_fetch_row($result);

//$sql = "SELECT distinct email_address,SUBSTRING_INDEX(email_address, '@', -1) as Mail,count(*) as TOT  FROM t_user t where email_address <> '' and SUBSTRING_INDEX(email_address, '@', -1) like '%.%' and email_address like '%@%' group by SUBSTRING_INDEX(email_address, '@', -1) Order by TOT Desc limit 0, 30";
//$result = mysqli_query($Conn_local,$sql);


//isset($_FILES["AddFile"]["name"]
if (isset($_POST["del"]))
{
    //echo $_POST["del"];
    $sql = "delete from user_code";
                //echo $sql."<br />";
              mysqli_query($Conn_local,$sql);
 
    echo "資料已經刪除<br />";
    die();
 
}


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
        //edm_list.xlsx
//9114
//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
//C:\wamp64\tmp\php2431.tmp
        
    }
		

?>



