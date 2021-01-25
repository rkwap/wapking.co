<?php



list($msec,$sec)=explode(chr(32),microtime());
$HeadTime=$sec+$msec;
include 'moduls/ini.php';
session_name ('SID') ;
session_start() ;
include 'moduls/fun.php';
include 'moduls/connect.php';
include 'moduls/header.php';
//=================================================================================================================
$error = 0;
if(empty($_SESSION['autorise'])) $error = 1;
if($_SESSION['autorise']!= $setup['password']) $error = 1;
if(empty($_SESSION['ipu'])) $error = 1;
if($_SESSION['ipu']!=clean($ip)) $error = 1;
if($error==1) die($setup['hackmess']);
//=================================================================================================================
$id = intval($_GET['id']);

$onpage = get2ses('onpage');
$prew = get2ses('prew');
$sort = get2ses('sort');

$start = intval($_GET['start']);
$page = intval($_GET['page']);

is_num($onpage,'onpage');
is_num($prew,'prew');

if($prew != 0 and $prew != 1){
$prew = $setup['preview'];
}


$valid_sort = array('name' => '','data' => '','load' => '','size' => '');
if(!isset($valid_sort[$sort])) die($hackmess);

//------------------------------------------------------------------------------------------
$file_info = mysql_fetch_assoc(mysql_query('SELECT * FROM `files` WHERE `id` = '.$id));
if(!is_file($file_info['path'])) die('Файл не существует!');
$all_komments = (int)@mysql_num_rows(mysql_query('SELECT * FROM `komments` WHERE file_id = '.$id));
//------------------------------------------------------------------------------------------
$filename = pathinfo($file_info['path']);
$ext = strtolower($filename['extension']);
$dir = $filename['dirname'];
$filename = $filename['basename'];
$back = mysql_fetch_array(mysql_query("SELECT * FROM `files` WHERE `path` = '".clean($dir)."'"));
//------------------------------------------------------------------------------------------

if($file_info['size'] < 1024) $file_info['size'] = $file_info['size'].'b';
if($file_info['size'] < 1048576 and $file_info['size'] >= 1024) $file_info['size'] = round($file_info['size']/1024, 2).'Kb';
if($file_info['size'] > 1048576) $file_info['size'] = round($file_info['size']/1024/1024, 2).'Mb';

###############Conclusion###################
echo '<div class="menu">File dossier'.$filename.'</div><div class="a">
<strong>The size:</strong> '.$file_info['size'].'<br>
<strong>Downloaded:</strong> '.$file_info['loads'].' time(а)<br>';

###############Recent download###################
if($file_info['timeload'])
{
$file_info['timeload'] = date('d.m.Y (H:i)', $file_info['timeload']);
print '<strong>Recent download:</strong><br>'.$file_info['timeload'].'<br>';
}
###############Loader################################
if($file_info['lastloader'])
{
print '<strong>The loader was:</strong><br>'.$file_info['lastloader'].'<br>';
}
$file_info['timeupload'] = date('d.m.Y (H:i)', $file_info['timeupload']);
###############Add Time######################
print '<strong>Add Time:</strong><br>'.$file_info['timeupload'];
###############Special size for pictures############

if($ext == 'gif' or $ext == 'jpg' or $ext == 'jpe' or $ext == 'jpeg' or $ext == 'png'){
$arr = array('130x130','120x160','132x176','176x220','240x320');
echo '<hr noshade size="1" width="100%" class="hr"><strong>Special Size:</strong>';
foreach($arr as $v){
list($W,$H) = explode('x',$v);
echo "<br><a href='im.php?id=$id&amp;H=$H&amp;W=$W'>$v</a>";
}
}

###############Mp3 info###########################
if($ext == 'mp3' or $ext == 'wav')
{
include 'moduls/classAudioFile.php';
$AF = new AudioFile;
$AF->loadFile($file_info['path']);
$AF->printSampleInfo();

if($ext = 'mp3'){
print '[<strong><a href="apanel.php?action=id3&amp;id='.$id.'">Edit tags</a></strong>]';
}

}


// Video (ffmpeg)
elseif(($ext == '3gp' || $ext == 'avi' || $ext == 'mp4') && extension_loaded('ffmpeg')){
$mov = new ffmpeg_movie($file_info['path']);


// 80x80
print '<br><img src="ffmpeg.php?id='.$id.'&amp;W=80&amp;H=80" alt="prev">
<hr noshade size="1" width="100%" class="hr">
Code: '.$mov->getVideoCodec().'<br>
Allowing: '.$mov->GetFrameWidth().' x '.$mov->GetFrameHeight().'<br>
Time: '.round($mov->getDuration(),1).' sec<br>';

if($bt = $mov->getVideoBitRate()){
print 'Bitrate: '.$bt.'<br>';
}
if($ac = $mov->getAudioCodec()){
print 'Audio: '.$ac.'<br>';
}
if($abt = $mov->getAudioBitRate()){
print 'Bitrate: '.$abt.'<br>';
}

}


###############Screenshot#############################
if(is_file($setup['spath'].'/'.$filename.'.gif')){
echo '<hr noshade size="1" width="100%" class="hr"><strong>Скриншот:</strong><br><img src="'.$setup['spath'].'/'.$filename.'.gif" alt="screen"/>';
}
else{
echo '<br>[<strong><a href="apanel.php?action=screen&amp;id='.$id.'">Добавить скриншот</a></strong>]';
}

###############Description#############################
if (! empty ($ file_info ['about'])) // if it is in the database
{
$ file_info ['about'] = str_replace ("\ n", '<br>', $ file_info ['about']);
echo '<hr noshade size = "1" width = "100%" class = "hr"> <strong> Description: </strong> <br>'. $ file_info [about];
}
elseif (is_file ($ setup ['opath']. '/'. $ filename. '. txt')) // if it's in a file
{
$ f = str_replace ("\ n", '<br>', file_get_contents ($ setup ['opath']. '/'. $ filename. '. txt'));
echo '<hr noshade size = "1" width = "100%" class = "hr"> <strong> Description: </strong> <br>'. $ f;
}
print '<br> [<a href="apanel.php?action=fast&amp;id='.$id.'"> <strong> Add / change description </strong> </a>]';
###############Vote###########################
if ($ setup ['eval_change'] == 1)
{
$ i = @round (($ file_info ['yes']) / ($ file_info ['yes'] + $ file_info ['no']) * 100,0);
echo '<hr noshade size = "1" width = "100%" class = "hr">
<strong> File rating (+/-): <font color = "# FF8000"> '. $ file_info [' yes']. '</font> / <font color = "# 004080">'. $ file_info [ 'no']. '</font> </strong> [<a href="apanel.php?id='.$file_info ['id'>] .'&amp;action=cleareval"> Reset </a>] <br>
<img src = "rate.php? i = '. $ i.'" alt = ""> <br>
Helpful file ?: <a href="view.php?id='.$id.'&amp;eval=1"> <strong> Yes </strong> </a> / <a href = "view.php? id = '. $ id.' & amp; eval = 0 "> <strong> No </strong> </a> ';
}

############### Slicing ##########################
echo '</div> <div class = "a">';
if ($ setup ['cut_change'] == 1)
{
if ($ ext == 'mp3' or $ ext == 'wav') {
print '<a href="cut.php?id='.$id.'"> <strong> Slicing </strong> </a> <br>';
}
}

############### Viewing archive ####################
if ($ setup ['zip_change'] == 1)
{
if ($ ext == 'zip') {
print '<a href="zip.php?id='.$id.'"> <strong> View archive </strong> </a> <br>';
}
}

############### Comments #######################
if ($ setup ['komments_change'] == 1)
{
echo '<a href="komm.php?id='.$id.'"> <strong> Comments ['. $ all_komments. '</strong>] </a> [<a href = "apanel.php ? id = '. $ file_info [' id '].' & amp; action = clearkomm "> Clear </a>] <br> ';
}


// txt files
if ($ ext == 'txt') {
print '<a href="txt_zip.php?id='.$id.'"> Download [ZIP] </a> <br/>
<a href="txt_jar.php?id='.$id.'"> Download [JAR] </a> <br/> ';
}


echo '<a href="load.php?id='.$id.'> <strong> Download [' .ucfirst ($ ext). '] </strong> </a> <br>';
if ($ ext == 'jar' and $ setup ['jad_change'] == 1) {
echo '<a href="jad.php?id='.$id.'> <strong> Download [Jad] </strong> </a> <br>';
}

echo '</div>
<div class = "a"> - <a href="apanel_index.php?id='.$back ['id'> ].'"> Back </a> <br>
- <a href="apanel.php"> Admin area </a> </div> ';

list ($ msec, $ sec) = explode (chr (32), microtime ());
echo '<div class = "title">'. round (($ sec + $ msec) - $ HeadTime, 4). ' sec <br> [& copy; Sea mod GANJAR and Sl @ yer] </div> </body> </html> ';

?>