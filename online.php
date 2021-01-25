<?php

require 'moduls/ini.php';
require 'moduls/connect.php';



$online = mysql_fetch_array(mysql_query('SELECT * FROM `online` WHERE `ip` = "'.clean($ip).'";'));
if(empty($online['id'])){
$query = mysql_query("INSERT INTO `online` (`ip`,`time`) VALUES ( '".clean($ip)."','$time');");
}
else{
$query = mysql_query('UPDATE `online` SET `time`='.$time.' WHERE `id` = '.$online['id']);
}

$query = mysql_query('DELETE FROM `online` WHERE '.$time.' - `time` > '.intval($setup['online_time']).' AND `id`<>1;');
$all_online = mysql_fetch_array(mysql_query('SELECT COUNT(*) FROM `online` WHERE `id`<>1;'));
$max_online = mysql_fetch_array(mysql_query('SELECT `time` FROM `online` WHERE `id` = 1;'));
if($all_online[0] > $max_online[0]){
$query = mysql_query('UPDATE `online` SET `time`='.$all_online[0].' WHERE `id` = 1');
}



?>