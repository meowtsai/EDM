<?php
//https://www.longeplay.com.tw/cancelsubscribe?acmno=7&mail=sophie_tsai@longeplay.com.tw

include "./lib/connect_mysql_local.php";

if (!empty($_GET['mail']) && !empty($_GET['acmno'])){
        
$_email = $_GET['mail'];
$_acmno = $_GET['acmno'];
 
    //echo $_POST["del"];
    $sql = "insert into errormail(EMNo,Email) values($_acmno,'$_email')";
    mysqli_query($Conn_local,$sql);
 
    
        
      
 
}
else
{
   
 die();
    
}
        
    
    ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="15;url=http://vxz.longeplay.com.tw/" />
<title>龍邑遊戲‧LongE Play</title>

<link rel="shortcut icon" href="https://game.longeplay.com.tw/p/img/favicon.png"/>
<link rel="Bookmark" href=""/>
<meta name="keywords" content="">
<meta name="description" content="" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
<link href="https://game.longeplay.com.tw/p/css/reset.css" rel="stylesheet" type="text/css" />
<link href="https://game.longeplay.com.tw/p/css/primary.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 9]>
<script src="https://game.longeplay.com.tw/p/js/html5shiv.min.js"></script>
<![endif]-->
<!--[if (gte IE 6)&(lte IE 8)]>
<script type="text/javascript" src="https://game.longeplay.com.tw/p/js/selectivizr-min.js"></script>
<![endif]-->
<!--[if (gte IE 6)&(lte IE 8)]>
<script type="text/javascript" src="https://game.longeplay.com.tw/p/js/respond.js"></script>
<![endif]-->
<!--[if (gte IE 6)&(lte IE 8)]>
<script type="text/javascript" src="https://game.longeplay.com.tw/p/js/background_size_emu.js"></script>
<![endif]-->


<link rel="stylesheet" type="text/css" href="https://game.longeplay.com.tw/p/css/default.css"/>
<script src='https://game.longeplay.com.tw/p/js/default.js'></script>

<script src="https://s3.amazonaws.com/nwapi/nwmatcher/nwmatcher-1.2.5-min.js"></script>
<meta name='description' content='龍邑'><meta name='robots' content='all'><link rel='stylesheet' type='text/css' href='https://game.longeplay.com.tw/p/css/default.css'><link rel='stylesheet' type='text/css' href='https://game.longeplay.com.tw/p/css/login.css'><link rel='stylesheet' type='text/css' href='https://game.longeplay.com.tw/p/css/news.css'><link rel='stylesheet' type='text/css' href='https://game.longeplay.com.tw/p/css/jquery.mCustomScrollbar.css'></head>
<body>
<script> (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
					  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

					  ga('create', 'UA-65559425-2', 'auto');
					  ga('send', 'pageview');
					</script><div id="header">
<div class="header-ins">
<div class="header-logo">

<h1>龍邑遊戲‧LongE Play</h1>
<a href="https://game.longeplay.com.tw/" title="龍邑遊戲‧LongE Play"><img src="https://game.longeplay.com.tw/p/image/header-logo.png" alt="龍邑遊戲‧LongE Play" /></a>
</div>
<div class="nav">

</div>
</div>
</div>
<script>
$(function()
{
	$('.not_ready').click(function()
	{
		leOpenDialog('龍邑遊戲','敬請期待！',leDialogType.MESSAGE);	
	});
});
</script>
<div id="content-login">
	<div class="login-ins">
		<div class="bread cf" typeof="v:Breadcrumb">
			
		</div>
		<div class="login_box">
			<div class="login_member">
				<div class="login_info">
					
						
                        <br /><br />
                        已取消訂閱 <br />
<br /><br /><br />
                        
					

					<ul id="news_content">
										</ul>
				</div>
				<div>
                                    </div>
			</div>
			<div class="button"><a href="https://vxz.longeplay.com.tw/">前往小李飛刀官網</a></div>
		</div>
	</div>
</div>
<script>
	(function($){
		$(window).load(function(){
			$(".scrollbar").mCustomScrollbar();
		});
	})(jQuery);
</script>
<div id="clear_copyright"></div>
<div class="copyright"><p>Long E Co., Ltd © 2016 Copyrights Reserved.</p></div>
<footer>
<div class="footer-ins">
</div>
</footer>
</body>
</html>

<link rel="stylesheet" type="text/css" href="https://game.longeplay.com.tw/p/css/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://game.longeplay.com.tw/p/css/slick-theme.css"/>
<script type="text/javascript" src="https://game.longeplay.com.tw/p/js/slick.min.js"></script>

<script src="/p/js/jquery.slicknav.min.js" type="text/javascript"></script>
<link href="/p/css/slicknav.css" rel="stylesheet" type="text/css" />

	
<!--nav -->
<script>
$('#menu').slicknav({
		label:'',
});
</script>

