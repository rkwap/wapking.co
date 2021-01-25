<?php
include 'moduls/ini.php';
include 'moduls/connect.php';
include 'moduls/fun.php';


$id = intval($_GET['id']);
$d = mysql_fetch_row(mysql_query('SELECT TRIM(`path`) FROM `files` WHERE `id` = '.$id.' LIMIT 1'));
click_change();
if(file_exists($d[0])){
mysql_query('UPDATE `files` SET `loads`=`loads`+1, `timeload`='.$time.' WHERE `id`='.$id);
$tex2=$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/'.$d[0];
$tex2=str_replace('\/','/',$tex2);
header('Location: http://'.$tex2,true,301);
}
else{
print $hackmess;
}
?>