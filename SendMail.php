<?PHP

error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
//--Kenny 2013.1.29 EDM 2
//--SendMail.php
//include "./lib/connect_mysql.php";
include "./lib/connect_mysql_local.php";
include "login.php";



//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");




$Sender = $_POST["Sender"];
$SenderMail = $_POST["SenderMail"];
$Title = $_POST["Title"];
//$RadioContent = $_POST["RadioContent"];
$RadioContent=1;//先把自行輸入文字的功能拿掉
//$EMail_Command = $_POST["EMail_Command"];
$EMail_Command=4;//把其他名單的功能拿掉 只能匯入email + 序號的名單
//$Mail1 = $_POST["Mail1"];
//$Mail2 = $_POST["Mail2"];
//$Mail3 = $_POST["Mail3"];
//自行輸入email收件者的功能先拿掉

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
        
        $sql = "delete from user_code";  
                //echo $sql."<br />";
        mysqli_query($Conn_local,$sql);
        
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
        //echo  "新增".$count."筆<br />";
    $MailSql = "Select email_address,gift_code From user_code";
	$CountMail = "Select count(distinct email_address) From user_code";
	$SendMailTo = "自行上傳名單的會員";
    }
    
}
$result = mysqli_query($Conn_local,$CountMail);
List($CountM)=mysqli_fetch_row($result);


/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "EDM排程工作確認";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");
?>

<!-- ==========================CONTENT STARTS HERE ========================== -->
		<!-- MAIN PANEL -->
		<div id="main" role="main">

			
			
			

			<!-- MAIN CONTENT -->
			<div id="content">

				<!-- row -->
				<div class="row">
					
					<!-- col -->
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
						<h1 class="page-title txt-color-blueDark">
							
							<!-- PAGE HEADER -->
							<i class="fa-fw fa fa-file-text-o"></i> 
								EDM工作
							<span>>  
								最後確認
							</span>
						</h1>
					</div>
					<!-- end col -->
					
					<!-- right side of the page with the sparkline graphs -->
					<!-- col -->
					<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
						<!-- sparks -->
						<ul id="sparks">
							
						</ul>
						<!-- end sparks -->
					</div>
					<!-- end col -->
					
				</div>
				<!-- end row -->
    
    
    	<!-- START ROW -->
		
			<div class="row">
		
				<!-- NEW COL START -->
				<article class="col-sm-12 col-md-12 col-lg-6">
		
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
		
						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"
		
						-->
						<header>
							<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
							<h2>EDM工作排程確認 </h2>
		
						</header>
		
						<!-- widget div-->
						<div>
		
							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
		
							</div>
							<!-- end widget edit box -->
		
							<!-- widget content -->
							<div class="widget-body no-padding">
		
								<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="InsertData.php" class="smart-form">
									<header>
										輸入以下相關欄位
									</header>
		
									<fieldset>
										

                                        
                                        
										<section>
                                            <label class="label">發信者 : <strong><?php echo $Sender;?></strong></label>
										</section>
                                        <section>
											<label class="label">發信者E-Mail : <strong><?php echo $SenderMail;?></strong></label>
										</section>
                                        <section>
											<label class="label">信件標題主旨 : <strong><?php echo $Title;?></strong></label>
										</section>
                                        <section>
											<label class="label">信件內容HTML檔</label>
                                            
                                            
											<label class="textarea"> 										
                                                <textarea name="Content_Text" id="Content_Text" cols="70" rows="20" class="custom-scroll"><?php echo $getcontent;?></textarea>
											</label>
												
										</section>
                                        
                    
                                        <section>
											<label class="label">發信會員 : </label>
											<div class="label">
												<?php echo $SendMailTo;?> -共 <?php echo $CountM;?> 位
											</div>
										</section>
		
										
									</fieldset>                  
                                    
                                    <input type="hidden" name="Sender" value="<?php echo $Sender;?>">
                                      <input type="hidden" name="SenderMail" value="<?php echo $SenderMail;?>">
                                      <input type="hidden" name="Title" value="<?php echo $Title;?>">
                                      <input type="hidden" name="sql" value="<?php echo $MailSql;?>">
                                      <input type="hidden" name="TotMail" value="<?php echo $CountM;?>">
									<footer>
										<button type="submit" class="btn btn-primary" name="ok" id="ok" >
											確認
										</button>
										<button type="button" class="btn btn-default" onclick="window.history.back();">
											取消
										</button>
									</footer>
								</form>
		
							</div>
							<!-- end widget content -->
		
						</div>
						<!-- end widget div -->
		
					</div>
					<!-- end widget -->
		
				</article>
				<!-- END COL -->
		
				
			</div>
		
			<!-- END ROW -->


			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->


<!-- PAGE FOOTER -->
<?php
	// include page footer
	include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php 
	//include required scripts
	include("inc/scripts.php"); 
?>
