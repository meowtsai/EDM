<?PHP

error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

header('Content-Type: application/json');
//--Kenny 2013.1.29 EDM 1
//--EDM.php
//include "./lib/connect_mysql.php";
include "../lib/connect_mysql_local.php";
include "../login.php";
if($_SESSION['EDM_User'] == "meow"){
	$sql_count = "SELECT count(*) FROM EDM.actionmail ";
	$sql = "SELECT ACMNo,
    OwnUser,
    SuccessMail,
    ErrorMail,
    WaitMail,
    Status,
    Create_date,
    Tital,
    OpenedMail, 
    (SuccessMail+ErrorMail+WaitMail) as SuccessMailTotalMail ,
    (select count(*) from errormail a where  a.EMno =actionmail.ACMNo) as Cancelled
    FROM EDM.actionmail Order by Create_date";
}else{
	$sql_count = "SELECT count(*) FROM EDM.actionmail where OwnUser='".$_SESSION['EDM_User']."'";
	$sql = "SELECT ACMNo,OwnUser,SuccessMail,ErrorMail,WaitMail,Status, 
    Create_date,Tital,OpenedMail, (SuccessMail+ErrorMail+WaitMail) as SuccessMailTotalMail,(select count(*) from errormail a where  a.EMno =actionmail.ACMNo) as Cancelled FROM EDM.actionmail where OwnUser='".$_SESSION['EDM_User']."' Order by Create_date";
}
$result = mysqli_query($Conn_local,$sql_count);
List($Action_count)=mysqli_fetch_row($result);


if ($Action_count > 0){
	$result = mysqli_query($Conn_local,$sql);
}


$rows_edmlist = array();
while($row = mysqli_fetch_assoc($result)) {
    
     
    while(list($var, $val) = each($row)) {
        switch ($var) {
        case "Status":
                //EDM_List.php?Action=s&ACMNo='.$row['ACMNo'].'">
                //case Status when 'f' then '完成' when 'w' then '' when 'a' then '排程進行中<a id=\"cmdAction\" class=\"btn btn-primary btn-sm\">暫停排程</a>' when 's' then '工作暫停<a  id=\"cmdAction\" class=\"btn btn-primary btn-sm\">啓動排程</a>' end as 'Status'
            if ($row[$var]=='f')
            {
                $row[$var]="<font color=green>完成</font>";    
            }
            elseif ($row[$var]=='w')
            {
                $row[$var]="等待中 &nbsp;&nbsp;&nbsp;<a href=\"EDM_List.php?Action=s&ACMNo=". $row['ACMNo']."\"  class=\"btn btn-primary btn-sm\">暫停排程</a>";    
            } 
            elseif ($row[$var]=='a')
            {
                $row[$var]="排程進行中&nbsp;&nbsp;&nbsp;<a href=\"EDM_List.php?Action=s&ACMNo=". $row['ACMNo']."\" class=\"btn btn-primary btn-sm\">暫停排程</a>";    
            } 
            elseif ($row[$var]=='s')
            {
                $row[$var]="<font color=red>工作暫停中&nbsp;&nbsp;&nbsp;</font> <a  href=\"EDM_List.php?Action=a&ACMNo=". $row['ACMNo']."\"  class=\"btn btn-primary btn-sm\">啓動排程</a>";    
            } 
                
            
            break;
            case "SuccessMailTotalMail":
                $row[$var]= $row[$var]. "/<font color=red>" .$row['SuccessMail'] ."</font>";
                break;
            //CONCAT(SuccessMail ,'/',(SuccessMail+ErrorMail+WaitMail))
        default:
                break;
        }
        
                
   }
    $rows_edmlist[] = $row;
}
echo "{\"data\": " . json_encode($rows_edmlist) ."}";


?>