<?php
$date=$_GET['date'];                 
$msg=$_GET['msg'];                   
$msg_trans=$_GET['msg_trans'];       
$operator_id=$_GET['operator_id'];   
$user_id=$_GET['user_id'];           
$smsid=$_GET['smsid'];               
$cost_rur =$_GET['cost_rur'];        
$cost =$_GET['cost'];                
$test =$_GET['test'];                
$num =$_GET['num'];                  
$retry =$_GET['retry'];              
$try =$_GET['try'];                  
$ran =$_GET['ran'];                  
$skey =$_GET['skey'];                
$sign =$_GET['sign'];                
$smsid =$_GET['smsid'];              

if($smsid){
require 'moduls/ini.php';
require 'moduls/fun.php';
require 'moduls/connect.php';
mysql_query('UPDATE `setting` SET `value`=`value`+1 WHERE `name`="send_sms"');

echo "smsid:$smsid\n";
echo "status:reply\n";
echo "\n";
echo ":".$setup['sms_pas']."\n";
}
else die('error');

?>
