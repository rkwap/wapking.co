<?php

require 'moduls/ini.php';
require 'moduls/connect.php';

header('Content-type: image/jpeg');

$W = intval($_GET['W']);
$H = intval($_GET['H']);
$id = intval($_GET['id']);

$file_info = mysql_fetch_row(mysql_query('SELECT TRIM(`path`) FROM `files` WHERE `id` = '.$id.' LIMIT 1'));
$pic = urldecode(htmlspecialchars($file_info[0]));

if(substr($pic,0,1) != '.'){

if(preg_match('/\.gif$/i', $pic)){$old = imageCreateFromGif($pic);}
elseif(preg_match('/\.jpg$|\.jpeg$|\.jpe$/i', $pic)){$old = imageCreateFromJpeg($pic);}
elseif(preg_match('/\.png$/i', $pic)){$old = imageCreateFromPNG($pic);}
{
$wn = imageSX($old);
$hn = imageSY($old);
$prew = 1;
if(!$W and !$H)
{
$prew = 0;
$size = explode('*',$setup['prev_size']);
$W = round(intval($size[0])); // picture width
$H = round(intval($size[1])); // picture height
}
$new = imageCreateTrueColor($W, $H);
imageCopyResampled($new, $old, 0, 0, 0, 0, $W, $H, $wn, $hn);

$text_marker = '<img src="http://wallpapers.wapking.cc/images/WapKing.cc_logo.gif">';

if($text_marker){

$bg = imagecolorallocate($new, 666, 0, 555);

$color = imagecolorallocate($new, 000, 000, 255);

imagestring($new, 2, ($W/2)-(strlen($text_marker)*3), 1, $text_marker, $color);
}

imageJpeg($new,null,100);
if($_GET['bab']==1)
echo'';
else
{
mysql_query('UPDATE `files` SET `loads`=`loads`+1, `timeload`='.$time.' WHERE `id`='.$id);
}
}
}
?>