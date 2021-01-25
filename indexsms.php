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
$onpage2=$_GET['onpaget'];
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
$onpage2 = intval($_SESSION["onpage"]);
$prew = intval($_SESSION["prew"]);
$id = intval($_GET['id']);
is_num($_GET['eval'],'eval');

if (!empty ($_POST['page'])){
$page = intval($_POST['page']);}
else {$page = intval($_GET['page']);}
$start = intval($_GET['start']);
///////////////////

$onpage = 10;

$onpage2 = 5;

/////////////////////
if($prew != 0 and $prew != 1){
$prew = $setup['preview'];}



$valid_sort = array('data' => '','name' => '','load' => '','size' => '','eval' =>'');
if(!isset($valid_sort[$sort])){$sort='timeupload';}
$MODE = '`priority` ASC,`timeupload` DESC';
if($sort == 'name') $MODE = '`priority` DESC,`name` ASC';
elseif($sort == 'size') $MODE = '`priority` DESC,`size` ASC';
elseif($sort == 'eval' && $setup['eval_change']) $MODE = '`priority` DESC,`yes` DESC ,`no` ASC';


if(!$id){$d['path'] = $setup['path'].'/';}else{
$d = mysql_fetch_assoc(mysql_query('SELECT `path` FROM `files` WHERE `id` = '.$id.' LIMIT 1'));}
$all = mysql_fetch_row(mysql_query('SELECT COUNT(`id`) FROM `files` WHERE `infolder` = "'.$d['path'].'"'));
$all = $all[0];
///////////////////////////////////////////


$pages = ceil($all/$onpage);
$pages2 = ceil($all/$onpage2);

////////////////////////////////////////////

if(!$pages) $pages = 1;
if(!$pages2) $pages2 = 1;


if($page>$pages or $page<=0) $page= $page;
if($page>$pages2 or $page<=0) $page= $page;

if($start>$all or $start<=0) $start = 0;
if($page) $start = ($page - 1) * $onpage; else $start = 0;
if($page) $start = ($page - 1) * $onpage2; else $start = 0;
$array_id = array();
$array_id2 = array();
///////////////////////////////////////////////
$query = mysql_query('SELECT `id` FROM `files` WHERE `infolder` = "'.$d['path'].'" ORDER BY '.$MODE.' LIMIT '.$start.', '.$onpage);

$query2 = mysql_query('SELECT `id` FROM `files` WHERE `infolder` = "'.$d['path'].'" ORDER BY '.$MODE.' LIMIT '.$start.', '.$onpage2);

////////////////////////////////////////////////
while($list_sw = mysql_fetch_row($query)){
$array_id[] = $list_sw[0];}

while($list_sw2 = mysql_fetch_row($query2)){
$array_id2[] = $list_sw2[0];}

////////////////////////////////

$ex = explode('/',$d['path']);
foreach($ex as $k=>$v){
if($v!='' and $v!='.' and $v!='..' and $v!=$setup['path']){
$s = mysql_fetch_array(mysql_query("SELECT `id`,`name` FROM `files` WHERE `path` LIKE '%".clean($v)."/' AND `size` = '0'"));
$s['name'] = str_replace('*','',$s['name']);
$ssort = str_replace(' ','-',$s['name']);
$fullo = str_replace(' ','-',$s['name']);
$sturl = "http://m.funwap.org/SMS/";
$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if($k >= sizeof($ex)-2) $put .= '<a href="'.$url.'">'.$s['name'].'</a>';
else $put .= '<a href="'.$sturl.''.$s['id'].'/'.$fullo.'/1.html">'.$s['name'].'</a> &raquo; ';
if($k >= sizeof($ex)-2) $title .= ''.$s['name'].'|';
else $title .= ''.$s['name'].'|';}}

include 'moduls/header.php';
echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta name="title" content="Funwap.Org - '.$title.'" />
';
echo '<meta name="robots" content="index, follow" />
<meta name="language" content="en" />
<link rel="shortcut icon" href="icon.ico" />';

echo '<title>';
echo 'Funwap.Org - '.$title.'';
echo '</title><link href="http://m.krazysms.in/css/krazysms_m.css?1.2" rel="stylesheet" style="text/css">

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

         <div class="logo"><img alt="Wapking" src="http://m.wapsms.in/images/m.WapSMS.in_logo.gif" /><br></div>
         <center><font color="#FF0000"><b>Free Maza For Your Phone</b></font></center>


';
if($setup['buy_change']==1){echo '';
$list = explode("\n",$setup['buy']);
if($setup['randbuy']==1) echo ''.bbcode($list[mt_rand(0,sizeof($list)-1)]).'</div>';
else foreach($list as $value) echo '';
echo'';
include 'searchbox.php';

if (!$s['name']) { echo '';}
else include 'ads/ad1.php';
if (!$s['name']) { echo '<div class="catRow"><img src="/ext/arrow.gif" alt="Arrow" />&nbsp;<a href="/popular/today">Popular SMS</a></div><div class="catRow"><img src="/ext/arrow.gif" alt="Arrow" />&nbsp;<a href="/smslist/type/latest">Latest SMS</a></div>';}
else echo '';


///////////////////////////////////////////////////////

echo '
          <!-- Wapking :: Display category list -->
          <div id="cateogry">
          ';
if (!$s['name']) { echo '<h2>Select Categories</h2>';}
else echo '<h1>'.$s['name'].'</h1>';
echo '

<table>';}

if ($all == 0) echo '';
foreach ($array_id as $key => $value)
{
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

if(!file_exists($file_info['path'].'folder.png')) $ico = '<img src="/ext/arrow.gif" alt="">'; else $ico = '<img src="'.$file_info['path'].'folder.png" alt="">';



$name22 = str_replace('*','',$file_info['name']);
$name22 = str_replace(' ','-',$name22);
$uuurl = "http://m.funwap.org/SMS/$file_info[id]";
$uunewurl = $uuurl . "/$name22/1.html";
                if (!empty($name) and !$block){
if (!$s['name']) { echo ''.$row.''.$ico.'';}
else echo ''.$row.'';

echo ' <a href="'.$uunewurl.'">'.$name.' ['.$allinfolder[0].']</a>';


   		if($new_all) echo ''.$new_all.'';
        if(!empty($file_info['fastabout'])) echo '<br>'.str_replace("\n", '<br>',$file_info['fastabout']);
   		echo '</div>';}}
 	elseif(is_file($file_info['path'])){
 		if(is_integer($key / 2)) $row = ''; else $row = '';
 	if (!empty($file_info['fastabout'])) $file_info['about'] = str_replace("\n", '<br>',$file_info['about']);



$back = mysql_fetch_array(mysql_query("SELECT * FROM `files` WHERE `path` = '".clean($dir)."'"));	
$bolt=0;
}}

/////////////////// Rating  ///////////////////
$file_inforr = mysql_fetch_assoc(mysql_query('SELECT * FROM `files` WHERE `id` = '.$id));

is_num($_GET['eval'],'eval');

if(isset($_GET['eval']) and $setup['eval_change'] == 1)
{
$ips = explode("\n",$file_inforr['ips']);
if(in_array($ip ,$ips) === false)
{
$vote = 0;
if(empty($file_inforr['ips'])){
$ipp = $ip;
}
else{
$ipp = $file_inforr['ips']."\n".$ip;
}

if($_GET['eval']==0){
$str = 'UPDATE `files` SET `no`=`no`+1,`ips`="'.$ipp.'" WHERE `id` = '.$file_inforr['id'];
}
elseif($_GET['eval']==1){
$str = 'UPDATE `files` SET `yes`=`yes`+1,`ips`="'.$ipp.'" WHERE `id` = '.$file_inforr['id'];
}

mysql_query($str);
$vote = 1;
$file_inforr = mysql_fetch_assoc(mysql_query('SELECT * FROM `files` WHERE `id` = '.$id));
}
else $vote = 2;
}

if($setup['eval_change'] == 1)
{
if($vote==1){
die('<div class="info">Your Vote Saved</div>');
}
elseif($vote==2){
die('<div class="error">You Have Already Liked This SMS.</div>');
}
}

///////////////////////////////////////


//////////////////array id ///////////////////////////////////////////////////////////////

/////////////////////////

foreach ($array_id2 as $key => $value2)
{
$file_info2 = mysql_fetch_array(mysql_query('SELECT `id`,`name`,`path`,`fastabout`,`timeupload`,`infolder`,`size`,`loads`,`yes`,`no` FROM `files` WHERE `id` = "'.$value2.'";'));

$file_info = mysql_fetch_array(mysql_query('SELECT `id`,`name`,`path`,`fastabout`,`timeupload`,`infolder`,`size`,`loads`,`yes`,`no` FROM `files` WHERE `id` = "'.$value2.'";'));

$ex = pathinfo($file_info['path']);
$ext = strtolower($ex['extension']);
$id2=$file_info[id];
$file_infoff = mysql_fetch_array(mysql_query('SELECT * FROM `files` WHERE `id` = '.$id2));		
$filename = pathinfo($file_info2['path']);
$ext = $filename['extension'];
$dir = $filename['dirname'].'/';
$filename = $filename['basename'];
$id = intval($_GET['id']);

if($setup['ext']==1) $extension = "($ext)"; else $extension = '';

if (is_file($setup['opath'].'/'.$filename.'.txt')) //если оно в файле
	{
 	$f = file_get_contents($setup['opath'].'/'.$filename.'.txt');
 	$f=substr($f,0,300);
 	$f = htmlentities($f, ENT_QUOTES, 'UTF-8');
	echo ''.$f.'...';
	$outp=1;
	}
 if ($ext == 'txt') {$popis=file_get_contents($file_info2['path']);
  $popis=substr($popis,0,1000000);
  echo ''.$row.'<div class="smsBy">By: <a href=""><strong>'.$file_info['name'].'</strong></a> In: <a href=""><strong>'.$s['name'].'</strong></a></div>'.$popis.'<br>';

//$popistxt = htmlentities($popis, ENT_QUOTES, 'UTF-8');
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
////////////////////////////////////////////////////////////////////
echo '</div>';
echo '<div class="liner"></div>';
$outp=1;
}
///////here were they  /////////////////////////////


}

/////////////////////////////////////////////////////  
if (!$s['name']) { echo '';}
else include 'ads/ad28.php';


if (!$s['name']) {include 'catpgn.php';}
else include 'filepgn.php';

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