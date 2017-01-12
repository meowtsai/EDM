<?PHP
//--meow 2017.01.12 EDM 1
//--EDM.php
//include "./lib/connect_mysql.php";

include "lib/connect_mysql_local.php";
include "login.php";


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


//$sql_TOT = "Select count(distinct email_address) From t_user t where email_address <> '' and SUBSTRING_INDEX(email_address, '@', -1) like '%.%' and email_address like '%@%'";
//$result = mysqli_query($Conn_local,$sql_TOT);
//List($TOT)=mysqli_fetch_row($result);

//$sql = "SELECT distinct email_address,SUBSTRING_INDEX(email_address, '@', -1) as Mail,count(*) as TOT  FROM t_user t where email_address <> '' and SUBSTRING_INDEX(email_address, '@', -1) like '%.%' and email_address like '%@%' group by SUBSTRING_INDEX(email_address, '@', -1) Order by TOT Desc limit 0, 30";
//$result = mysqli_query($Conn_local,$sql);
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
								總覽
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
							<h2>新增一個EDM工作排程 </h2>
		
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
		
								<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="SendMail.php" class="smart-form">
									<header>
										輸入以下相關欄位
									</header>
		
									<fieldset>
										
                                        
 

                                        
                                        
                                        
										<section>
											<label class="label">發信者 : </label>
											<label class="input">
                                                <input type="text" name="Sender" id="Sender" value="酷栗遊戲" />												
											</label>
										</section>
                                        <section>
											<label class="label">發信者E-Mail : </label>
											<label class="input">
                                                <input type="text" name="SenderMail" value="edm@edm.cooz.com.tw" id="Sender"  size=30 />						
											</label>
										</section>
                                        <section>
											<label class="label">信件標題主旨 : </label>
											<label class="input">
                                                <input type="text" name="Title" id="Title" size=80 />												
											</label>
										</section>
                                        <section>
											<label class="label">信件內容HTML檔</label>
											<div class="input input-file">
												<span class="button"><input type="file" onchange="this.parentNode.nextSibling.value = this.value" name="Content_File" id="Content_File">瀏覽</span><input type="text" placeholder="請選取信件內容要套用的HTML檔案" readonly="">
											</div>
										</section>
                                        <section>
											<label class="label">玩家名單搭配虛寶序號csv檔案</label>
											<div class="input input-file">
												<span class="button"><input type="file" id="UploadExcel" name="UploadExcel" onchange="this.parentNode.nextSibling.value = this.value" name="Content_File" id="Content_File">瀏覽</span><input type="text" placeholder="請選取要發送對象Email和虛寶序號的csv檔案" readonly="">
											</div>
										</section>
		
										
									</fieldset>
		
									<footer>
										<button type="submit" class="btn btn-primary">
											下一步
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


<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jquery-form/jquery-form.min.js"></script>


<script type="text/javascript">

	$(document).ready(function() {

		

		var $orderForm = $("#form1").validate({
			// Rules for form validation
			rules : {
				Sender : {
					required : true
				},
				SenderMail : {
					required : true,
					email : true
				},
				Title : {
					required : true
				},
				Content_File : {
					required : true
				},
				UploadExcel : {
					required : true
				}
			},

			// Messages for form validation
			messages : {
				Sender : {
					required : '請輸入寄件者署名,例如xx遊戲'
				},
				SenderMail : {
					required : '請輸入寄件者Mail,例如edm@edm.cooz.com.tw',
					email : 'Please enter a VALID email address'
				},
				Title : {
					required : '請輸入信件主旨,例如"酷栗會員專屬好康！免費領小李飛刀遊戲金!"'
				},
				Content_File : {
					required : '請選取上傳信件內容html檔案'
				},
				UploadExcel : {
					required : '請選取上傳名單虛寶號csv檔案'
				}
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});

		



	})

</script>