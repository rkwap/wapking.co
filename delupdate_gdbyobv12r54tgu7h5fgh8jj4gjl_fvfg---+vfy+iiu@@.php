<?php 
include 'moduls/header.php';
$edit=$_GET['edit'];
$dbfile='db.txt';
if($edit) {
$contents=file_get_contents($dbfile);
$newcontents=str_replace("|$edit","",$contents);
if(file_put_contents($dbfile,$newcontents)) { echo 'Update Deleted!'; } }
else { echo 'First Select Update to Delete'; } ?>