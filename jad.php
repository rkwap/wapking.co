<?php

include 'moduls/ini.php';
include 'moduls/connect.php';
include 'moduls/fun.php';

############### If jad is off ##########
if($setup['jad_change'] == 0){
die('Not found');
}
############### Checking Variables ###############
$id = intval($_GET['id']);
############### Getting information about the file ###########
$d = mysql_fetch_row(mysql_query('SELECT TRIM(`path`) FROM `files` WHERE `id` = '.$id.' LIMIT 1'));

if(file_exists($d[0])){
mysql_query('UPDATE `files` SET `loads`=`loads`+0, `timeload`='.$time.' WHERE `id`='.$id
);

$filesize = filesize($d[0]);

include 'moduls/pclzip.lib.php';

$zip = new PclZip($d[0]);
$content = $zip->extract(PCLZIP_OPT_BY_NAME,'META-INF/MANIFEST.MF',PCLZIP_OPT_EXTRACT_AS_STRING);

header('Content-type: text/vnd.sun.j2me.app-descriptor');
header('Content-Disposition: attachment; filename="'.basename($d[0]).'.jad";');

echo $content[0]['content']."\n".'MIDlet-Jar-Size: '.$filesize."\n".'MIDlet-Jar-URL: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/'.$d[0];
}
else{
print $hackmess;
}
?>