<?php
require 'moduls/ini.php';
require 'moduls/connect.php';

//header('Content-type: image/gif');

$W = intval($_GET['W']);
$H = intval($_GET['H']);
$id = intval($_GET['id']);

$file_info = mysql_fetch_row(mysql_query('SELECT TRIM(`path`) FROM `files` WHERE `id` = '.$id.' LIMIT 1'));
$pic = urldecode(htmlspecialchars($file_info[0]));

if(substr($pic,0,1) != '.'){

$mov = new ffmpeg_movie($pic, false);
$wn = $mov->GetFrameWidth();
$hn = $mov->GetFrameHeight();

$frame = $mov->getFrame(3);

$gd = $frame->toGDImage();

if(!$W and !$H)
{
$size = explode('*',$setup['prev_size']);
$W = round(intval($size[0])); // picture width
$H = round(intval($size[1])); // picture height
}
$new = imageCreateTrueColor($W, $H);
imageCopyResized($new, $gd, 0, 0, 0, 0, $W, $H, $wn, $hn);
imageGif($new,null,100);

}
?>