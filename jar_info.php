<?php
$id = intval($_GET['id']);
$tex2='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/jad.php?id='.$id;
$tex2=str_replace('\/','/',$tex2);
$file=file($tex2);

$total = count($file);
for ($p=0; $p<$total; $p++) {
$dt = explode(":", $file[$p]);
if($dt[0]=="MIDlet-Vendor"){ $poz=$dt[0].':'.$dt[1].'';
}}
$poz = str_replace('MIDlet-Vendor:', '',$poz);
htmlspecialchars($poz);


$total = count($file);
for ($p=0; $p<$total; $p++) {
$dt = explode(":", $file[$p]);
if($dt[0]=="MIDlet-Version"){ $ver=$dt[0].':'.$dt[1].'';
}}
$ver = str_replace('MIDlet-Version:', '',$ver);
htmlspecialchars($ver);

?>

