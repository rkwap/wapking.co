<?php 
include 'moduls/header.php';
$edit=$_GET['edit'];
$new=$_GET['new'];
$dbfile='db.txt';
if($edit and $new) {
$contents=file_get_contents($dbfile);
$newcontents=str_replace("|$edit","|$new",$contents);
if(file_put_contents($dbfile,$newcontents)) { echo 'Database Edited!'; } }
elseif($edit and !$new) { echo '<div class="ftrLink"  align="center">'.$head.'<form method="get" action="editor.php"><input type="hidden" name="edit" value="'.$edit.'"/>Edit Update: <input type="text" name="new" value="'.$edit.'"/><input type="submit" value="Edit"/>'.$foot.'</div>';  }
else { echo ''.$head.'First Select Update to Edit'.$foot.''; } ?>