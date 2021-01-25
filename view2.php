<?php
require 'moduls/config.php';
require 'moduls/fun.php';
require 'online.php';
$id = intval($_GET['id']);
is_num($_GET['eval'],'eval');
$file_info = mysql_fetch_assoc(mysql_query('SELECT * FROM `files` WHERE `id` = '.$id));
if(!is_file($file_info['path'])){
die('File does not exist');}
$file_info['name'] = str_replace('(M.Funwap.Org)','',$file_info['name']);
$file_info['name'] = str_replace('(m.funwap.org)','',$file_info['name']);
$sql = @mysql_query("SELECT * FROM files WHERE id='".$id."'");
while($line = mysql_fetch_array($sql))
{
$return[] = $line;
 }
foreach ($return as $list)
{

$filename = pathinfo($file_info['path']);
$ext = strtolower($filename['extension']);
$dir = $filename['dirname'].'/';
$filename = $filename['basename'];
$ex = explode('/',$dir);
$back = mysql_fetch_assoc(mysql_query("SELECT * FROM `files` WHERE `path` = '".clean($dir)."'"));
$sizeof = sizeof($ex)-2;}
foreach($ex as $k=>$v)
{

if($v!='' and $v!='.' and $v!='..' and $v!=$setup['path'])
{
$s = mysql_fetch_array(mysql_query("SELECT `id`,`name` FROM `files` WHERE `path` LIKE '%".clean($v)."/' AND `size` = '0'"));
$s['name'] = str_replace('*','',$s['name']);
$url=str_replace(" ","_",$s['name']);
$url=str_replace("_","-",$url);
$put .= '<a href="/Category/'.$s['id'].'/'.$url.'/1.html">'.$s['name'].'</a> &raquo; ';
$put1 .= ''.$s['name'].'|';}}
if($file_info['size'] < 1024){
$file_info['size'] = $file_info['size'].'b';}
elseif($file_info['size'] < 1048576 and $file_info['size'] >= 1024){
$file_info['size'] = round($file_info['size']/1024, 2).'Kb';}
else{
$file_info['size'] = round($file_info['size']/1024/1024, 2).'Mb';}


include 'moduls/header.php';
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
<link href="http://m.funwap.org/style.css" rel="stylesheet" style="text/css">

</head>
<body>    
         <div class="logo"><img alt="Wapking" src="http://freemaza.in/images/FreeMaza.in_logo.gif" /><br></div>


';
include 'ads/ad1.php';
echo '<h2>Free Download '.$file_info['name'].'.'.$ext.'</h2>';
echo '<div class="tCenter">';
if($ext == 'jar'){
echo '
   <img class="timg" src="http://m.funwap.org/Thumbs/Games/'.$filename.'.jpg" height="80" width="80 alt="'.$filename.'">';}
if($ext == 'apk'){
echo '
   <img class="timg" src="http://m.funwap.org/Thumbs/Android_Zone/'.$filename.'.jpg" height="80" width="80 alt="'.$filename.'">';}
if($ext == 'ipa'){
echo '
   <img class="timg" src="http://m.funwap.org/Thumbs/IPhone_Zone/'.$filename.'.jpg" height="80" width="80 alt="'.$filename.'">';}
$ext = strtolower($ext);
if ($ext == 'gif' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'jpe' or $ext == 'png'){		
echo '

<div class="tCenter">
           <img class="timg" src="http://m.funwap.org/Thumbs/Wallpapers/'.$filename.'" height="80" width="80 
alt="'.$filename.'"></div>
                           
                              Select Your Screen Size:<br/>

<a class="fileName" href="\Image/'.$id.'/128/128.html">128x128</a> , 
<a class="fileName" href="\Image/'.$id.'/128/128.html">128x128</a> ,
<a class="fileName" href="\Image/'.$id.'/220/176.html">176x220</a><br>
<a class="fileName" href="\Image/'.$id.'/176/220.html">220x176</a> ,
<a class="fileName" href="\Image/'.$id.'/320/240.html">240x320</a> ,
<a class="fileName" href="\Image/'.$id.'/400/240.html">240x400</a><br>
<a class="fileName" href="\Image/'.$id.'/240/320.html">320x240</a> ,
<a class="fileName" href="\Image/'.$id.'/480/320.html">320x480</a> ,
<a class="fileName" href="\Image/'.$id.'/640/360.html">360x640</a><br>
<a class="fileName" href="\Image/'.$id.'/320/480.html">480x320</a> ,
<a class="fileName" href="\Image/'.$id.'/640/480.html">480x640</a> ,
<a class="fileName" href="\Image/'.$id.'/800/480.html">480x800</a><br>
<a class="fileName" href="\Image/'.$id.'/480/640.html">640x480</a> ,
<a class="fileName" href="\Image/'.$id.'/1280/720.html">720x1280</a> ,
<a class="fileName" href="\Image/'.$id.'/800/960.html">960x800</a><br>
<a class="fileName" href="\Image/'.$id.'/960/1080.html">1080x960</a> ,
<a class="fileName" href="\Image/'.$id.'/1280/1440.html">1440x1280</a></div>';}
elseif($ext == 'jar'){
include 'jar_info.php';
echo '<div class="tCenter"><b>Developer:'.$poz.'</b><br></div>';
echo '<div class="tCenter"><b>Version:'.$ver.'</b><br>';
echo '</div>';}

elseif($ext == 'mp3' or $ext == 'wav'){
echo '<br><embed src= "http://m.funwap.org/wapking_player.swf" width="270" height="22" quality="high" allowScriptAccess="always" wmode="transparent"  type="application/x-shockwave-flash" flashvars= "playerID=0&amp;bg=0xffffff&amp;leftbg=0x406080&amp;lefticon=0xffffff&amp;rightbg=0xffffff&amp;rightbghover=0x406080&amp;righticon=0x000000&amp;righticonhover=0x000000&amp;text=0x000000&amp;slider=0xffffff0&amp;track=0xcccccc&amp;border=0xFF0000&amp;loader=0x406080&amp;loop=no&amp;autostart=no&amp;soundFile=http://m.funwap.org/'.$file_info['path']. '" bgcolor="#8DAAC7"/>';}
elseif($ext == 'thm' || $ext == 'nth'){
echo '<img class="timg" src="/Thumbs/Themes/'.$filename.'.gif" height="80" width="80" alt="Theme">';}
echo '
    <div class="tCenter">
    <br>';
if ($ext == 'gif' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'jpe' or $ext == 'png'){echo'';}
else{echo '
          <a href="http://m.funwap.org/Load/'.$id.'.html"><strong>[Download File]</strong></a>
          <br>';}
echo '

    <strong>Size : '.$file_info['size'].'</strong>
    ';
echo
    '<br><strong>Downloaded : '.$file_info['loads'].' Times</strong>
     <br>';echo '


     <strong>Send To Friend By:</strong>
     <a href="sms:?body=Hello, I Like to Share Dis Nice Content With u, Check it :  http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'"> SMS</a>
     <b>|</b>
     <a href="mailto:?subject=Hi,Very Nice Content Check It:  &body=Here the link: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'">Email</a>
     ';

echo '<br><a href="https://www.facebook.com/sharer/sharer.php?u=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" target="_blank"><img alt="fb-Share" src="/images/sharebig.gif" width="283" height="53" /></a>';
echo '</div>';
echo '</div>';


include 'ads/ad2.php';
$fulli .= $back['name'];
$fulli = str_replace('*','',$fulli);
$fulli = str_replace(' ','-',$fulli);echo '
<div class="path">

<a href="http://m.funwap.org/Category/'.$back['id'].'/'.$fulli.'/1.html">&#171; Go Back</a>
';
$list[3]=str_replace("(M.Funwap.Org)","",$list[3]);
$list[3]=str_replace("(m.funwap.org)","",$list[3]);echo '
<br>
<a href="http://m.funwap.org"> Home</a> &raquo;  '.$put.' <a href="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'">'.$list[3].'.'.$ext.'</a>
</div></div>
';echo'

<div class="devider">&nbsp;</div>';echo '
<div class="ftrLink"><a href="/">M.Funwap.Org</a></div>';
?>