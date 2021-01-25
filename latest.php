<?php
require 'moduls/ini.php';
require 'moduls/fun.php';
require 'moduls/connect.php';

echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';echo "
<meta name=\"title\" content=\" Funwap.Org - $list[3]|$put1\"/>";echo '
<meta name="robots" content="index,follow"/>
<meta name="language" content="en" />';echo "
<meta name=\"description\" content=\" Funwap.Org - $list[3].$ext|$put1\"/>";echo "
<meta name=\"keywords\" content=\"$list[3],wapking,android games,android apps,games,wallpapers,mp3,jar,themes,nokia, micromax,wapindia,wapking.in,free games\"/>";echo "

<title>Funwap.Org - $list[3]|$put1</title>";echo '
<link rel="shortcut icon" href="icon.ico" />';echo '
<link href="http://m.krazysms.in/css/krazysms_m.css?1.2" rel="stylesheet" style="text/css">

</head>
<body>    
         <div class="logo"><img alt="Wapking" src="http://m.wapsms.in/images/m.WapSMS.in_logo.gif" /><br></div>


';

require 'online.php';
###############???? ??? ????????###############
if($setup['top_change'] == 0) die('Not found');
###############???????? ??????????###############

$onpage = 10;
$latest_num = 10;

$prew = get2ses('prew');
$sort = name;
$id = intval($_GET['id']);
$page = intval($_GET['page']);

is_num($onpage,'onpage');
is_num($prew,'prew');

if($prew != 0 and $prew != 1){
$prew = $setup['preview'];
}


$valid_sort = array('load' => '','eval' =>'');
if(!isset($valid_sort[$sort])) $sort = 'name';
if($sort == 'name') $MODE = '`name` > 0 ORDER BY `name` DESC';
if($sort == 'eval' and $setup['eval_change']) $MODE = '`yes` > 0 ORDER BY `yes` DESC';


###############???????? ?????? ??????###############
$query = mysql_query('SELECT * FROM `files` WHERE '.$MODE.' LIMIT 0, '.$latest_num);

while($list_sw = mysql_fetch_array($query)){
$array_id[] = $list_sw['id'];
}
$all = sizeof($array_id);
###############?????###############
require 'searchbox.php';
echo '<h1>Latest SMS</h1>';
###############C???????###############
if(!isset($page)) $page=1;
$n = 0;
$pages = ceil($all/$onpage);
if(!$pages) $pages = 1;
if ($page) $n = ($onpage*$page)-$onpage;
###############???? ?? ???...###########
if($all == 0) echo 'While empty :(';
###############????? ??????#############
for($i=1; $i<=$onpage; $i++)
{
if(!isset($array_id[$n])){
$n++;
continue;
}
if(is_integer($n / 2)) $row = '<div class="a">'; else $row = '<div class="a">';
$file_info = mysql_fetch_array(mysql_query('SELECT * FROM `files` WHERE `id` = '.$array_id[$n]));
$file_info2 = mysql_fetch_array(mysql_query('SELECT * FROM `files` WHERE `id` = '.$array_id[$n]));
$backdir = @mysql_fetch_array(mysql_query("SELECT * FROM `files` WHERE `path` = '".clean($file_info['infolder'])."'"));
$basename = basename($file_info['path']);
$ex = pathinfo($file_info['path']);
$ext = strtolower($ex['extension']);
$name_file = str_replace('.'.$ex,'',$basename);
//????????
if(strpos($basename , '!') !== false){
$name_file = trans($name_file);
}
else{
$name_file = trans2($name_file);
}
//?????? ? ?????
if($setup['ext']==1) $extension = '('.$ext.')'; else $extension = '';

$s['name'] = str_replace('*','',$backdir['name']);


echo $row.$pre.' '.$ico.'<strong><a href="view.php?id='.$file_info['id'].'">'.$name_file.'</a></strong>'.$extension.$file_info['size'].$info.'[<a href="index.php?id='.$backdir['id'].'">In category</a>]<br></div>';


if($setup['ext']==1) $extension = "($ext)"; else $extension = '';
if (is_file($setup['opath'].'/'.$name_file.'.txt')) //???? ??? ? ?????
	{
 	$f = file_get_contents($setup['opath'].'/'.$name_file.'.txt');
 	$f=substr($f,0,300);
 	$f = htmlentities($f, ENT_QUOTES, 'UTF-8');
	echo ''.$f.'...';
	$outp=1;
	}

if ($ext == 'txt') {$popis22=file_get_contents($file_info2['path']);

$popis=file_get_contents($file_info2['path']);
$popis=substr($popis,0,1000000);
echo ''.$row.'<div class="smsBy">By: <a href=""><strong>'.$name_file.'</strong></a> In: <a href=""><strong>'.$s['name'].'</strong></a></div>'.$popis.'<br>';


$popistxt = str_replace('<br>','',$popis);
$popistxt = str_replace('<p class="sms">','',$popistxt);
$popistxt = str_replace('</p>','',$popistxt);

echo '<div class="smsInfo">';
if($setup['eval_change'] == 1)
{
	$i = @round(($file_info['yes'])/($file_info['yes']+$file_info['no'])*100,0);

echo '<div>Like: '.$file_info['yes'].' - SMS Length: ';
echo strlen($popis);
echo'</div>';

if ($vote==0) 

echo '<div><a href="http://m.funwap.org/indexsms.php?id='.$file_info['id'].'&eval=1"><img src="http://m.krazysms.in/images/heart.png">Like SMS</a> - <a href="sms:?body='.$popistxt.' - By SMS.in">Forward SMS</a></div>';

echo '<div><a href="mailto:?subject=An SMS For You - SMS.In&body='.$popistxt.' - By SMS.in">Send By Email</a></div>';

$file_info['timeupload'] = date('D - d:F:Y (g:i A)', $file_info['timeupload']);

echo '<div>'.$file_info['timeupload'].' ago</div>';
}
echo '</div>';
echo '<div class="liner"></div>';

}
$n++;
}
//------------------------------------------------------------------------------------------
echo '
<div class="a">Pages: ';
$asd = $page - 2;
$asd2 = $page + 3;
if($asd<$all && $asd>0 && $page>3) echo '<a href="latest.php?page=1">1</a> ... ';
for($i=$asd; $i<$asd2;$i++)
{
if($i<$all && $i>0)
{
if ($i > $pages ) break;
if ($page==$i) 	echo '<strong>['.$i.']</strong> ';
else echo '<a href="latest.php?page='.$i.'">'.$i.'</a> ';
}
}

if ($i <= $pages)
{
if($asd2<$all) echo ' ... <a href="latest.php?page='.$pages.'">'.$pages.'</a></div>';
}
//------------------------------------------------------------------------------------------
echo '
</div>
<div class="menu1"><div class="menu3"><a href="index.php?">Downloads</a></div>
<div class="menu1"><a href="'.$setup['site_url'].'">Home</a></div>
';
echo '</div>';
if($setup['online'] == 1)echo '<div class="menu">Online: <strong>'.$all_online[0].'</strong></div>';
echo'<div class="title">';
include 'moduls/foot.php';
echo '</div>';
?>