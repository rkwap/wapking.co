<?php
require 'moduls/ini.php';
require 'moduls/fun.php';
require 'moduls/connect.php';
$all_files = mysql_fetch_row(mysql_query('SELECT COUNT(*) FROM `files` WHERE `size` > 0'));
$new_all_files = mysql_fetch_row(mysql_query('SELECT COUNT(*) FROM `files` WHERE `timeupload` > '.($time-(86400*$setup['day_new'])).' AND `size` > 0'));
if($new_all_files[0]!=0) $new_all = '<font color="red">+'.(int)$new_all_files[0].'</font>'; else $new_all="";
 //echo '('.(int)$all_files[0].')<font color="red">+'.(int)$new_all_files[0].'</font>';
    echo '('.(int)$all_files[0].')'.$new_all.'';
?>
