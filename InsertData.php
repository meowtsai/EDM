<?PHP

error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
//--Kenny 2014.7.16 EDM InsertData
//--InsertData.php
date_default_timezone_set('Asia/Taipei');
//include "./lib/connect_mysql.php";
include "./lib/connect_mysql_local.php";
include "login.php";

$Euser = $_SESSION['EDM_User'];
$Sender = $_POST["Sender"];
$SenderMail = $_POST["SenderMail"];
$Title = $_POST["Title"];
$Content_Text = $_POST["Content_Text"];
$sql = $_POST["sql"];
//$Mail[1] = $_POST["Mail1"];
//$Mail[2] = $_POST["Mail2"];
//$Mail[3] = $_POST["Mail3"];
$TotMail = $_POST["TotMail"];


//if ($TotMail <= 0 & $Mail[1] == "" & $Mail[2] == "" & $Mail[3] == "" ){
if ($TotMail <= 0 ){
	echo "<script>alert('注意!!寄送郵件為0');</script>";
	echo '<html><head><meta http-equiv="refresh" content="0;URL=EDM_List.php"><title>Redirect</title></head><body  bgcolor="#C5E4E9" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"></body></html>';				
	exit();
}

//取得最大的寄件行動流水號
$sql_Max = "select Max(ACMNo) from EDM.actionmail";
$result = mysqli_query($Conn_local,$sql_Max);
List($ACMNo_Max)=mysqli_fetch_row($result);
if ($ACMNo_Max > 0 && !empty($ACMNo_Max)){
	$ACMNo = $ACMNo_Max + 1;
}else{
	$ACMNo = 1;
}

//$InsertData = "insert into EDM.actionmail (ACMNo,OwnUser,SuccessMail,ErrorMail,WaitMail,Status,Create_date,html,FormMail,Tital,SendUser,AddFile)values";
//$InsertData .= "($ACMNo,'".$_SESSION['EDM_User']."',0,0,0,'w',now(),'$Content_Text','$SenderMail','$Title','$Sender','".$_POST['AddFile']."')";

$InsertData = "insert into EDM.actionmail (ACMNo,OwnUser,SuccessMail,ErrorMail,WaitMail,OpenedMail,Status,Create_date,html,FormMail,Tital,SendUser)values";
$InsertData .= "($ACMNo,'".$_SESSION['EDM_User']."',0,0,0,0,'w',now(),'$Content_Text','$SenderMail','$Title','$Sender')";
$result = mysqli_query($Conn_local,$InsertData);

//echo $InsertData;

$result_cooz = mysqli_query($Conn_local,$sql);
$i = 0;
$j = 0;
while($row = mysqli_fetch_array($result_cooz)){
	$sql_mail_check = "select count(*) from EDM.errormail where EMail = '".$row["email_address"]."'";
	$result_check = mysqli_query($Conn_local,$sql_mail_check);
	List($CheckCount)=mysqli_fetch_row($result_check);

	if ($CheckCount == 0){
		$insert_Mail = "insert into sendmail (EMail,Status,tag,ActionNo,UserName,gift_code)values";
        $pos = strpos($sql, "gift_code");
        $gift_code="";
        if ($pos !== false)
        {
            $gift_code= $row["gift_code"];
        }
		$insert_Mail .= "('".$row["email_address"]."','a',0,'$ACMNo','','$gift_code')";
		$result_Mail = mysqli_query($Conn_local,$insert_Mail);
		$i++;
	}
	$j++;
}
for ($x=0;$x <= 3;$x++){
	if (!empty($Mail[$x])){
		$insert_Mail = "insert into sendmail (EMail,Status,tag,ActionNo,UserName,gift_code)values";
		$insert_Mail .= "('".$Mail[$x]."','a',0,'$ACMNo','TestMail','TESTGIFTCODEAAAAA')";
		$result = mysqli_query($Conn_local,$insert_Mail);
		$i++;
		$j++;
	}
}
$Tot_ErrorMail = $j - $i;
$Update_Status = "Update EDM.sendmail set Status = 'w' where ActionNo = '$ACMNo'";
$result_Status = mysqli_query($Conn_local,$Update_Status);
$Update_ACMNo = "Update EDM.actionmail set WaitMail = '$i' where ACMNo = '$ACMNo'";
$result_ACMNo = mysqli_query($Conn_local,$Update_ACMNo);




//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "新增EDM發送作業";

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
							<h2>EDM完成工作設定 </h2>
		
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
                                
                               
                                    <table class="table table-bordered">
									<thead>
										<tr>
											<th>原始總信件量</th>
											<th>實際總信件量</th>
											<th>無效E-Mail</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><div align="center"><?PHP echo $j;?></div></td>
                                            <td><div align="center"><?PHP echo $i; ?></div></td>
                                            <td><div align="center"><?PHP echo $Tot_ErrorMail; ?></div></td>
										</tr>
                                        <tr>
											<td colspan=3 align="right">
                                                <a href="EDM_List.php" type="button" class="btn btn-primary" name="ok" id="ok" >回管理頁面</a>
                                            </td>
											
											
										</tr>
									</tbody>
								</table>


									
                              
                                
                             
									
		
		
	
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

