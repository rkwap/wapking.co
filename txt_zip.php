<?php

include 'moduls/ini.php';
include 'moduls/connect.php';
include 'moduls/fun.php';


$id = intval($_GET['id']);

$d = mysql_fetch_row(mysql_query('SELECT TRIM(`path`) FROM `files` WHERE `id` = '.$id.' LIMIT 1'));


if(file_exists($d[0])){
mysql_query('UPDATE `files` SET `loads`=`loads`+1, `timeload`='.$time.' WHERE `id`='.$id);

$tmp = $setup['zpath'].'/'.basename($d[0]).'.zip';

if(!file_exists($tmp)){
include 'moduls/pclzip.lib.php';

$zip = new PclZip($tmp);

function cb($p_event, &$p_header){
$p_header['stored_filename'] = basename($p_header['filename']);
return 1;
}
$zip->create($d[0], PCLZIP_CB_PRE_ADD, 'cb');
chmod($tmp,0644);
}

header('Location: '.$tmp, true, 301);
}
else{
print $hackmess;
}

?>