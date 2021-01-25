<?php
//header('Content-type: text/html; charset=UTF-8');
//header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
//header('Pragma: no-cache');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\" \"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
echo "<head>";
require 'moduls/config.php';
require 'moduls/fun.php';
require_once 'Ads/Core.php';
require_once("Ads/Vserv.php");
require_once("Ads/Adzmedia.php");
require_once("Ads/Mobday.php");
$id = intval($_GET['id']);
$file_info = mysql_fetch_assoc(mysql_query('SELECT * FROM `files` WHERE `id` = '.$id));
if(!is_file($file_info['path'])){
die('File Not Found</body></html>');
}
$sql = @mysql_query("SELECT * FROM files WHERE id='".$id."'");
while($line = mysql_fetch_array($sql))
{
$return[] = $line;
 }
foreach ($return as $list)
{
$filename = pathinfo($list['1']);
$ext = strtolower($filename['extension']);
$dir = $filename['dirname'].'/';
$ex = explode('/',$dir);
$sizeof = sizeof($ex)-2;
foreach($ex as $k=>$v)
{
if($v!='' and $v!='.' and $v!='..' and $v!=$setup['path'])
{
$s = mysql_fetch_array(mysql_query("SELECT `id`,`name` FROM `files` WHERE `path` LIKE '%/".clean($v)."/'"));
$s['name'] = str_replace('*','',$s['name']);
$url=str_replace(" ","_",$s['name']);
$url=str_replace("_","-",$url);
$put .= '<a href="/Category/'.$s['id'].'/'.$url.'.html">'.$s['name'].'</a> &raquo; ';
$put1 .= ''.$s['name'].' :: ';
//$put1 .= ''.$s['name'].' &gt; ';
}
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?
echo "<meta name=\"title\" content=\"$put1\"/>";
?>
<meta name="robots" content="index,follow"/>
<meta name="language" content="en" />
<?php
echo "<meta name=\"description\" content=\"$list[3] &gt; $put1 Wapking.co\"/>";
$u=str_replace("/",",",$list[1]);
$u=str_replace("files","",$u);
$u=str_replace("_"," ",$u);
echo "<meta name=\"keywords\" content=\"$list[3]$u\"/>";
//echo "<meta name=\"robots\" content=\"index,follow\"/>";
echo "<title>Wapking.co :: $list[3] :: $put1  Wapking</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/css/wapking.css\"/>";
echo "</head>";
echo "<body>";
echo "<div class=\"logo\"><img src=\"/images/wapking.png\" alt=\"Wapking.co\" width=\"166\" height=\"38\"/>
<br/></div>";


?>
<div class="ad1 tCenter">
<a href="javascript:void(window.open('https://www.facebook.com/sharer/sharer.php?u=' + location.href, 'sharer', 'width=626,height=436,toolbar=0,status=0'));" class="fb-share-button fb-share-button-22"><b>::Share This Page On Facebook [Click Here]</b></a>
</div>
<?
require 'Ads/Vserv_Snip_Head.php';
require 'Ads/Adzmedia_Snip.php';

if($list[6])
{
echo "<div class=\"description\">";
echo "$list[6]";
echo "</div>";
}
//$filename = $filename['basename'];
//$back = mysql_fetch_assoc(mysql_query("SELECT * FROM `files` WHERE `path` = '".clean($dir)."'"));
if($list['4'] < 1024){
$list['4'] = $list['4'].'b';
}
elseif($list['4'] < 1048576 and $list['4'] >= 1024){
$list['4'] = round($list['4']/1024, 2).'Kb';
}
else{
$list['4'] = round($list['4']/1024/1024, 2).'Mb';
}
$list[3]=str_replace("(Wapking.co)","",$list[3]);
$list[3]=str_replace("Wapking.co","",$list[3]);
echo "<h2>Free Download $list[3]</h2>";
echo "<div class=\"devider\">&nbsp;</div>";

}
echo "<div class=\"tCenter\">";
if($ext == 'jpg' or $ext == 'jpeg' or $ext == 'jpe' or $ext == 'png'){
echo "<div class=\"tCenter\">Select Your Screen Size:<br/>";
echo "<a class=\"fileName\" href=\"/wapking.php?id=$id&amp;W=128&amp;H=128\">128x128</a> ";
echo "<a class=\"fileName\" href=\"/wapking.php?id=$id&amp;W=128&amp;H=160\">128x160</a> ";
echo "<a class=\"fileName\" href=\"/wapking.php?id=$id&amp;W=176&amp;H=220\">176x220</a><br/>";
echo "<a class=\"fileName\" href=\"/wapking.php?id=$id&amp;W=220&amp;H=176\">220x176</a> ";
echo "<a class=\"fileName\" href=\"/wapking.php?id=$id&amp;W=240&amp;H=320\">240x320</a> ";
echo "<a class=\"fileName\" href=\"/wapking.php?id=$id&amp;W=320&amp;H=240\">320x240</a><br/>";
echo "<a class=\"fileName\" href=\"/wapking.php?id=$id&amp;W=320&amp;H=480\">320x480</a> ";
echo "<a class=\"fileName\" href=\"/wapking.php?id=$id&amp;W=360&amp;H=640\">360x640</a> ";
echo "<a class=\"fileName\" href=\"/wapking.php?id=$id&amp;W=480&amp;H=640\">480x640</a></div>";
//echo "Downloaded: <b>$list[7] Time</b><br/>";
}

else{
echo "<a class=\"fileName\" href=\"/Load/$id.html\">$list[3].$ext</a><br/>";
}
require 'Ads/Adzmedia_Snip1.php';
require_once("Ads/Vserv_Text_Snip.php");
echo "<br/>Size: <b>$list[4]</b><br/>";
echo "Downloaded: <b>$list[7] Time</b><br/>";
echo '</div>';

echo "<div class=\"ad2 tCenter\">";
require 'Ads/Facebook_View.php';
echo"</div>";

echo "<div class=\"ad1 tCenter\">";
require("Ads/Vserv_Snip_Bottom.php");
echo"</div>";

$ba=str_replace("*","",$back[name]);
$ba1=str_replace("_","-",$ba);
$ba1=str_replace(" ","-",$ba1);

$back = mysql_fetch_assoc(mysql_query("SELECT * FROM `files` WHERE `path` = '".clean($dir)."'"));
echo "<div class=\"path\"><a href=\"/Category/$back[id].html\">&#171; Go Back </a>";

echo "<br/><a href=\"http://www.Wapking.co\"> Home</a>&raquo;  $put $list[3]</div>";


$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : ''; 
$url = "http://www.WapKing.co$url";
$on = @mysql_fetch_array(mysql_query("SELECT * FROM map WHERE fileid='".$id."'"));
if(empty($on[0])){
@mysql_query("INSERT INTO map SET fileid='".$id."', url='".$url."'");
}
       
?>
<div class="ftrLink">
	<a href="/" class="siteLink">Wapking.co</a>
</div>
<?       
echo "</body></html>";
?>