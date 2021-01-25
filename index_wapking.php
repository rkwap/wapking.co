<?php
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-type: text/html; charset=utf-8');
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\" \"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
require 'moduls/config.php';
require 'moduls/fun.php';
require_once("Ads/Core.php");
require_once("Ads/Adzmedia.php");
require_once("Ads/Vserv.php");
//require_once("Ads/Mobday.php");
$id = (int)@$_GET["id"]; 
$page = (int)@$_GET["page"]; 
$sort = $_GET['sort'];
if($sort=="")$sort="data";
if ($sort == 'data') {
	$MODE = "timeupload DESC";
} else if ($sort == 'size') {
	$MODE = "size ASC";
} else if ($sort == 'load') {
	$MODE = "loads DESC";
} else if ($sort == 'name') {
	$MODE = "name ASC";
} else if ($sort == 'rand') {
	$MODE = "RAND()";
}
if(!$id){
$d['path'] = $setup['path'].'/';
}
else{
$d = mysql_fetch_assoc(mysql_query("SELECT path, fastabout FROM files WHERE id='".$id."' LIMIT 1"));
}
if(!is_dir($d['path'])) die('This category does not exist. <a href=\"http://www.Wapking.co\">Wapking.co</a></body></html>');

$ex = explode('/',$d['path']);
$sizeof = sizeof($ex)-2;
foreach($ex as $k=>$v)
{
if($v!='' and $v!='.' and $v!='..' and $v!=$setup['path'])
{
//$v = "/$v/";
$s = mysql_fetch_array(mysql_query("SELECT `id`,`name` FROM `files` WHERE `path` LIKE '%/".clean($v)."/' AND `size` = 0"));
$s['name'] = str_replace('*','',$s['name']);
$url=str_replace(" ","_",$s['name']);
$url=str_replace("_","-",$url);
if($k >= $sizeof) $put .= $s['name'];
else $put .= '<a href="/Category/'.$s['id'].'/'.$url.'.html">'.$s['name'].'</a> &raquo; ';
$put1 .= ''.$s['name'].' :: ';
//$put1 .= ''.$s['name'].' &gt; ';
}

}
$u=str_replace("/",",",$d['path']);
$u=str_replace("files","",$u);
require 'moduls/header.php';


if (!empty($s['name']))
{

require 'Ads/Vserv_Snip_Head.php';

?>
<h2><?php echo "$s[name]"; ?></h2>
<?php
}else{
require 'Ads/Bookmark_Title.php';

echo "<div class=\"ad1 tCenter\">Download Daily New<br/><a href=\"http://www.wapking.co/Category/643/Daily-Wallpaper.html\">Wallpapers |</a><a href=\"http://www.wapking.co/Category/33/Daily-Ringtones.html\">Ringtones</a> </div>";
?>
<h2>:: Coming Soon ::</h2>

<div class="catRow">*Latest Bollywood Mobile Videos</div>
<div class="catRow">**And Much More...</div>
<form action="http://www.google.co.in" id="cse-search-box">
  <div class="search tCenter">
    <input type="hidden" name="cx" value="partner-pub-2815632800361740:9782412030" />
    <input type="hidden" name="ie" value="UTF-8" />Search Files
    <input type="text" name="q" size="20" />
    <input type="submit" name="sa" value="Search" />
  </div>
</form>
<?
echo "<div class=\"updates\"><h2>Latest Updates</h2>";
$sql = @mysql_query("SELECT * FROM new ORDER BY date DESC LIMIT 15");
while($list = mysql_fetch_array($sql))
{
echo "<div>$list[1]</div>";
}
echo "<div><a href=\"/update.html\">[More Updates...]</a></div></div>";
echo "<div class=\"devider\">&nbsp;</div>";
echo "<div class=\"ad1\">&nbsp; Top 10 Downloads:<br/><a href=\"http://www.Wapking.co/top.html\"> &nbsp; Today |</a><a href=\"http://www.Wapking.co/top.html\"> Forever</a> </div>";
echo "<div id=\"category\"><h2>Select Categories</h2><div class=\"catList\">";
}


$whoinfo = mysql_fetch_array(mysql_query("SELECT info FROM files WHERE infolder ='".$d['path']."'"));
if($whoinfo[0] == "dir")
{

if($page=="" || $page<=0)$page=1;
$all = @mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM files WHERE infolder='".$d[path]."'"));
$num_items = $all[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;

$sql = @mysql_query("SELECT * FROM files WHERE infolder='".$d[path]."' ORDER BY timeupload DESC LIMIT $limit_start, $items_per_page;");
while($line = mysql_fetch_array($sql))
{
$return[] = $line;
 }
foreach ($return as $list)
{
$item[1] = str_replace('*','',$list[3]);
$tm24 = time()-(10*24*60*60);
$aut = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM files WHERE infolder LIKE '%".$list[1]."%' AND timeupload>'".$tm24."'"));
if($aut[0])
{
if (!empty($s['name'])) 
{
$new = "<img src=\"/images/new.gif\" alt=\"..\" width=\"21\" height=\"7\"/>";
}else{
$new = "<img src=\"/images/updated.gif\" alt=\"..\" width=\"45\" height=\"7\"/>";
}
}
else{
$new = "";
}
$allinfolder = @mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM files WHERE infolder LIKE '%".$list[1]."%' AND size>'0'"));
$url1=str_replace(" ","_",$item[1]);
$link=str_replace("_","-",$url1);

if (!empty($s['name']))
{
echo "<div class=\"ad2\">";
require_once("Ads/Adzmedia_Snip.php");
echo "</div>";
}
else
{
}
if (!empty($s['name']))
{

echo "<div class=\"catRow\"> <a href=\"/Category/$list[0]/$link.html\">$item[1] [$allinfolder[0]]</a> $new</div>";
}
else
{
echo "<div class=\"catRow\"> <img src=\"/images/dir.png\" alt=\"..\" width=\"16\" height=\"16\"/> <a href=\"/Category/$list[0]/$link.html\">$item[1] [$allinfolder[0]]</a> $new</div>";

}


}

if (!empty($s['name']))
{
//require_once("Ads/r");
}
else
{
echo "<div class=\"catRow\"><img src=\"/images/dir.png\" alt=\"..\" width=\"16\" height=\"16\"/> ";
echo "<a href=\"Service/Videos\">Videos</a></div>";
echo "<div class=\"catRow\"><img src=\"/images/dir.png\" alt=\"..\" width=\"16\" height=\"16\"/> ";
echo "<a href=\"Services\">Services</a></div>";
}


echo "<div class=\"catRow\"> ";

if (!empty($s['name']))
{
require_once("Ads/rand.php");
}
else
{
echo "<img src=\"/images/dir.png\" alt=\"..\" width=\"16\" height=\"16\"/> ";
require_once("Ads/rand.php");
}
echo "</div>";
if (!empty($s['name']))
{
}else{
echo "</div></div>";
}
}
else{


if($page=="" || $page<=0)$page=1;
$all = @mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM files WHERE infolder='".$d[path]."'"));
$num_items = $all[0];
$items_per_page= 8;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
if($d[fastabout])
{
?>
<div class="description">
<?php echo "$d[fastabout]"; ?>
</div>
<?php
}
require_once 'moduls/sorting.php';

require("Ads/Vserv_Snip_Sorting.php");

echo "<table>";
$sql = @mysql_query("SELECT * FROM files WHERE infolder='".$d[path]."' ORDER BY $MODE LIMIT $limit_start, $items_per_page;");
while($line = mysql_fetch_array($sql))
{
$return[] = $line;
 }
foreach ($return as $list)
{

$filename = pathinfo($list['1']);
$ext = $filename['extension'];
$dir = $filename['dirname'].'/';
$filename = $filename['basename'];
$filename=str_replace(".$ext","",$filename);




if($ext == "gif" or $ext == "jpeg" or $ext == "jpg" or $ext == "png"){
$pre = "<td class=\"tblimg\"><a href=\"/File/$list[0]/$i.html\"><img src=\"/im.php?id=$list[0]&amp;W=60&amp;H=70\" alt=\"$item[1]\" width=\"60\" height=\"70\"/></a></td>";
}
else if(file_exists("data1/File/$filename.jpg"))
{
$pre = "<td class=\"tblimg\"><a href=\"/File/$list[0]/$i.html\"><img src=\"/data1/File/$filename.jpg\" alt=\"$item[1]\" width=\"60\" height=\"70\"/></a></td>";
}

else{
$pre = '';
}
if(file_exists("thumb/$list[2]$filename.$ext.gif"))
{
$pre = "<td class=\"tblimg\"><a href=\"/File/$list[0]/$i.html\"><img src=\"/thumb/$list[2]$filename.$ext.gif\" alt=\"$item[1]\" width=\"60\" height=\"70\"/></a></td>";
}
if(file_exists("thumb/$list[2]$filename.$ext.jpg"))
{
$pre = "<td class=\"tblimg\"><a href=\"/File/$list[0]/$i.html\"><img src=\"/thumb/$list[2]$filename.$ext.jpg\" alt=\"$item[1]\" width=\"60\" height=\"70\"/></a></td>";
}
if(file_exists("thumb/$list[2]$filename.jpg"))
{
$pre = "<td class=\"tblimg\"><a href=\"/File/$list[0]/$i.html\"><img src=\"/thumb/$list[2]$filename.jpg\" alt=\"$item[1]\" width=\"60\" height=\"70\"/></a></td>";
}
if($list['4'] < 1048576 and $list['4'] >= 1024) $list['4'] = ''.round($list['4']/1024, 2).'Kb';
else $list['4'] = ''.round($list['4']/1024/1024, 2).'Mb';
$i = str_replace(' ','_',$list[3]);
$item[1]=str_replace("&","&amp;",$list[3]);
$i=str_replace("&","&amp;",$i);
$i=str_replace("_","-",$i);
$i=str_replace("(wapking.co)","",$i);
$item[1]=str_replace("(wapking.co)","",$item[1]);
$item[1]=str_replace("(Wapking.co)","",$item[1]);
echo "<tr class=\"odd\">";
if(!$pre){
echo "$pre<td colspan=\"2\">";
}
else{
echo "$pre<td>";
}
echo "<a class=\"fileName\" href=\"/File/$list[0]/$i.html\">$item[1].$ext</a><br/>Size : [$list[4]] </td></tr>";
//echo "<a class=\"fileName\" href=\"/File/$list[0]/$i.html\">$item[1].$ext</a><br/><br/>Size : [$list[4]] <br/>Hits : [$list[7]] </td></tr>";
}

echo "</table>";

}
if (!empty($s['name']))
{
echo "<div class=\"ad2\">";
require 'Ads/Vserv_Snip_Center.php';
echo"</div>";
echo "<div class=\"ad1 tCenter\">";
require 'Ads/Vserv_Snip_Bottom.php';
echo"</div>";
echo "<div class=\"ad2\">";
require 'Ads/Vserv_Text_Snip.php';
echo"</div>";
echo "<div class=\"pgn\">";
$pag=str_replace(" ","-",$s[name]);
navigation($num_pages, $page, "/Page/$id/$sort/$pag");
echo"</div>";
echo "<div class=\"path\"><a href=\"http://www.Wapking.co\">&nbsp;Home</a> &raquo; $put </div>";
}else{
echo "<div class=\"ad1 tCenter\"><a href=\"/mail\">Errors? Suggestion? Ideas? Tell Us! </a></div>";
echo "<div><a href=\"http://facebook.com/wapkingco\">Like Us On Facebook</a></div>";
echo "<div class=\"devider\"></div>";

echo "<div><a href=\"/disclaimer.php\">Disclaimer</a></div>";

?>
<div class="tCenter">
<div class="spon">
Sponsored By</div>

<a href="http://wap.delmy.com/?id=wapkingco">Mobile Magic</a> | 
<a href="http://gsm.waptop.info/?id=wapkingco">Top Downloads</a> |
<a href="http://wap.ehho.net/?id=wapkingco">Free Working Gprs Trick</a>
<img style="width: 1px; height: 1px;" alt="" src="http://c.wen.ru/2364084.wbmp?Main">
</div>
<?

}
require 'moduls/foot.php';
?>