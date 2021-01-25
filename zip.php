<?php

require 'moduls/ini.php';
require 'moduls/connect.php';
require 'moduls/fun.php';
require 'moduls/pclzip.lib.php';
require 'moduls/header.php';

###############If zip is off##########
if($setup['zip_change']==0) die('Not found');
###############Checking Variables###############


$onpage = get2ses('onpage');
is_num($onpage,'onpage');

$prew = get2ses('prew');
$id = intval($_GET['id']);
$page = intval($_GET['page']);
$start = intval($_GET['start']);

if($onpage < 1){
$onpage = $setting['onpage'];
}

$d = mysql_fetch_array(mysql_query('SELECT * FROM `files` WHERE `id` = '.$id));
if(!file_exists($d['path'])) die('Такой файл не существует');
###############We receive the catalog#############
$filename = pathinfo($d['path']);
$ext = strtolower($filename['extension']);
if($ext!='zip') die('Файл не является ZIP архивом');
$dir = $filename['dirname'].'/';
$back = mysql_fetch_array(mysql_query("SELECT * FROM `files` WHERE `path` = '".$dir."'"));
###############Title###################
echo '<div class="menu"><img src="dis/in.png" alt=""><strong>Просмотр архива '.basename($d['path']).'</strong></div><div class="a">';
###############Content###################
if(!$_GET['action'])
{
$zip = new PclZip($d['path']);
if(!$list = $zip->listContent()) die('Ошибка: '.$zip->errorInfo(true));
for($i=0; $i<sizeof($list); $i++)
{
for(reset($list[$i]); $key = key($list[$i]); next($list[$i]))
{
$zfilesize = strstr($listcontent,'--size');
$zfilesize = str_replace('--size:','',$zfilesize);
$zfilesize = str_replace($zfilesize,$zfilesize.'|',$zfilesize);
$sizelist .= $zfilesize;
$listcontent = "[$i]--$key:".$list[$i][$key];
$zfile = strstr($listcontent,'--filename');
$zfile = str_replace('--filename:','',$zfile);
$zfile = str_replace($zfile,$zfile.'|',$zfile);
$savelist .= $zfile;
}
}
$sizefiles2 = explode('|',$sizelist);

$sizelist2=array_sum($sizefiles2);
$obkb=round($sizelist2/1024,2);
$preview=$savelist;

$preview = explode('|',$preview);

$count = count($preview)-1;
echo 'Всего файлов: '.$count.'<br>Вес распакованного архива: '.$obkb.' kb</div></div>';
if (!isset($page)) $page=1;
$n = 0;
$pages = ceil($count/$onpage);
if(!$pages) $pages = 1;
if ($page) $n = ($onpage*$page)-$onpage;
if ($count == 0) echo '<div class="title_bord"><div class="a">Пока пусто :(</div></div>'; else echo '<div class="title_bord">';
$sizefiles = explode('|',$sizelist);
$selectfile = explode('|',$savelist);
//------------------------------------------------------------------------------------------
for ($i = 1; $i<=$onpage; $i++)
{
if (empty($selectfile[$n]))
{
$n++;
continue;
}
$path = $selectfile[$n];
$fname = ereg_replace(".*[\\/]",'',$path);
$zdir = ereg_replace("[\\/]?[^\\/]*$",'',$path);
echo '<div class="a">'.$zdir.'/<a href="'.$_SERVER['PHP_SELF'].'?action=preview&amp;id='.$id.'&amp;open='.$path.'">'.$fname.'</a>';
if($sizefiles[$n]!='0') echo ' ['.round($sizefiles[$n]/1024,2).'kb]';
echo'</div>';
$n++;
}
//------------------------------------------------------------------------------------------
echo '</div><div class="title_bord"><div class="a">Страницы: ';
$asd= $page - 2;
$asd2= $page + 3;
if($asd<$count && $asd>0 && $page>3) echo '<a href="zip.php?id='.$id.'&amp;page=1">1</a> ... ';
for($i=$asd; $i<$asd2;$i++)
{
if($i<$count && $i>0)
{
if ($i > $pages ) break;
if ($page==$i) echo '<strong>['.$i.']</strong> ';
else echo '<a href="zip.php?id='.$id.'&amp;page='.$i.'">'.$i.'</a> ';
}
}
if ($i <= $pages)
{
if($asd2<$count) echo ' ... <a href="zip.php?id='.$id.'&amp;page='.$pages.'">'.$pages.'</a>';
}
echo '</div>';
}
###############View file###################
if($_GET['action']=='preview')
{
if(strpos($_GET['open'] , '..') !== false or strpos($_GET['open'] , './') !== false) die($hackmess);
$_GET['open'] = clean(del($_GET['open']));
$zip = new PclZip($d['path']);
$content = $zip->extract(PCLZIP_OPT_BY_NAME, $_GET['open'] ,PCLZIP_OPT_EXTRACT_AS_STRING);
$content = $content[0]['content'];
$letters=array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я');
for($b=0; $b<66; $b++)
{
if(strstr($content,$letters[$b])!== false){$utf='ok';}
}
$preview2 = explode("\r\n",$content);
$count = count($preview2);
function highlight_code($code)
{
$code=trim($code);
return highlight_string($code,true);
}
echo '<strong>Файл: '.$_GET['open'].'</strong><br>Строк: '.$count.'</div><div class="a">';
if($utf=='ok') echo highlight_code($content); else echo highlight_code(iconv('windows-1251','utf-8',$content));
echo'</div>';
}
echo '<div class="a">
<div class="i_bar_t"><a href="view.php?id='.$id.'">Описание</a></div>
<div class="i_bar_t"><a href="index.php?id='.$back['id'].'">В категорию</a></div>
<div class="i_bar_t"><a href="index.php">Загрузки</a></div>
<div class="i_bar_t"><a href="'.$setup['site_url'].'">На главную</a></div></div>';
echo'<div class="title">';
include 'moduls/foot.php';
echo '</div></div>';
?>