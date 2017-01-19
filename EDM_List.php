<?php

include "lib/connect_mysql_local.php";
include "login.php";


//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Main Panel";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["views"]["sub"]["projects"]["active"] = true;
//include("inc/nav.php");

//變更寄送狀態

if (!empty($_GET["Action"]) && !empty($_GET["ACMNo"])){
	$UpdateAction = "Update EDM.actionmail Set Status='".$_GET["Action"]."' where ACMNo='".$_GET["ACMNo"]."' and OwnUser='".$_SESSION['EDM_User']."'";
	$result_UPA = mysqli_query($Conn_local,$UpdateAction);
}

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
				
				<!--
					The ID "widget-grid" will start to initialize all widgets below 
					You do not need to use widgets if you dont want to. Simply remove 
					the <section></section> and you can use wells or panels instead 
					-->
				
				<!-- widget grid -->
				<section id="widget-grid" class="">

					<!-- row -->
					<div class="row">
						
						<!-- NEW WIDGET START -->
						<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							
							

							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget well" id="wid-id-0">
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
									<span class="widget-icon"> <i class="fa fa-comments"></i> </span>
									<h2>Widget Title </h2>				
									
								</header>

								<!-- widget div-->
								<div>
									
									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->
										<input class="form-control" type="text">	
									</div>
									<!-- end widget edit box -->
									
									<!-- widget content -->
									<div class="widget-body no-padding">
										
										<table id="example" class="display projects-table table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									        <thead>
									            <tr>
									                <th></th><th>工作編號</th>
                                                    <th>主旨</th>
                                                    <th><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> 發送人員 </th>
									                
									                <th>等待發送</th>
                                                    <th>發送失敗</th>
                                                    <th>開信數</th>
									                <th><i class="fa fa-circle txt-color-darken font-xs"></i> 總數量/ <i class="fa fa-circle text-danger font-xs"></i> 成功發送</th>
                                                    <th>取消訂閱</th>
									                <th><i class="fa fa-fw fa-calendar text-muted hidden-md hidden-sm hidden-xs"></i> 最後更新時間</th>
									                <th>狀態</th>
									            </tr>
									        </thead>
									    </table>

									</div>
									<!-- end widget content -->
									
								</div>
								<!-- end widget div -->
								
							</div>
							<!-- end widget -->

						</article>
						<!-- WIDGET END -->
						
					</div>

					<!-- end row -->

					<!-- row -->

					<div class="row">

                        <div class="alert alert-info">
								<strong>NOTE:</strong> 工作新增之後會進入排程，每五分鐘發送三百封，發完為止。
							</div>
						<!-- a blank row to get started -->
						<div class="col-sm-12">
						<a href="EDM.php" class="btn btn-primary btn-lg">新增EDM發送工作</a>

						</div>
							
					</div>

					<!-- end row -->

				</section>
				<!-- end widget grid -->

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

<!-- PAGE RELATED PLUGIN(S) 
<script src="<?php echo ASSETS_URL; ?>/js/plugin/YOURJS.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script>

	$(document).ready(function() {
		// PAGE RELATED SCRIPTS
		/* Formatting function for row details - modify as you need */
		function format ( d ) {
		    // `d` is the original data object for the row
		    return '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">'+
		        '<tr>'+
		            '<td style="width:100px">Project Title:</td>'+
		            '<td>'+d.name+'</td>'+
		        '</tr>'+
		        '<tr>'+
		            '<td>Deadline:</td>'+
		            '<td>'+d.ends+'</td>'+
		        '</tr>'+
		        '<tr>'+
		            '<td>Extra info:</td>'+
		            '<td>And any further details here (images etc)...</td>'+
		        '</tr>'+
		        '<tr>'+
		            '<td>Comments:</td>'+
		            '<td>'+d.comments+'</td>'+
		        '</tr>'+
		        '<tr>'+
		            '<td>Action:</td>'+
		            '<td>'+d.action+'</td>'+
		        '</tr>'+
		    '</table>';
		}

        //{"ACMNo":"1","SuccessMail":"72","ErrorMail":"0","WaitMail":"0","Status":"f","Create_date":"2017-01-06 17:53:02"}
		// clears the variable if left blank
	    var table = $('#example').DataTable( {
	        "ajax": "data/data_edmlist.php",
	        "bDestroy": true,
	        "iDisplayLength": 8,
	        "columns": [
	            {
	                "class":          'details-control',
	                "orderable":      false,
	                "data":           null,
	                "defaultContent": ''
	            },
	            { "data": "ACMNo" },
                { "data": "Tital" },
                { "data": "OwnUser" },
	            { "data": "WaitMail" },
                { "data": "ErrorMail" },
                { "data": "OpenedMail" },
                { "data": "SuccessMailTotalMail" },
                { "data": "Cancelled" },
                { "data": "Create_date" },
	            { "data": "Status" },
	            
                
	            
	        ],
	        "order": [[1, 'desc']],
	        "fnDrawCallback": function( oSettings ) {
		       runAllCharts()
		    }
	    } );


	     
	    /*/ Add event listener for opening and closing details
	    $('#example tbody').on('click', 'td.details-control', function () {
	        var tr = $(this).closest('tr');
	        var row = table.row( tr );
	 
	        if ( row.child.isShown() ) {
	            // This row is already open - close it
	            row.child.hide();
	            tr.removeClass('shown');
	        }
	        else {
	            // Open this row
	            //row.child( format(row.data()) ).show();
	            tr.addClass('shown');
	        }
	    });
        
        
        
        $( "a[name*='cmdAction']" ).on('click', function() {
          alert( "Handler for .click() called." );
        });
        */
        
       
        
        
	})

</script>

<?php 
	//include footer
	//include("inc/google-analytics.php"); 
?>