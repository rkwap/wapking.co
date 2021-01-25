<?php
require 'moduls/ini.php';
require 'moduls/fun.php';
require 'moduls/connect.php';
require 'moduls/header.php';
require 'online.php';
############### If search is disabled ###############
if($setup['search_change'] == 0) die('Not found');
############### Checking Variables ###############
$onpage = get2ses('onpage');
$prew = get2ses('prew');
$sort = get2ses('sort');
$id = intval($_GET['id']);
$page = intval($_GET['page']);

is_num($onpage,'onpage');
is_num($prew,'prew');

if($prew != 0 and $prew != 1){
$prew = $setup['preview'];
}
############### Word entry form ###############

############### Checking Variables ###############
if($_GET['act']=='search')
{
if(!$_REQUEST['word']) die ('Error. Do not fill out the field.');
$word = clean(del(cut($_REQUEST['word'],15)));
$word_search_query = mysql_query("SELECT * FROM `files` WHERE `name` LIKE '%".$word."%' AND `size` > 0");
$i = 0;
while($result = mysql_fetch_array($word_search_query)) $array_id[] = $result['id'];
$all = count($array_id);
if(!isset($page)) $page=1;
$n = 0;
$pages = ceil($all/$onpage);
if(!$pages) $pages = 1;
if ($page) $n = ($onpage*$page)-$onpage;
echo '<div class="menu"><img src="dis/in.png" alt="">On request "'.$word.'" found '.$all.' file (s)</div>';
if($all == 0) echo '<div class="a"><font color="red">Sorry, but your search did not precise</font></div>';
for($i=1; $i<=$onpage; $i++)
{
if (!isset($array_id[$n]))
{
$n++;
continue;
}
if(is_integer($n / 2)) $row = '<div class="a">'; else $row = '<div class="a">';
$file_info = mysql_fetch_array(mysql_query('SELECT * FROM `files` WHERE `id` = '.$array_id[$n]));
$backdir = @mysql_fetch_array(mysql_query("SELECT * FROM `files` WHERE `path` = '".$file_info['infolder']."'"));
$basename = basename($file_info['path']);
$ex = pathinfo($file_info['path']);
$ext = strtolower($ex['extension']);
$name_file = str_replace('.'.$ex,'',$basename);
//Transliteration
if(strpos($basename , '!') !== false){
$name_file = trans($name_file);
}
else{
$name_file = trans2($name_file);
}
//Beautiful size
if($file_info['size'] < 1024) $file_info['size'] = '('.$file_info['size'].'b)';
if($file_info['size'] < 1048576 and $file_info['size'] >= 1024) $file_info['size'] = '('.round($file_info['size']/1024, 2).'Kb)';
if($file_info['size'] > 1048576) $file_info['size'] = '('.round($file_info['size']/1024/1024, 2).'Mb)';
//File novelty
$new_info=null;
$filtime2 = $file_info['timeupload']+(3600*24*$setup['day_new']);
if($filtime2>=$time){ $new_info = '[<font color="#FFFF00">New</font>]';}
//Preview
$pre = null;
if($prew==1)
{
if($ext == 'bmp'){
$pre = 'Impossible Preview<br>';
}
elseif($ext == 'gif' or $ext == 'jpeg' or $ext == 'jpe' or $ext == 'jpg' or $ext == 'png'){
$pre = '<img style="margin:1px;" src="im.php?id='.$file_info['id'].'" alt=""/><br>';
}
}
//File Icon
if(!file_exists("ext/$ext.png")){
$ico = '<img src="ext/stand.png" alt="">';
}
else{
$ico = '<img src="ext/'.$ext.'.png" alt="">';
}
if($setup['ext']==1){
$extension = '('.$ext.')';
}
else{
$extension = '';
}
//Own output
echo $row.$pre.' '.$ico.'<strong><a href="view.php?id='.$file_info['id'].'">'.$name_file.'</a></strong>'.$extension.$file_info['size'].'[<a href="index.php?id='.$backdir['id'].'">In category</a>]<br></div>';
$n++;
}
//------------------------------------------------------------------------------------------
echo '<div class="a">Pages: ';
$asd = $page - 2;
$asd2 = $page + 3;
if($asd<$all && $asd>0 && $page>3) echo '<a href="search.php?act=search&amp;page=1&amp;onpage='.$onpage.'&amp;prew='.$prew.'&amp;word='.$word.'">1</a> ... ';
for($i=$asd; $i<$asd2;$i++)
{
if($i<$all && $i>0)
{
if($i > $pages) break;
if($page==$i) 	echo '<strong>['.$i.']</strong> ';
else echo '<a href="search.php?act=search&amp;page='.$i.'&amp;onpage='.$onpage.'&amp;prew='.$prew.'&amp;word='.$word.'">'.$i.'</a> ';
}
}
if($i <= $pages)
{
if($asd2<$all) echo ' ... <a href="search.php?act=search&amp;page='.$pages.'&amp;onpage='.$onpage.'&amp;prew='.$prew.'&amp;word='.$word.'">'.$pages.'</a>';
}
echo '<br>';
//------------------------------------------------------------------------------------------
if($pages>$setup['pagehand'] and $setup['pagehand_change'] == 1)
{
echo 'Pages '.$page.' из '.$pages.':<br>
<form action="search.php?act=search&amp;word='.$word.'" method="post">
<input class="enter" name="page" type="text" maxlength="4" size="8" value="">
<input class="buttom" type="submit" value="Перейти">
</form>';
}
//------------------------------------------------------------------------------------------
echo '</div><div class="a">';
//------------------------------------------------------------------------------------------
echo '<div class="i_bar_t"><a href="index.php?onpage='.$onpage.'&amp;prew='.$prew.'">Downloads</a></div>
<div class="i_bar_t"><a href="'.$setup['site_url'].'">Home</a></div>
';
if($setup['online'] == 1)echo '</div><div class="menu">Online: <strong>'.$all_online[0].'</strong>';
echo '</div><div class="title">';

include 'moduls/foot.php';
echo '</div>';
}
?>