<?php
error_reporting(0);
include 'moduls/header.php';
echo $head;

$dbfile='db.txt';
$array=file($dbfile);

$iarray=implode("|",$array);
$earray=explode("|",$iarray);
$earray=array_reverse($earray);
$perpage='10'; $page=$_GET['page'];
if(empty($page)) { $page='1'; } $total=count($earray)-1; $item=($perpage*$page)-$perpage;
$totalpage=ceil($perpage/$total);
$cfile=$item+$perpage;

echo '<h2>Latest Updates</h2>';
for($i=$item;$i<$cfile;$i++) { echo '<div class="catRow">'.$earray[$i].'</div>'; }

if($page <= $totalpage) { $nextpage=$page+1;
$prevpage=$page-1;
if($page=='1') { $prev='< Prev';  }

else { $prev='<a href="?page='.$prevpage.'">< Prev</a>';
}
$next='<a href="?page='.$nextpage.'">Next ></a>'; }
else { $prev='< Prev'; $next='Next >'; }
echo '<div class="pgn">'.$prev.' | '.$next.'</div>';
echo '<div class="ftrLink" align="center"><a href="'.$siteurl.'" class="siteLink" align="center">Wapking.HostZI.Com</a></div></body></html>';
?>
