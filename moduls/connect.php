<?php
require 'config.php';

$link = mysql_connect($SERVERmysql, $DB_USER, $DB_PASS) or die('Could not connect');
$db_id = mysql_select_db($DB, $link) or die('Could not db');
$charset = mysql_query('SET NAMES `utf8`');

if($_SERVER['HTTP_X_FORWARDED_FOR']){
$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else if($_SERVER['HTTP_CLIENT_IP']){
$ip=$_SERVER['HTTP_CLIENT_IP'];
}
else if($_SERVER['REMOTE_ADDR']){
$ip=$_SERVER['REMOTE_ADDR'];
}

$time = time();
$setting = mysql_query('SELECT * FROM `setting`;');

while($set = mysql_fetch_assoc($setting)){
$setup[$set['name']] = $set['value'];
}
$hackmess = $setup['hackmess'];
?>