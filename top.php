<?php
require 'moduls/ini.php';
require 'moduls/fun.php';
require 'moduls/connect.php';
require 'moduls/header.php';
echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';echo "
<meta name=\"title\" content=\" Funwap.Org - Top 10 Downloads\"/>";echo '
<meta name="robots" content="index,follow"/>
<meta name="language" content="en" />';echo "
<meta name=\"description\" content=\" Funwap.Org - Top 10 Downloads\"/>";echo "
<meta name=\"keywords\" content=\"$list[3],wapking,android games,android apps,games,wallpapers,mp3,jar,themes,nokia, micromax,wapindia,wapking.in,free games\"/>";echo "

<title>Funwap.Org - Top 10 Downloads</title>";echo '
<link rel="shortcut icon" href="icon.ico" />';echo '
<link href="http://m.funwap.org/style.css" rel="stylesheet" style="text/css">

</head>
<body>    
         <div class="logo"><img alt="Wapking" src="http://freemaza.in/images/FreeMaza.in_logo.gif" /><br></div>


';
$onpage = get2ses('onpage');
$onpage = 10;
$prew = get2ses('prew');
$sort = get2ses('sort');
$id = intval($_GET['id']);
$MODE = '`loads` > 0 AND `size` > 0 ORDER BY `loads` DESC';
$query = mysql_query('SELECT * FROM `files` WHERE '.$MODE.' LIMIT 0, '.$setup['top_num']);

while($list_sw = mysql_fetch_array($query)){
$array_id[] = $list_sw['id'];
}
$all = sizeof($array_id);
###############Вывод###############
echo '<h2>:: Top '.$onpage.' Downloads :: </h2>';
###############Cтраницы###############
if(!isset($page)) $page=1;
$n = 0;
for($i=1; $i<=$onpage; $i++)
{
$row = '<table><tr class="odd"><td class="tblimg">'; 
$file_info = mysql_fetch_array(mysql_query('SELECT * FROM `files` WHERE `id` = '.$array_id[$n]));
$backdir = @mysql_fetch_array(mysql_query("SELECT * FROM `files` WHERE `path` = '".clean($file_info['infolder'])."'"));
$basename = basename($file_info['path']);
$ex = pathinfo($file_info['path']);
$ext = strtolower($ex['extension']);
$name_file = str_replace('.'.$ex,'',$basename);

if(strpos($basename , '!') !== false){
$name_file = trans($name_file);
}
else{
$name_file = trans2($name_file);
}
$filename = str_replace(' ' , '_',$name_file);

if($file_info['size'] < 1024) $file_info['size'] = '['.$file_info['size'].'b]';
elseif($file_info['size'] < 1048576 and $file_info['size'] >= 1024) $file_info['size'] = '['.round($file_info['size']/1024, 2).'Kb]';
else $file_info['size'] = '['.round($file_info['size']/1024/1024, 2).'Mb]';

$pre='';
if($prew==1)
{
if($ext == 'bmp'){
$pre = 'Impossible Preview<br></td><td>';
}
elseif($ext == 'gif' or $ext == 'jpeg' or $ext == 'jpe' or $ext == 'jpg' or $ext == 'png'){
$pre = '<img class="timg" src="http://m.funwap.org/Thumbs/Wallpapers/'.$filename.'" height="70" width="60 alt=""/></td><td>';
}
elseif($ext == 'apk'){
$pre = '<img class="timg" src="http://m.funwap.org/Thumbs/Android_Zone/'.$filename.'.jpg" height="70" width="60 alt=""/></td><td>';
}
elseif($ext == 'ipa'){
$pre = '<img class="timg" src="http://m.funwap.org/Thumbs/IPhone_Zone/'.$filename.'.jpg" height="70" width="60 alt=""/></td><td>';
}
elseif($ext == 'jar'){
$pre = '<img class="timg" src="http://m.funwap.org/Thumbs/Games/'.$filename.'.jpg" height="70" width="60 alt=""/></td><td>';
}
elseif($ext == 'nth' or $ext == 'thm'){
$pre = '<img class="timg" src="http://m.funwap.org/Thumbs/Themes/'.$filename.'.jpg" height="70" width="60 alt=""/></td><td>';
}
else{$pre = '<img class="timg" src="http://www.wapking.co/images/files.gif" height="70" width="60 alt=""/></td><td>';}
}
echo '</table>';

$name_file = str_replace('(m.funwap.org)' , '',$name_file);
$name_file = str_replace('(M.Funwap.Org)' , '',$name_file);
$name_file = str_replace('-Funwap.ORG' , '',$name_file);
$name = str_replace(' ' , '-',$name_file);
$name = str_replace('(m.funwap.org)' , '',$name);
$name = str_replace('(M.Funwap.Org)' , '',$name);
$name = str_replace('-Funwap.ORG' , '',$name);
$name = str_replace('.'.$ext.'' , '',$name);



$new_info='';
$info = ''.$file_info['loads'].' Hits';
$filtime2 = $file_info['timeupload']+(3600*24*$setup['day_new']);
if($filtime2>=$time) $new_info = '(New)';
if($setup['ext']==1) $extension = '('.$ext.')'; else $extension = '';
echo $row.$pre.'<strong><a href="Download/'.$file_info['id'].'/'.$name.'.html">'.$name_file.'</a></strong><br>'.$file_info['size'].'<br>'.$info.'<br></td></tr>';
$n++;
}
?>
