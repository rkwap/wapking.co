<?php
require 'moduls/ini.php';
require 'moduls/fun.php';
require 'moduls/connect.php';
require 'online.php';
session_name('SID') ;
if(session_start()){
if(!empty($_SESSION["onpage"]) AND !empty($_GET['onpage'])){
$_SESSION["onpage"]=$_GET['onpage'];}
elseif(empty($_SESSION["onpage"]) AND !empty($_GET['onpage'])){
$onpage=$_GET['onpaget'];
session_register ("onpage") ;}
if(!empty($_SESSION["prew"]) AND !empty($_GET['prew']))
$_SESSION["prew"]=$_GET['prew'];
elseif(empty($_SESSION["prew"]) AND !empty($_GET['prew'])){
$prew=$_GET['prew'];
session_register ("prew") ;}
if(!empty($_SESSION["sort"]) AND !empty($_GET['sort']))
$_SESSION["sort"]=$_GET['sort'];
elseif(empty($_SESSION["sort"]) AND !empty($_GET['sort'])){
$sort=$_GET['sort'];
session_register ("sort") ;}}
$onpage = intval($_SESSION["onpage"]);
$prew = intval($_SESSION["prew"]);
$sort = get2ses('sort');
$id = intval($_GET['id']);
if (!empty ($_POST['page'])){
$page = intval($_POST['page']);}
else {$page = intval($_GET['page']);}
$start = intval($_GET['start']);
if($onpage < 3){
$onpage = 10;}
if($prew != 0 and $prew != 1){
$prew = $setup['preview'];}
$valid_sort = array('name' => '','new2old' => '','load' => '','size' => '','eval' =>'');
if(!isset($valid_sort[$sort])){$sort='name';}
$MODE = '`priority` DESC,`name` ASC';
if($sort == 'new2old') $MODE = '`priority` DESC,`timeupload` DESC';
elseif($sort == 'size') $MODE = '`priority` DESC,`size` ASC';
elseif($sort == 'load') $MODE = '`priority` DESC,`loads` DESC';
elseif($sort == 'eval' && $setup['eval_change']) $MODE = '`priority` DESC,`yes` DESC ,`no` ASC';
if(!$id){$d['path'] = $setup['path'].'/';}else{
$d = mysql_fetch_assoc(mysql_query('SELECT `path` FROM `files` WHERE `id` = '.$id.' LIMIT 1'));}
if(!is_dir($d['path'])) die('Folder not found.</body></html>');
$all = mysql_fetch_row(mysql_query('SELECT COUNT(`id`) FROM `files` WHERE `infolder` = "'.$d['path'].'"'));
$all = $all[0];
$pages = ceil($all/$onpage);
if(!$pages) $pages = 1;
if($page>$pages or $page<=0) $page=1;
if($start>$all or $start<=0) $start = 0;
if($page) $start = ($page - 1) * $onpage; else $start = 0;
$array_id = array();
$query = mysql_query('SELECT `id` FROM `files` WHERE `infolder` = "'.$d['path'].'" ORDER BY '.$MODE.' LIMIT '.$start.', '.$onpage);
while($list_sw = mysql_fetch_row($query)){
$array_id[] = $list_sw[0];}
$ex = explode('/',$d['path']);
foreach($ex as $k=>$v){
if($v!='' and $v!='.' and $v!='..' and $v!=$setup['path']){
$s = mysql_fetch_array(mysql_query("SELECT `id`,`name` FROM `files` WHERE `path` LIKE '%".clean($v)."/' AND `size` = '0'"));
$s['name'] = str_replace('*','',$s['name']);
$ssort = str_replace(' ','-',$s['name']);
$fullo = str_replace(' ','-',$s['name']);
$sturl = "http://m.funwap.org/Category/";
$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if($k >= sizeof($ex)-2) $put .= '<a href="'.$url.'">'.$s['name'].'</a>';
else $put .= '<a href="'.$sturl.''.$s['id'].'/'.$fullo.'.html">'.$s['name'].'</a> &raquo; ';
if($k >= sizeof($ex)-2) $title .= ''.$s['name'].'|';
else $title .= ''.$s['name'].'|';}}
include 'moduls/header.php';
echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="Funwap.Org - '.$title.'" />
';
echo '<meta name="robots" content="index, follow" />
<meta name="language" content="en" />
<link rel="shortcut icon" href="icon.ico" />';

echo '<title>';
echo 'Funwap.Org - '.$title.'';
echo '</title><link href="http://m.funwap.org/style.css" rel="stylesheet" style="text/css">

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>        
<meta http-equiv="Pragma" content="no-cache"/>         
<meta http-equiv="Expires" content="0"/> 
<meta name="geo.placename" content="India" />
<meta name="description" content="wapking.net78.net offers large collection of mp3 ringtones, mobile games, android apps, 3D wallpapers, themes, hd videos in mp4, whatsapp video clips and many more for free at waploft hub." />
<meta name="keywords" content="wapking, wapking.net78.net, waploft, whatsapp videos, wapking games, wapking pc, ringtones and wallpaper, wepking, webking, wapin, bestwap.in, wap king">
<meta name="author" content="wapking.net78.net">
<meta name="revisit-after" content="5 days" />
<meta name="copyright" content="wapking.net78.net">
<meta name="generator" content="wapking.net78.net">
<meta name="creationdate" content="2014">
<meta name="distribution" content="global">
<meta name="rating" content="general">


</head>
<body>

         <div class="logo"><img alt="Wapking" src="http://freemaza.in/images/FreeMaza.in_logo.gifaaa" /><br></div>
         <center><font color="#FF0000"><b>Free Maza For Your Phone</b></font></center>


';
if($setup['buy_change']==1){echo '';
$list = explode("\n",$setup['buy']);
if($setup['randbuy']==1) echo ''.bbcode($list[mt_rand(0,sizeof($list)-1)]).'</div>';
else foreach($list as $value) echo '';
echo'';
if (!$s['name']) { include 'searchbox.php';}
else echo '';
if (!$s['name']) { include 'update.php';}
else echo '';
if (!$s['name']) { echo '';}
else include 'ads/ad1.php';
echo '
          <!-- Wapking :: Display category list -->
          <div id="cateogry">
          <h2>';
if (!$s['name']) { echo 'Select Categories';}
else echo $s['name'];
echo '</h2>
          ';
include 'user2.php';
echo '

<table>';}
if ($all == 0) echo '';
foreach($array_id as $key => $value){
 	$file_info = mysql_fetch_array(mysql_query('SELECT `id`,`name`,`path`,`fastabout`,`timeupload`,`infolder`,`size`,`loads`,`yes`,`no` FROM `files` WHERE `id` = "'.$value.'";'));
	if(is_dir($file_info['path'])){
   	if(is_integer($key / 2)) $row = '

                              <div class="catRow">
                       '; else $row = '

                  </div>
          
                              <div class="catRow">
                       ';
 	if (!empty($file_info['fastabout'])) $file_info['about'] = str_replace("\n", '<br>',$file_info['about']);
   		$new_all="";
        $stime=$time-(3600*24*$setup['day_new']);
   		if($setup['day_new']!=0) $new_all = mysql_fetch_array(mysql_query('SELECT COUNT(*) FROM `files` WHERE `timeupload` > "'.$stime.'" AND `infolder` LIKE  "'.$file_info['path'].'%" AND `size` > "0";'));
		if($new_all[0] and $setup['day_new']!=0) $new_all = '<img src="http://m.funwap.org/ext/updated.gif">';
                else $new_all="";
   		$allinfolder = mysql_fetch_array(mysql_query('SELECT COUNT(*) FROM `files` WHERE `infolder` LIKE  "'.$file_info['path'].'%" AND `size` > "0";'));
		$name = str_replace('*','',$file_info['name']);
	$name32=$file_info['path'];
  	$name32=str_replace('files/','',$name32);
  		$name32=str_replace('/',';',$name32);
  			$name32=str_replace('_',' ',$name32);
		if (is_file('razdely/'.$name32.'.txt')){
 	$razd = file_get_contents('razdely/'.$name32.'.txt');
$razdely= '<div class="block_top_s_l"> '.$razd.'</div>';
echo $razdely;}
if(!file_exists($file_info['path'].'folder.png')) $ico = '<img src="http://freemaza.in/images/arrow.png" alt="">'; else $ico = '<img src="'.$file_info['path'].'folder.png" alt="">';
$name22 = str_replace('*','',$file_info['name']);
$name22 = str_replace(' ','-',$name22);
$uuurl = "http://m.funwap.org/Category/$file_info[id]";
$uunewurl = $uuurl . "/$name22.html";
                if (!empty($name) and !$block){
if (!$s['name']) { echo ''.$row.''.$ico.'';}
else echo ''.$row.'';
echo ' <strong><a href="'.$uunewurl.'">'.$name.' ['.$allinfolder[0].']</strong></a>';
   		if($new_all) echo ''.$new_all.'';
        if(!empty($file_info['fastabout'])) echo '<br>'.str_replace("\n", '<br>',$file_info['fastabout']);
   		echo '</div>';}}
 	elseif(is_file($file_info['path'])){
 		if(is_integer($key / 2)) $row = ''; else $row = '';
 	if (!empty($file_info['fastabout'])) $file_info['about'] = str_replace("\n", '<br>',$file_info['about']);
  		$ex = pathinfo($file_info['path']);
 		$ext = strtolower($ex['extension']);
      click_change();
  		$pre = '';
  		if($file_info['size'] < 1024) $file_info['size'] = '('.$file_info['size'].'b)';
  		if($file_info['size'] < 1048576 and $file_info['size'] >= 1024) $file_info['size'] = '('.round($file_info['size']/1024, 2).'Kb)';
  		if($file_info['size'] > 1048576) $file_info['size'] = '('.round($file_info['size']/1024/1024, 2).'Mb)';
  		$id2=$file_info[id];
$file_info2 = mysql_fetch_array(mysql_query('SELECT * FROM `files` WHERE `id` = '.$id2));
if (!is_file ($file_info2['path']))  die('');  		
$filename = pathinfo($file_info2['path']);
$ext = $filename['extension'];
$dir = $filename['dirname'].'/';
$filename = $filename['basename'];
$id = intval($_GET['id']);
$back = mysql_fetch_array(mysql_query("SELECT * FROM `files` WHERE `path` = '".clean($dir)."'"));	
$bolt=0;
if(($ext == 'avi' || $ext == '3gp' || $ext == 'mp4') && extension_loaded('ffmpeg')){
$pre = '<img class="timg" src="\ffmpeg.php?id='.$file_info['id'].'" alt="'.$file_info['name'].'.'.$ext.'"/><br>';
$bolt=1;}

if($ext == 'mp3' or $ext == 'wav'){
if ( 
    !$h_ua || 
    strpos($h_ua, 'windows') !== false    || 
    strpos($h_ua, 'linux') !== false    || 
    strpos($h_ua, 'bsd') !== false        || 
    strpos($h_ua, 'x11') !== false        || 
    strpos($h_ua, 'unix') !== false        || 
    strpos($h_ua, 'macintosh') !== false    || 
    strpos($h_ua, 'macos') !== false) 
    {
echo''; }}
echo '

           <tr class="odd">
                   ';
if ($ext == 'gif' or $ext == 'jpeg' or $ext == 'jpg' or $ext == 'png' or $ext == 'JPG' or $ext == 'GIF' or $ext == 'PNG' or $ext == 'JPEG' or $ext == 'nth' or $ext == 'thm' or $ext == 'jar' or $ext == 'apk' or $ext == 'ipa'){echo '<td class="tblimg">';}
else{echo '<td colspan="2">';}
if(!file_exists('ext/'.$ext.'.png') ) $ico = '<img src="" alt="">';
elseif ($ext =='jar')  $ico = '';
if($setup['ext']==1) $extension = "($ext)"; else $extension = '';
echo $row;
$size1=str_replace(')',']',$file_info['size']);
$size2=str_replace('(','[',$size1);
$info=str_replace('(',']',$info);
$info=str_replace(')','',$info);
$filenamedd = pathinfo($file_info['name']);
$filenamedd = $filenamedd['basename'];
$filenamedd = str_replace(' ','-',$filenamedd);

$filenamedd = str_replace('(m.funwap.org)','',$filenamedd);
$filenamedd = str_replace('(M.Funwap.Org)','',$filenamedd);
$filenamedd = str_replace('-Funwap.ORG','',$filenamedd);

$urlhh = "http://m.funwap.org/Download/$file_info[id]";
$newUrl = $urlhh . "/$filenamedd.html";


///////////////////WallPapers///////////////////////////////////
if ($ext == 'gif' or $ext == 'jpeg' or $ext == 'jpg' or $ext == 'png' or $ext == 'JPG' or $ext == 'GIF' or $ext == 'PNG'or $ext == 'JPEG'){
$pre = '<a href="'.$newUrl.'"><img class="timg" src="http://m.funwap.org/thumber.php?img='.$file_info['path'].''.$file_info['ext'].'&h=100" height="70" width="60 alt="'.$file_info['name'].'.'.$ext.'"/></a>';}


if(file_exists("Thumbs/Wallpapers/$filename"))
{$pre = '<a href="'.$newUrl.'"><img class="timg" src="http://m.funwap.org/Thumbs/Wallpapers/'.$filename.'" height="70" width="60 alt="'.$file_info['name'].'.'.$ext.'"/></a>';}

//////////////////////Android Apps And Games //////////////////////////////////
if($ext == 'apk'){
$pre =  '<a href="'.$newUrl.'"><img  class="timg" src="/apk2.php?file=http://m.funwap.org/apk.php?lf='.$file_info['path'].'&id='.$file_info[id].'.jpg&h=100" height="70" width="60" alt="'.$file_info['name'].'.'.$ext.'"></a>';}

if(file_exists("Thumbs/Android_Zone/$filename.jpg"))

{$pre = '<a href="'.$newUrl.'"><img class="timg" src="http://m.funwap.org/Thumbs/Android_Zone/'.$filename.'.jpg" height="70" width="60 alt="'.$file_info['name'].'.'.$ext.'"/></a>';}
//////////////////////Iphone Apps And Games //////////////////////////////////

if($ext == 'ipa'){
$pre =  '<a href="'.$newUrl.'"><img  class="timg" src="/ipa2.php?file=http://m.funwap.org/ipa.php?lf='.$file_info['path'].'&id='.$file_info[id].'.jpg&h=100" height="70" width="60" alt="'.$file_info['name'].'.'.$ext.'"></a>';}
if(file_exists("Thumbs/IPhone_Zone/$filename.jpg"))
{$pre = '<a href="'.$newUrl.'"><img class="timg" src="http://m.funwap.org/Thumbs/IPhone_Zone/'.$filename.'.jpg" height="70" width="60 alt="'.$file_info['name'].'.'.$ext.'"/></a>';}

/////////////////////// Jar Files ///////////////////////////////////
if($ext == 'jar'){
$pre =  '<a href="'.$newUrl.'"><img  class="timg" src="/jar2.php?file=http://m.funwap.org/jar.php?lf='.$file_info['path'].'&id='.$file_info[id].'.jpg&h=100" height="70" width="60" alt="'.$file_info['name'].'.'.$ext.'"></a>';}

if(file_exists("Thumbs/Games/$filename.jpg"))
{$pre = '<a href="'.$newUrl.'"><img class="timg" src="http://m.funwap.org/Thumbs/Games/'.$filename.'.jpg" height="70" width="60 alt="'.$file_info['name'].'.'.$ext.'"/></a>';}

//////////////////////////////////////////////////////////////
if($ext == 'thm' or $ext == 'nth'){
$pre =  '<img  class="timg" src="/theme.php?id='.$file_info['id'].'&amp;W=60&amp;H=70" height="70 "width="60" alt="'.$file_info['name'].'.'.$ext.'">';}

if(file_exists("Thumbs/Themes/$filename.gif"))
{$pre = '<a href="'.$newUrl.'"><img class="timg" src="/Thumbs/Themes/'.$filename.'.gif" height="70" width="60 alt="'.$file_info['name'].'.'.$ext.'"/></a>';}


/////////////////////////////////////////////////////////////////////////






echo ''.$pre.'';
if ($ext == 'gif' or $ext == 'jpeg' or $ext == 'jpg' or $ext == 'png' or $ext == 'JPG' or $ext == 'GIF' or $ext == 'PNG'or $ext == 'JPEG' or $ext == 'nth' or $ext == 'thm' or $ext == 'jar' or $ext == 'apk' or $ext == 'ipa'){echo '</td><td>';}else{echo '';}      
       $file_info['name'] = str_replace('(m.funwap.org)','',$file_info['name']);
       $file_info['name'] = str_replace('(M.Funwap.Org)','',$file_info['name']);
       $file_info['name'] = str_replace('-Funwap.ORG','',$file_info['name']);
       echo '<a href="'.$newUrl.'"><strong>'.$file_info['name'].'.'.$ext.'</strong></a>
       <br><br>'.$size2.'';
  	echo'<br style="clear:both;"></td></tr>';}}
echo '

   </table>';
if (!$s['name']) { echo '';}
else include 'ads/ad2.php';
echo '
                              <div class="pgn">
   ';
$next= $page + 1;
$prev= $page - 1;
$name221 = str_replace('*','',$s['name']);
$name221 = str_replace(' ','-',$name221);
$uuurlprev = "http://m.funwap.org/Category/$id";
$uunewurlprev = $uuurlprev . "/$name221";
if ($prev>"0"){echo '<a class="page" href="'.$uunewurlprev.'/'.$prev.'.html"><img src="http://m.funwap.org/ext/prev.png"></a>';}
$asd= $page - 1;
$asd2= $page + 4; if ($pages>1){
if($asd<$all && $asd>0 && $page>4 ) 
if ($page>"1"){echo '';}
else{echo '<a class="page" href="'.$uunewurlprev.'/1.html">1</a> ';}
for($i=$asd; $i<$asd2;$i++){if($i<$all && $i>0){if ($i > $pages )  break;
if ($page==$i) echo '                           <!-- Wapking :: Pagination --><span class="page"><b>'.$i.'</b></span> ';
else echo '
<a class="page" href="'.$uunewurlprev.'/'.$i.'.html">'.$i.'</a> ';}}
if ($i <= $pages){if($asd2<$all)if ($page<$pages){echo '';}
else{echo '<a class="page" href="'.$uunewurlprev.'/'.$pages.'.html">'.$pages.'</a>';}}
$namenext = str_replace('*','',$s['name']);
$namenext = str_replace(' ','-',$namenext);
$uuurlnext = "http://m.funwap.org/Category/$id";
$uunewurlnext = $uuurlnext . "/$namenext";
if ($page<$pages && $page>0){
echo '<a class="page" href="'.$uunewurlnext.'/'.$next.'.html"><img src="http://m.funwap.org/ext/next.png"></a>';}
echo '<br>
Page('.$page.'/'.$pages.')

';
echo '
<!-- Wapking :: Jump To Page -->
<form action="" method="post">
Jump to Page 
<input class="enter" name="page" type="text" maxlength="4" size="2" value="">
&nbsp;<input class="buttom" type="submit" value="Go&raquo;">
</form>
</div>';}
echo '</div>';
if (!$s['name']) { echo '';}
else echo '<div class="path"><strong><a href="'.$setup['site_url'].'">Home</a></strong> &raquo; <strong> '.$put.' </strong></div><br>';
if (!$s['name']) { include 'bottom.php';}
else echo '';
echo '

<br>

<div class="ftrLink">
     <a href="/" class="siteLink">m.funwap.org</a>
     </div>
     </div>
     ';

require 'ads/ad1.php';

if (!$s['name']){
echo '

<br>
Online: <strong>'.$all_online[0].'</strong>
</div>
';}
else echo '';
echo '
</div>

<!-- br /><small>Development Partner: <a href="http://www.gsmarena.host56.com" class="siteLink">GSMArena.Host56.Com</a></small -->

</body>
</html>';
?>	