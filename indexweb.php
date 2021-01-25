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
$sturl = "http://m.funwap.org/SMS2/";
$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if($k >= sizeof($ex)-2) $put .= '<a href="'.$url.'">'.$s['name'].'</a>';
else $put .= '<a href="'.$sturl.''.$s['id'].'/'.$fullo.'/1.html">'.$s['name'].'</a> &raquo; ';
if($k >= sizeof($ex)-2) $title .= ''.$s['name'].'|';
else $title .= ''.$s['name'].'|';}}

////////////////////////////////////////////////////////////////////////////////////////

echo '<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>krazysms.in &raquo; Largest SMS Collection.</title>
<link rel="shortcut icon" href="/favicon.ico" />
<link href="http://krazysms.in/css/krazysms.css?1.2" type="text/css" rel="stylesheet"/>
<!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="http://krazysms.in/css/krazysms_ie6.css" /><![endif]--> <!-- MSIE6 -->
<script type="text/javascript" src="/js/jquery.min.js"></script>
</head>
<body>';

echo '<div id="mainContent">
	<div id="header">
		<div id="logo">
			<a href="http://www.krazysms.in"><img alt="www.KrazySMS.in" src="http://www.wapsms.in/images/p/logo.png" /></a>		</div>';
///////////////////////////////////////////
if($setup['buy_change']==1){echo '';
$list = explode("\n",$setup['buy']);
if($setup['randbuy']==1) echo ''.bbcode($list[mt_rand(0,sizeof($list)-1)]).'</div>';
else foreach($list as $value) echo '';}
/////////////////////////////////////////////////////


echo'';

echo '		<div id="headerRight">
		<div style="text-align:center; margin-top:10px;"><a href="http://www.krazysms.in/signup"><img src="http://www.wapsms.in/banner1.png" /></a></div>
<div style="text-align:center; margin-top:10px; text-decoration:blink; -moz-border-radius:5px; -webkit-border-radius:5px; " class="p5 m5 fb ad2">Welcome Guest, Register Your Group and Start Sharing SMS.</div>		</div>
	</div>
	<div class="c5"></div>
	<div id="navigation_menu">
		<ul>
			<li><a href="/">Home</a></li>
			<li><a href="/users">Top Users</a></li>
			<li><a href="/popular/today">Popular SMS</a></li>
			<li><a href="/smslist/type/latest">Latest SMS</a></li>
		</ul>

      <div id="ws_social">
			<a id="ws_fb" href="http://www.facebook.com/krazysmsin" title="be our FaceBook friend"></a>
			<a id="ws_twt" href="http://www.twitter.com/krazysms" title="follow us on Twitter"></a>
			<a id="ws_blg" href="http://KRAZYSMSin.blogspot.in/" title="visit our Blog"></a>
			
		</div>';

echo '<div id="search">
			<form method="get" action="/smslist"><input type="text" name="find" id="find" value="" size="20" /><input type="submit" name="commit" value="SMS" /><input type="submit" name="commit" value="User" /></form>		</div>
	</div>
	<div class="c0"></div>
	<style>
.addiv {position:relative;height:90px;z-index:2;}
</style>
<div class="addiv">

</div>	<div class="c0"></div>
	<div id="content">
		<div id="leftPan">
			<div id="loginout">
				<div id="welcome">Welcome Guest</div><div id="myAcc"><div><a href="/signup">Sign Up</a></div><div><a href="/login">Login</a></div></div>			</div>
			<div class="c10"></div>
			<!-- SKYiTech.com :: Display category list --><div id="category">
	<h2>Categories</h2>
        <div class="catList">';


//////////////////
if (!$s['name']) {

foreach ($array_id as $key => $value)
{
$file_info = mysql_fetch_array(mysql_query('SELECT `id`,`name`,`path`,`fastabout`,`timeupload`,`infolder`,`size`,`loads`,`yes`,`no` FROM `files` WHERE `id` = "'.$value.'";'));
	if(is_dir($file_info['path'])){
   	if(is_integer($key / 2)) $row = '

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

if(!file_exists($file_info['path'].'folder.png')) $ico = '<img src="http://www.krazysms.in/images/krazysms/arrow_dark.png" alt="">'; else $ico = '<img src="'.$file_info['path'].'folder.png" alt="">';



$name22 = str_replace('*','',$file_info['name']);
$name22 = str_replace(' ','-',$name22);
$uuurl = "http://m.funwap.org/SMS2/$file_info[id]";
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

}
else echo '
                              <div class="catRow">
                       <img src="http://www.krazysms.in/images/krazysms/arrow_dark.png" alt=""> <a href="http://m.funwap.org/SMS2/1/Android-Zone/1.html">Android Zone [100]</a></div>

                  
          
                              <div class="catRow">
                       <img src="http://www.krazysms.in/images/krazysms/arrow_dark.png" alt=""> <a href="http://m.funwap.org/SMS2/102/Games/1.html">Games [21]</a><img src="http://m.funwap.org/ext/updated.gif"></div>

                              <div class="catRow">
                       <img src="http://www.krazysms.in/images/krazysms/arrow_dark.png" alt=""> <a href="http://m.funwap.org/SMS2/126/Iphone-Zone/1.html">Iphone Zone [12]</a></div>

                  
          
                              <div class="catRow">
                       <img src="http://www.krazysms.in/images/krazysms/arrow_dark.png" alt=""> <a href="http://m.funwap.org/SMS2/138/Theme/1.html">Theme [14]</a><img src="http://m.funwap.org/ext/updated.gif"></div>

                              <div class="catRow">
                       <img src="http://www.krazysms.in/images/krazysms/arrow_dark.png" alt=""> <a href="http://m.funwap.org/SMS2/144/Wallpapers/1.html">Wallpapers [8]</a></div>

                  
          
                              <div class="catRow">
                       <img src="http://www.krazysms.in/images/krazysms/arrow_dark.png" alt=""> <a href="http://m.funwap.org/SMS2/165/RingTones/1.html">RingTones [0]</a></div>';


/////////////////////////////////////

echo '
</div></div>
';
echo '
<div class="c10"></div>
<div style="width:300px;position:relative;left:-45px;">
</div>

<h2>Be Connected</h2>
<div id="sharing_box" style="width:240px;margin:auto;display:none;">
<a href="http://twitter.com/krazysms" class="twitter-follow-button" data-size="large" data-show-count="false">Follow @KRAZYSMS</a>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>

<iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fkrazysmsin&width=240&height=240&colorscheme=light&show_faces=true&border_color&stream=false&header=false" scrolling="no" frameborder="0" style="background:#fff; border:none; overflow:hidden; width:240px; height:240px;" allowTransparency="true"></iframe></div>
			<div class="c0"></div>


<div id="online">Online: 96</div>		</div>
		<div id="middlePan">';


if (!$s['name']) { echo '<h1>Latest SMS</h1>';}
else echo '<h1>'.$s['name'].'</h1>';			


echo '<div class="c5"></div>';


////////////////////////////////////
if (!$s['name']) { echo 'Latest SMS';}
else
foreach ($array_id as $key => $value)
{
$file_info = mysql_fetch_array(mysql_query('SELECT `id`,`name`,`path`,`fastabout`,`timeupload`,`infolder`,`size`,`loads`,`yes`,`no` FROM `files` WHERE `id` = "'.$value.'";'));
	if(is_dir($file_info['path'])){
   	if(is_integer($key / 2)) $row = '

                              <div class="tagRow">

                                                      ';
 	if (!empty($file_info['fastabout'])) $file_info['about'] = str_replace("\n", '<br>',$file_info['about']);
   		$new_all="";
        $stime=$time-(3600*24*$setup['day_new']);
   		if($setup['day_new']!=0) $new_all = mysql_fetch_array(mysql_query('SELECT COUNT(*) FROM `files` WHERE `timeupload` > "'.$stime.'" AND `infolder` LIKE  "'.$file_info['path'].'%" AND `size` > "0";'));
		if($new_all[0] and $setup['day_new']!=0) $new_all = '<img src="http://m.funwap.org/ext/new.gif">';
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

$ico = '<img src="http://www.krazysms.in/images/krazysms/arrow.png" alt="">';



$name22 = str_replace('*','',$file_info['name']);
$name22 = str_replace(' ','-',$name22);
$uuurl = "http://m.funwap.org/SMS2/$file_info[id]";
$uunewurl = $uuurl . "/$name22/1.html";
                if (!empty($name) and !$block){
echo ''.$row.''.$ico.'';

echo ' <a href="'.$uunewurl.'">'.$name.' ['.$allinfolder[0].']</a>';


   		if($new_all) echo ''.$new_all.'';
        if(!empty($file_info['fastabout'])) echo '<br>'.str_replace("\n", '<br>',$file_info['fastabout']);
   		echo '</div>
                     <div class="liner"></div>
';}}
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
////////////////////////////////////////////////////////
echo '<div class="c0"></div>
		</div>
		<div class="c5"></div>
	</div>
<div class="ftrLink">

	<a href="http://www.krazysms.in">www.KrazySMS.in</a>
		- <a href="http://www.krazysms.in/disclaimer">Disclaimer</a>
	- <a href="http://www.krazysms.in/contact">Contact Us</a>
	</div>
</div>


';



//////////////









echo '
</body>
</html>';
?>