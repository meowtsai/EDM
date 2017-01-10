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
							<h2>Basic Form Elements </h2>
		
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
		
								<form class="smart-form">
									<header>
										Standard Form Header
									</header>
		
									<fieldset>
										
										<section>
											<label class="label">Extra Small text input</label>
											<label class="input">
												<input type="text" class="input-xs">
											</label>
										</section>
		
										<section>
											<label class="label">Small text input</label>
											<label class="input">
												<input type="text" class="input-sm">
											</label>
										</section>
		
										<section>
											<label class="label">Default text input with maxlength</label>
											<label class="input">
												<input type="text" maxlength="10">
											</label>
											<div class="note">
												<strong>Maxlength</strong> is automatically added via the "maxlength='#'" attribute
											</div>
										</section>
																		
										<section>
											<label class="label">Large text input</label>
											<label class="input">
												<input type="text" class="input-lg">
											</label>
										</section>
									
									</fieldset>
									
									<fieldset>
											
										<section>
											<label class="label">File input</label>
											<div class="input input-file">
												<span class="button"><input type="file" id="file" name="file" onchange="this.parentNode.nextSibling.value = this.value">Browse</span><input type="text" placeholder="Include some files" readonly="">
											</div>
										</section>
		
										<section>
											<label class="label">Input with autocomlete</label>
											<label class="input">
												<input type="text" list="list">
												<datalist id="list">
													<option value="Alexandra">Alexandra</option>
													<option value="Alice">Alice</option>
													<option value="Anastasia">Anastasia</option>
													<option value="Avelina">Avelina</option>
													<option value="Basilia">Basilia</option>
													<option value="Beatrice">Beatrice</option>
													<option value="Cassandra">Cassandra</option>
													<option value="Cecil">Cecil</option>
													<option value="Clemencia">Clemencia</option>
													<option value="Desiderata">Desiderata</option>
													<option value="Dionisia">Dionisia</option>
													<option value="Edith">Edith</option>
													<option value="Eleanora">Eleanora</option>
													<option value="Elizabeth">Elizabeth</option>
													<option value="Emma">Emma</option>
													<option value="Felicia">Felicia</option>
													<option value="Florence">Florence</option>
													<option value="Galiana">Galiana</option>
													<option value="Grecia">Grecia</option>
													<option value="Helen">Helen</option>
													<option value="Helewisa">Helewisa</option>
													<option value="Idonea">Idonea</option>
													<option value="Isabel">Isabel</option>
													<option value="Joan">Joan</option>
													<option value="Juliana">Juliana</option>
													<option value="Karla">Karla</option>
													<option value="Karyn">Karyn</option>
													<option value="Kate">Kate</option>
													<option value="Lakisha">Lakisha</option>
													<option value="Lana">Lana</option>
													<option value="Laura">Laura</option>
													<option value="Leona">Leona</option>
													<option value="Mandy">Mandy</option>
													<option value="Margaret">Margaret</option>
													<option value="Maria">Maria</option>
													<option value="Nanacy">Nanacy</option>
													<option value="Nicole">Nicole</option>
													<option value="Olga">Olga</option>
													<option value="Pamela">Pamela</option>
													<option value="Patricia">Patricia</option>
													<option value="Qiana">Qiana</option>
													<option value="Rachel">Rachel</option>
													<option value="Ramona">Ramona</option>
													<option value="Samantha">Samantha</option>
													<option value="Sandra">Sandra</option>
													<option value="Tanya">Tanya</option>
													<option value="Teresa">Teresa</option>
													<option value="Ursula">Ursula</option>
													<option value="Valerie">Valerie</option>
													<option value="Veronica">Veronica</option>
													<option value="Wilma">Wilma</option>
													<option value="Yasmin">Yasmin</option>
													<option value="Zelma">Zelma</option>
												</datalist> </label>
											<div class="note">
												<strong>Note:</strong> works in Chrome, Firefox, Opera and IE10.
											</div>
										</section>
									</fieldset>
		
									<fieldset>
										
										<section>
											<label class="label">Select Small</label>
											<label class="select">
												<select class="input-sm">
													<option value="0">Choose name</option>
													<option value="1">Alexandra</option>
													<option value="2">Alice</option>
													<option value="3">Anastasia</option>
													<option value="4">Avelina</option>
												</select> <i></i> </label>
										</section>
										
										<section>
											<label class="label">Select default</label>
											<label class="select">
												<select>
													<option value="0">Choose name</option>
													<option value="1">Alexandra</option>
													<option value="2">Alice</option>
													<option value="3">Anastasia</option>
													<option value="4">Avelina</option>
												</select> <i></i> </label>
										</section>
		
										<section>
											<label class="label">Select Large</label>
											<label class="select">
												<select class="input-lg">
													<option value="0">Choose name</option>
													<option value="1">Alexandra</option>
													<option value="2">Alice</option>
													<option value="3">Anastasia</option>
													<option value="4">Avelina</option>
												</select> <i></i> </label>
										</section>
		
										<section>
											<label class="label">Multiple select</label>
											<label class="select select-multiple">
												<select multiple="" class="custom-scroll">
													<option value="1">Alexandra</option>
													<option value="2">Alice</option>
													<option value="3">Anastasia</option>
													<option value="4">Avelina</option>
													<option value="5">Basilia</option>
													<option value="6">Beatrice</option>
													<option value="7">Cassandra</option>
													<option value="8">Clemencia</option>
													<option value="9">Desiderata</option>
												</select> </label>
											<div class="note">
												<strong>Note:</strong> hold down the ctrl/cmd button to select multiple options.
											</div>
										</section>
									</fieldset>
		
									<fieldset>
										<section>
											<label class="label">Textarea</label>
											<label class="textarea"> 										
												<textarea rows="3" class="custom-scroll"></textarea> 
											</label>
											<div class="note">
												<strong>Note:</strong> height of the textarea depends on the rows attribute.
											</div>
										</section>
		
										<section>
											<label class="label">Textarea resizable</label>
											<label class="textarea textarea-resizable"> 										
												<textarea rows="3" class="custom-scroll"></textarea> 
											</label>
										</section>
		
										<section>
											<label class="label">Textarea expandable</label>
											<label class="textarea textarea-expandable"> 										
												<textarea rows="3" class="custom-scroll"></textarea> 
											</label>
											<div class="note">
												<strong>Note:</strong> expands on focus.
											</div>
										</section>
									</fieldset>
		
									<fieldset>
										<section>
											<label class="label">Columned radios</label>
											<div class="row">
												<div class="col col-4">
													<label class="radio">
														<input type="radio" name="radio" checked="checked">
														<i></i>Alexandra</label>
													<label class="radio">
														<input type="radio" name="radio">
														<i></i>Alice</label>
													<label class="radio">
														<input type="radio" name="radio">
														<i></i>Anastasia</label>
												</div>
												<div class="col col-4">
													<label class="radio">
														<input type="radio" name="radio">
														<i></i>Avelina</label>
													<label class="radio">
														<input type="radio" name="radio">
														<i></i>Basilia</label>
													<label class="radio">
														<input type="radio" name="radio">
														<i></i>Beatrice</label>
												</div>
												<div class="col col-4">
													<label class="radio">
														<input type="radio" name="radio">
														<i></i>Cassandra</label>
													<label class="radio">
														<input type="radio" name="radio">
														<i></i>Clemencia</label>
													<label class="radio">
														<input type="radio" name="radio">
														<i></i>Desiderata</label>
												</div>
											</div>
										</section>
		
										<section>
											<label class="label">Inline radios</label>
											<div class="inline-group">
												<label class="radio">
													<input type="radio" name="radio-inline" checked="checked">
													<i></i>Alexandra</label>
												<label class="radio">
													<input type="radio" name="radio-inline">
													<i></i>Alice</label>
												<label class="radio">
													<input type="radio" name="radio-inline">
													<i></i>Anastasia</label>
												<label class="radio">
													<input type="radio" name="radio-inline">
													<i></i>Avelina</label>
												<label class="radio">
													<input type="radio" name="radio-inline">
													<i></i>Beatrice</label>
											</div>
										</section>
									</fieldset>
		
									<fieldset>
										<section>
											<label class="label">Columned checkboxes</label>
											<div class="row">
												<div class="col col-4">
													<label class="checkbox">
														<input type="checkbox" name="checkbox" checked="checked">
														<i></i>Alexandra</label>
													<label class="checkbox">
														<input type="checkbox" name="checkbox">
														<i></i>Alice</label>
													<label class="checkbox">
														<input type="checkbox" name="checkbox">
														<i></i>Anastasia</label>
												</div>
												<div class="col col-4">
													<label class="checkbox">
														<input type="checkbox" name="checkbox">
														<i></i>Avelina</label>
													<label class="checkbox">
														<input type="checkbox" name="checkbox">
														<i></i>Basilia</label>
													<label class="checkbox">
														<input type="checkbox" name="checkbox">
														<i></i>Beatrice</label>
												</div>
												<div class="col col-4">
													<label class="checkbox">
														<input type="checkbox" name="checkbox">
														<i></i>Cassandra</label>
													<label class="checkbox">
														<input type="checkbox" name="checkbox">
														<i></i>Clemencia</label>
													<label class="checkbox">
														<input type="checkbox" name="checkbox">
														<i></i>Desiderata</label>
												</div>
											</div>
										</section>
		
										<section>
											<label class="label">Inline checkboxes</label>
											<div class="inline-group">
												<label class="checkbox">
													<input type="checkbox" name="checkbox-inline" checked="checked">
													<i></i>Alexandra</label>
												<label class="checkbox">
													<input type="checkbox" name="checkbox-inline">
													<i></i>Alice</label>
												<label class="checkbox">
													<input type="checkbox" name="checkbox-inline">
													<i></i>Anastasia</label>
												<label class="checkbox">
													<input type="checkbox" name="checkbox-inline">
													<i></i>Avelina</label>
												<label class="checkbox">
													<input type="checkbox" name="checkbox-inline">
													<i></i>Beatrice</label>
											</div>
										</section>
									</fieldset>
		
									<fieldset>
										<div class="row">
											<section class="col col-5">
												<label class="label">Radio Toggles</label>
												<label class="toggle">
													<input type="radio" name="radio-toggle" checked="checked">
													<i data-swchon-text="ON" data-swchoff-text="OFF"></i>Alexandra</label>
												<label class="toggle">
													<input type="radio" name="radio-toggle">
													<i data-swchon-text="ON" data-swchoff-text="OFF"></i>Anastasia</label>
												<label class="toggle">
													<input type="radio" name="radio-toggle">
													<i data-swchon-text="ON" data-swchoff-text="OFF"></i>Avelina</label>
											</section>
		
											<div class="col col-2"></div>
		
											<section class="col col-5">
												<label class="label">Checkbox Toggles</label>
												<label class="toggle">
													<input type="checkbox" name="checkbox-toggle" checked="checked">
													<i data-swchon-text="ON" data-swchoff-text="OFF"></i>Cassandra</label>
												<label class="toggle">
													<input type="checkbox" name="checkbox-toggle">
													<i data-swchon-text="ON" data-swchoff-text="OFF"></i>Clemencia</label>
												<label class="toggle">
													<input type="checkbox" name="checkbox-toggle">
													<i data-swchon-text="ON" data-swchoff-text="OFF"></i>Desiderata</label>
											</section>
										</div>
									</fieldset>
		
									<fieldset>
										<section>
											<label class="label">Ratings with different icons</label>
											<div class="rating">
												<input type="radio" name="stars-rating" id="stars-rating-5">
												<label for="stars-rating-5"><i class="fa fa-star"></i></label>
												<input type="radio" name="stars-rating" id="stars-rating-4">
												<label for="stars-rating-4"><i class="fa fa-star"></i></label>
												<input type="radio" name="stars-rating" id="stars-rating-3">
												<label for="stars-rating-3"><i class="fa fa-star"></i></label>
												<input type="radio" name="stars-rating" id="stars-rating-2">
												<label for="stars-rating-2"><i class="fa fa-star"></i></label>
												<input type="radio" name="stars-rating" id="stars-rating-1">
												<label for="stars-rating-1"><i class="fa fa-star"></i></label>
												Stars
											</div>
		
											<div class="rating">
												<input type="radio" name="trophies-rating" id="trophies-rating-7">
												<label for="trophies-rating-7"><i class="fa fa-trophy"></i></label>
												<input type="radio" name="trophies-rating" id="trophies-rating-6">
												<label for="trophies-rating-6"><i class="fa fa-trophy"></i></label>
												<input type="radio" name="trophies-rating" id="trophies-rating-5">
												<label for="trophies-rating-5"><i class="fa fa-trophy"></i></label>
												<input type="radio" name="trophies-rating" id="trophies-rating-4">
												<label for="trophies-rating-4"><i class="fa fa-trophy"></i></label>
												<input type="radio" name="trophies-rating" id="trophies-rating-3">
												<label for="trophies-rating-3"><i class="fa fa-trophy"></i></label>
												<input type="radio" name="trophies-rating" id="trophies-rating-2">
												<label for="trophies-rating-2"><i class="fa fa-trophy"></i></label>
												<input type="radio" name="trophies-rating" id="trophies-rating-1">
												<label for="trophies-rating-1"><i class="fa fa-trophy"></i></label>
												Trophies
											</div>
		
											<div class="rating">
												<input type="radio" name="asterisks-rating" id="asterisks-rating-10">
												<label for="asterisks-rating-10"><i class="fa fa-asterisk"></i></label>
												<input type="radio" name="asterisks-rating" id="asterisks-rating-9">
												<label for="asterisks-rating-9"><i class="fa fa-asterisk"></i></label>
												<input type="radio" name="asterisks-rating" id="asterisks-rating-8">
												<label for="asterisks-rating-8"><i class="fa fa-asterisk"></i></label>
												<input type="radio" name="asterisks-rating" id="asterisks-rating-7">
												<label for="asterisks-rating-7"><i class="fa fa-asterisk"></i></label>
												<input type="radio" name="asterisks-rating" id="asterisks-rating-6">
												<label for="asterisks-rating-6"><i class="fa fa-asterisk"></i></label>
												<input type="radio" name="asterisks-rating" id="asterisks-rating-5">
												<label for="asterisks-rating-5"><i class="fa fa-asterisk"></i></label>
												<input type="radio" name="asterisks-rating" id="asterisks-rating-4">
												<label for="asterisks-rating-4"><i class="fa fa-asterisk"></i></label>
												<input type="radio" name="asterisks-rating" id="asterisks-rating-3">
												<label for="asterisks-rating-3"><i class="fa fa-asterisk"></i></label>
												<input type="radio" name="asterisks-rating" id="asterisks-rating-2">
												<label for="asterisks-rating-2"><i class="fa fa-asterisk"></i></label>
												<input type="radio" name="asterisks-rating" id="asterisks-rating-1">
												<label for="asterisks-rating-1"><i class="fa fa-asterisk"></i></label>
												Asterisks
											</div>
											<div class="note">
												<strong>Note:</strong> you can use more than 300 vector icons for rating.
											</div>
										</section>
									</fieldset>
		
									<footer>
										<button type="submit" class="btn btn-primary">
											Submit
										</button>
										<button type="button" class="btn btn-default" onclick="window.history.back();">
											Back
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
<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="SendMail.php">
<p><img src="img/logo.gif" width="304" height="42" /></p>
<p><b><font size=4>Cooz EDM System(設定工作)</font></b></p>
<p>發信者 : 
  <input type="text" name="Sender" id="Sender" value="酷栗遊戲" /></p>
<p>E-Mail : 
  <input type="text" name="SenderMail" value="no-reply@edm.cooz.com.tw" id="Sender"  size=30 /></p>
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
<p>E-Mail: </p>
<p>
    <!-- 目前沒用到先隱藏這些選項
  <label>
    <input type="radio" name="EMail_Command" value="1" checked="checked"/>
    全部玩家E-Mail</label>
  <label>
    <input type="radio" name="EMail_Command" value="2"/>
    選擇(Domain name)</label>
  <label>
    <input type="radio" name="EMail_Command" value="3"/>
    自行填入需要的Domain Name</label>
-->
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
  <input type="submit" name="ok" id="ok" value="下一步" />
</p>
</form>
</body>
</html>
