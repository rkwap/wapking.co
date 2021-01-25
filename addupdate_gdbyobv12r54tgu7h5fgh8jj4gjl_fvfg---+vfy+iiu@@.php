<?php 
include 'moduls/header.php';
echo '<strong>Example:</strong><br><textarea name="txt_descripcion" cols="66" rows="10" id="txt_descripcion"><a href=http://m.funwap.org/Category/1/Android-Zone.html><b>1Tap Cleaner Pro, GO Backup .......<br><Font color="green">[Download More..]</font></a></b></textarea>';


$update=$_GET['update']; $dbfile='db.txt';
$thedata=fopen($dbfile,"a+");
if($update) { $writedata=fputs($thedata,"|$update"); }
fclose($dbfile);
if($update) {
if($writedata) { echo $head; echo ''.$update.' Added to Database'; echo $foot;  } }

else { echo $head; echo '<div class="ftrLink"  align="center"><form method="get" action="addupdate_gdbyobv12r54tgu7h5fgh8jj4gjl_fvfg---+vfy+iiu@@.php">Add Update:
<textarea type="text" name="update"/></textarea><input type="submit" value="Submit"/></form></div>'; echo $foot; }
?>
