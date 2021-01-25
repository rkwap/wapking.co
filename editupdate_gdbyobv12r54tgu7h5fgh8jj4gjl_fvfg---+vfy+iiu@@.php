<?php
error_reporting(0);

include 'moduls/header.php';
echo $head;

echo '<div class="logo"><img alt="Wapking" src="http://freemaza.in/images/FreeMaza.in_logo.gif" /><br></div>
         <center><font color="#FF0000"><b>Free Maza For Your Phone</b></font></center>';


$dbfile='db.txt';
$array=file($dbfile);

$iarray=implode("|",$array);
$earray=explode("|",$iarray);
$earray=array_reverse($earray);
$perpage='6'; $page=$_GET['page'];
if(empty($page)) { $page='1'; } $total=count($earray)-1; $item=($perpage*$page)-$perpage;
$totalpage=ceil($perpage/$total);
$cfile=$item+$perpage;

echo '<h2>Edit/Delete Updates</h2>';
for($i=$item;$i<$cfile;$i++) { echo '<div class="catRow">'.$earray[$i].'<br><br><a href="editor_gdbyobv12r54tgu7h5fgh8jj4gjl_fvfg---+vfy+iiu@@.php?edit='.$earray[$i].'">[Edit]</a><br><a href="delupdate_gdbyobv12r54tgu7h5fgh8jj4gjl_fvfg---+vfy+iiu@@.php?edit='.$earray[$i].'">[Delete]</a></div>'; }

if($page <= $totalpage) { $nextpage=$page+1;
$prevpage=$page-1;
if($page=='1') { $prev='< Prev';  }

else { $prev='<a href="?page='.$prevpage.'">< Prev</a>';
}
$next='<a href="?page='.$nextpage.'">Next ></a>'; }
else { $prev='< Prev'; $next='Next >'; }
echo '<div class="pgn">'.$prev.' | '.$next.'</div>';
echo $foot;
?>
