<?PHP
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

	if (!empty($_FILES["UploadExcel"]["name"])){
		$EXCEL_File_name = $_FILES["UploadExcel"]["name"];
		$EXCEL_File_Size = $_FILES["UploadExcel"]["size"];
		$EXCEL_File_type = $_FILES["UploadExcel"]["type"];
		$EXCEL_File_tmp_name = $_FILES["UploadExcel"]["tmp_name"];
		move_uploaded_file($EXCEL_File_tmp_name,"./Excel/".$EXCEL_File_name);
        
        echo $EXCEL_File_name . "<br />";
        echo $EXCEL_File_Size . "<br />";
        echo $EXCEL_File_type . "<br />";
        echo $EXCEL_File_tmp_name . "<br />";
        
        
        $file=fopen("./Excel/$EXCEL_File_name","r");
		$count = 0;                                         // add this line
        while (($emapData = fgetcsv($file, 200, ",")) !== FALSE)
        {
            //print_r($emapData);
            //exit();
            $count++;                                      // add this line

            if($count>1){                                  // add this line
                $user_email=$emapData[0];
                $user_code=$emapData[1];
                
              //$sql = "INSERT into prod_list_1(p_bench,p_name,p_price,p_reason) values ('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]')";
              //mysql_query($sql);
                echo $user_email."--".$user_code. "<br />";
            }                                              // add this line
        }
        
        //edm_list.xlsx
//9114
//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
//C:\wamp64\tmp\php2431.tmp
        
    }
		/** $fp=fopen("./Excel/$Content_File_name","r");
		while(!feof($fp)){
			if (empty($getcontent)){
				$getcontent=fgets($fp);
			}else{
				$getcontent.=fgets($fp);
			}
		}
		fclose($fp); 
        
        $file = fopen($filename, "r");
//$sql_data = "SELECT * FROM prod_list_1 ";

$count = 0;                                         // add this line
while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
{
    //print_r($emapData);
    //exit();
    $count++;                                      // add this line

    if($count>1){                                  // add this line
      $sql = "INSERT into prod_list_1(p_bench,p_name,p_price,p_reason) values ('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]')";
      mysql_query($sql);
    }                                              // add this line
}
        */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cooz EDM</title>
</head>

<body>
<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="ExcelToMySQL.php">
    <label>
    <input type="radio" name="EMail_Command" value="4"/>
    玩家名單搭配序號</label>


<p>
  上傳Excel: <input type="file" name="UploadExcel" id="UploadExcel" />
</p>
<p>
  <input type="submit" name="ok" id="ok" value="Upload To MySQL" />
</p>
</form>
</body>
</html>



