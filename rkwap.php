<?php


include 'moduls/ini.php';
list($msec,$sec)=explode(chr(32),microtime());
$HeadTime=$sec+$msec;
session_name('SID') ;
session_start() ;
include 'moduls/fun.php';
include 'moduls/connect.php';
$info = mysql_fetch_array(mysql_query('SELECT * FROM `loginlog` WHERE `id`=1'));
$timeban = $time - $info['time'];
//-------------------------------
if($timeban < $setup['timeban']){
include 'moduls/header.php';
die('Следующая авторизация возможна через '.($setup['timeban']-$timeban).' секунд!');
}
//-------------------------------
if($info['access_num'] > $setup['countban'])
{
	include 'moduls/header.php';
	$query = mysql_query('UPDATE `loginlog` SET `time`='.$time.', `access_num`=0 WHERE `id` = 1;');
	die('Вы '.$setup['countban'].' раза ввели неверный пароль.Вы заблокированы на '.$setup['timeban'].' секунд');
}
//-------------------------------
//if ($_SESSION['autorise']!="" && $_SESSION['ip']!="" && $_SESSION['autorise']==$setup['password'] && $_SESSION['ip']==$ip)  header("Location: apanel.php?".SID."");
if(!isset($_POST['p']) and !isset($_GET['p']))
{
include 'moduls/header.php';
echo '<div class=menu>Login Admin:</div><div class=a>
<form method="post" action="rkwap.php?">
Password :<br>
<input class="enter" type="password" name="p"><br>
<input class="buttom" type="submit" value="Submit">
</form></div>';
list($msec,$sec)=explode(chr(32),microtime());
echo '<div class="title">'.round(($sec+$msec)-$HeadTime,4).' сек.<br>[&copy;Sea mod GANJAR and Sl@yer]</div></body></html>';
exit;
}

if(($_POST['p'] && md5(clean($_POST['p'])) == $setup['password']) or ($setup['autologin']==1 && isset($_GET['p']) && $_GET['p']!='' && md5(clean($_GET['p'])) == $setup['password']))
{
$ua = getenv('HTTP_USER_AGENT');
$_SESSION['ipu'] = $ipu = $ip;
mysql_query("INSERT INTO `loginlog` (`ua`, `ip`, `time`) VALUES ('".clean($ua)."', '".clean($ip)."', '".$time."');");
$_SESSION['autorise'] = $autorise = md5(clean($_POST['p']));
header('Location: apanel.php?'.SID);
exit;
}
else{
include 'moduls/header.php';
print 'Password is entered incorrectly. It remains to attempt to lock: '.($setup['countban']-$info['access_num']);
mysql_query('UPDATE `loginlog` SET `access_num`=`access_num`+1 WHERE `id` = 1;');
}
?>