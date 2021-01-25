<?php
ob_start( 'ob_gzhandler' );
header('Content-type: text/html; charset=utf-8');
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
header('Pragma: no-cache');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\" \"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
echo "<head>";
require 'moduls/connect.php';
require 'moduls/fun.php';
$id = intval($_GET['id']);
$i = $_GET['i'];
$p_url     = explode('/',$_SERVER['REQUEST_URI']);
$seo_title = array_pop($p_url);
preg_match_all("|page([0-9]*).html|U", $seo_title, $out, PREG_PATTERN_ORDER);
$sql = @mysql_query("SELECT * FROM files WHERE id='".$id."'");
while($line = mysql_fetch_array($sql))
{
$return[] = $line;
 }
foreach ($return as $list)
{
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
echo "<meta name=\"title\" content=\"Download $list[3] - Wapindia.in - Free Downloads\" />";
echo "<meta name=\"description\" content=\"Download $list[3] - Wapindia.in - Free Downloads\"/>";
$u=str_replace("/",",",$list[1]);
$u=str_replace("files","",$u);
echo "<meta name=\"keywords\" content=\"Download$u\"/>";
echo "<title>Download $list[3] - Wapindia.in- Free Downloads</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/style.css\"/>";
echo "</head>";
echo "<body>";
echo "<div class=\"logo\"><img src=\"/images/waplogo.gif\" alt=\"Wapindia.in\" width=\"129\" height=\"28\"/></div>";
//require 'Ads/View_Vserv_Snip.php';
$filename = pathinfo($list['1']);
$ext = strtolower($filename['extension']);
$dir = $filename['dirname'].'/';
$filename = $filename['basename'];
$back = mysql_fetch_assoc(mysql_query("SELECT * FROM `files` WHERE `path` = '".clean($dir)."'"));
if($list['4'] < 1024){
$list['4'] = $list['4'].'b';
}
elseif($list['4'] < 1048576 and $list['4'] >= 1024){
$list['4'] = round($list['4']/1024, 2).'Kb';
}
else{
$list['4'] = round($list['4']/1024/1024, 2).'Mb';
}
$list[3]=str_replace("(Wapindia.in)","",$list[3]);
$list[3]=str_replace("(wapindia.in)","",$list[3]);
//echo "<h2>Free Download $list[3]</h2>";
if($ext == 'jpg' or $ext == 'jpeg' or $ext == 'jpe' or $ext == 'png'){
echo "<div class=\"tCenter\">Select Your Screen Size:<br/>";
echo "<a class=\"maroon1\" href=\"/wapindia.php?id=$id&amp;W=128&amp;H=128\">128x128</a> ";
echo "<a class=\"maroon1\" href=\"/wapindia.php?id=$id&amp;W=128&amp;H=160\">128x160</a> ";
echo "<a class=\"maroon1\" href=\"/wapindia.php?id=$id&amp;W=176&amp;H=220\">176x220</a><br/>";
echo "<a class=\"maroon1\" href=\"/wapindia.php?id=$id&amp;W=220&amp;H=176\">220x176</a> ";
echo "<a class=\"maroon1\" href=\"/wapindia.php?id=$id&amp;W=240&amp;H=320\">240x320</a> ";
echo "<a class=\"maroon1\" href=\"/wapindia.php?id=$id&amp;W=320&amp;H=240\">320x240</a><br/>";
echo "<a class=\"maroon1\" href=\"/wapindia.php?id=$id&amp;W=320&amp;H=480\">320x480</a> ";
echo "<a class=\"maroon1\" href=\"/wapindia.php?id=$id&amp;W=360&amp;H=640\">360x640</a> ";
echo "<a class=\"maroon1\" href=\"/wapindia.php?id=$id&amp;W=480&amp;H=640\">480x640</a></div>";
}

else{
echo "<div class=\"tCenter\">";
echo "<b><a class=\"maroon\" href=\"/Load/$id.html\">$list[3].$ext</a></b><br/>";
echo "</div>";
}
echo "<div class=\"tCenter\">";
			
echo"<br/>";

echo"<br/>";
echo "<b>Size of file:</b> $list[4]<br/>";
//echo "<b>Downloaded:</b> $list[7] Times<br/>";
echo "</div>";
}
echo "<div class=\"ad1 tCenter\">";
//require 'Ads/Bottom_Snip.php';
echo "</div>";
echo "<div class=\"devider\">&nbsp;</div>";
echo "<div class=\"path\"><a class=\"maroon1\"  href=\"/Category/$back[id].html\">Back &raquo;</a> <a class=\"maroon1\" href=\"/\">Home &raquo;</a></div>";
echo "<div class=\"nav\">";
//require 'Ads/rand_link2.php';
echo "</div>";
require 'moduls/foot.php';
?>