<?php
list($msec,$sec)=explode(chr(32),microtime());
$HeadTime=$sec+$msec;
include 'moduls/ini.php';
session_name ('SID') ;
session_start() ;
include 'moduls/fun.php';
include 'moduls/connect.php';
include 'moduls/header.php';
//
//
$id = intval($_GET['id']);


//


mysql_query('UPDATE `loginlog` SET `time`="", `access_num`=0 WHERE `id` = 1;');
$all = mysql_fetch_row(mysql_query('SELECT COUNT(`id`) FROM `loginlog`;'));
if($all[0] > 21)
{
$min = mysql_fetch_row(mysql_query('SELECT MIN(`id`) FROM `loginlog` WHERE `id` > 1;'));
$query = mysql_query('DELETE FROM `loginlog` WHERE `id` = '.$min[0]);
}

$error = 0;
if(empty($_SESSION['autorise'])) $error = 1;
if($_SESSION['autorise']!= $setup['password']) $error = 1;
if(empty($_SESSION['ipu'])) $error = 1;
if($_SESSION['ipu']!=clean($ip)) $error = 1;
if($error==1) die($setup['hackmess']);

echo ' <div class="logo"><img alt="Wapking" src="http://freemaza.in/images/FreeMaza.in_logo.gif" /><br></div>
         <center><font color="#FF0000"><b>Free Maza For Your Phone</b></font></center>

';

if(!($_POST[papka]))
{
echo("<br><h2>Mass Renaming Files</h2><p>");
echo('<form action="rename.php" method="post">
Folder with files:<br>(example files /! kartinki / kotiki)<br><input type=text name=papka value=files/!><p>
Your website :<br><input type=text name=url maxlength=20 size=21><p>
Prefix (img_) :<br><input type=text name=pered maxlength=20 size=21 value=Text_><p>
<input type=submit value=Accept!><br>
<br><b><a href="apanel.php"><<<Back</a><br/></b>');
}
else
{


$dir=$_POST[papka];
if(!($panika=@opendir($dir)))
die('No such folder<br><b><a href="rename.php"><<<Back</a><br/></b>');

function my_rename($dirname) 
{ 
   
    $s=strlen($_POST[url]);
    $s=$s+5;
    $kol=strlen($_POST[pered]);
    $nomer=$s+$kol;
    $ext_arr = array('jpeg', 'jpg', 'gif', 'txt', 'gif'); 
    $dir = opendir($dirname); 
    $count = 1; 
    while (($file = readdir($dir)) !== false) { 
     $bexa=strlen($count);
     $bumer=$nomer+$bexa-4;
        if (is_file($dirname . '/' . $file)) { 
            $info = pathinfo($dirname . '/' . $file); 
            if (in_array(strtolower($info['extension']), $ext_arr)) { 
                rename($dirname . '/' . $file, $dirname . '/' . str_pad($count, $bumer , "$_POST[pered]$_POST[url]_", STR_PAD_LEFT) . '.' . strtolower($info['extension'])); 
                $count ++ ; 
            } 
        } elseif (is_dir($dirname . '/' . $file) && $file != '.' && $file != '..')my_rename($dirname . '/' . $file); 
    } 
    closedir($dir); 
} 
if($_POST[papka])
{
$dir="$_POST[papka]";
my_rename("$dir"); 
print("Rename completed");
}}
?>