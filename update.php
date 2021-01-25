<?php
error_reporting(0);
include 'setup.php';
include 'apanel_settings.php';
$update=$_GET['update']; $dbfile='db.txt';
$thedata=fopen($dbfile,"a+");
fclose($dbfile);
echo '
   <div class="updates">
   
   <h2>Latest Updates</h2>
   ';
$perpage='18'; $page=$_GET['page'];
if(empty($page)) { $page='1'; } $total=count($earray)-1; $item=($perpage*$page)-$perpage;
$totalpage=ceil($perpage/$total);
$cfile=$item+$perpage;

$array=file($dbfile);

$iarray=implode("|",$array);
$earray=explode("|",$iarray);
$earray=array_reverse($earray);
for($i=$item;$i<$cfile;$i++) { echo '
   <div>
   '.$earray[$i].'</div>
   '; }
echo '
   <div>
   <a href="moreupdates.php"><b>[More Updates..]</b></a></div>
   </div>
   
   ';
?>