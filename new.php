<?php

require 'moduls/ini.php';
require 'moduls/fun.php';
require 'moduls/connect.php';
require 'moduls/header.php';
require 'online.php';

############### If new items are off ##########
if ($ setup ['new_change'] == 0) die ('Not found');
############### Checking Variables ###############

$ onpage = get2ses ('onpage');
$ prew = get2ses ('prew');
$ sort = get2ses ('sort');
$ id = intval ($ _ GET ['id']);
$ id1 = intval ($ _ GET ['id1']);
$ page = intval ($ _ GET ['page']);

is_num ($ onpage, 'onpage');
is_num ($ prew, 'prew');

if ($ prew! = 0 and $ prew! = 1) {
$ prew = $ setup ['preview'];
}


$ valid_sort = array ('load' => '', 'eval' => '');
if (! isset ($ valid_sort [$ sort])) $ sort = 'load';
if ($ sort == 'load') $ MODE = '`loads`> 0 AND` size`> 0 ORDER BY `loads` DESC';
if ($ sort == 'eval' and $ setup ['eval_change']) $ MODE = 'yes`> 0 AND `size`> 0 ORDER BY` yes` DESC';
############### Preparing the header ###################
if ($ setup ['eval_change'] == 1) $ eval = '<div class = "menu1"> <div class = "menu4"> <a href="new.php?sort=eval"> rating </ a> </div> </div> '; else $ eval = '';
if ($ sort == 'load') $ sortlink = $ eval;
if ($ sort == 'eval' and $ setup ['eval_change'] == 1) $ sortlink = '<div class = "menu1"> <div class = "menu4"> <a href = "new.php? sort = load "> popularity </a> </div> </div> ';





if ($ id1)
{
$ d = mysql_fetch_assoc (mysql_query ('SELECT `path` FROM` files` WHERE `id` ='. $ id1. 'LIMIT 1'));
if (! is_dir ($ d ['path'])) die ('Folder not found. </body> </html>');
$ MODE = '`timeupload`>'. ($ Time- (86400 * $ setup ['day_new'])). ' AND `size`> 0 AND` infolder` LIKE "'. $ D [' path '].'%" ';
}
else $ MODE = '`timeupload`>'. ($ time- (86400 * $ setup ['day_new'])). ' AND `size`> 0 ORDER BY` loads` DESC ';

############### Getting the list of files ###############
$ query = mysql_query ('SELECT * FROM `files` WHERE'. $ MODE. '');

while ($ list_sw = mysql_fetch_array ($ query)) {
$ array_id [] = $ list_sw ['id'];
}
$ all = sizeof ($ array_id);
###############Conclusion###############
echo '<div class = "menu1"> <div class = "menu3"> <img src = "dis / about.png" alt = ""> New Arrivals </div> </div> <div class = "menu1 "> <div class =" menu3 "> <div class =" menu3 "> <br> Sorting: '. $ sortlink.' </div> </div> ';
############### Pages ###############
if (! isset ($ page)) $ page = 1;
$ n = 0;
$ pages = ceil ($ all / $ onpage);
if (! $ pages) $ pages = 1;
if ($ page) $ n = ($ onpage * $ page) - $ onpage;
############### If not ... ###########
if ($ all == 0) echo 'Empty so far :(';
############### Listing #############
for ($ i = 1; $ i <= $ onpage; $ i ++)
{
if (! isset ($ array_id [$ n])) {
$ n ++;
continue;
}
if (is_integer ($ n / 2)) $ row = '<div class = "a">'; else $ row = '<div class = "a">';
$ file_info = mysql_fetch_array (mysql_query ('SELECT * FROM `files` WHERE` id` ='. $ array_id [$ n]));
$ backdir = @mysql_fetch_array (mysql_query ("SELECT * FROM` files` WHERE `path` = '" .clean ($ file_info [' infolder ']). "'"));
$ basename = basename ($ file_info ['path']);
$ ex = pathinfo ($ file_info ['path']);
$ ext = strtolower ($ ex ['extension']);
$ name_file = str_replace ('.'. $ ex, '', $ basename);
// Transliteration
if (strpos ($ basename, '!')! == false) {
$ name_file = trans ($ name_file);
}
else {
$ name_file = trans2 ($ name_file);
}

// Nice size
if ($ file_info ['size'] <1024) $ file_info ['size'] = '('. $ file_info ['size']. 'b)';
elseif ($ file_info ['size'] <1048576 and $ file_info ['size']> = 1024) $ file_info ['size'] = '(' .round ($ file_info ['size'] / 1024, 2). 'Kb)';
else $ file_info ['size'] = '(' .round ($ file_info ['size'] / 1024/1024, 2). 'Mb)';

// Preview
$ pre = '';
if ($ prew == 1)
{
if ($ ext == 'bmp') {
$ pre = 'Impossible Preview <br>';
}
elseif ($ ext == 'gif' or $ ext == 'jpeg' or $ ext == 'jpe' or $ ext == 'jpg' or $ ext == 'png') {
$ pre = '<img style = "margin: 1px;" src = "im.php? bab = 1 & id = '. $ file_info [' id '].'" alt = "" /> <br/> ';
}
}
$ new_info = '';
if ($ sort == 'load') $ info = '[<font color = "# FFFF00">'. $ file_info ['loads']. '</font>]';
if ($ sort == 'eval' and $ setup ['eval_change'] == 1) $ info = '[<font color = "# 800000">'. $ file_info ['yes'].' </font> / <font color = "# 004080"> '. $ file_info [' no '].' </font>] ';
$ filtime2 = $ file_info ['timeupload'] + (3600 * 24 * $ setup ['day_new']);
if ($ filtime2> = $ time) $ new_info = '(New)';
// Icon to the file
if (! file_exists ("ext / $ ext.png")) $ ico = '<img src = "ext / stand.png" alt = "">'; else $ ico = '<img src = "ext /'.$ ext.'. png" alt = ""> ';
if ($ setup ['ext'] == 1) $ extension = '('. $ ext. ')'; else $ extension = '';
// Own output
echo $ row. $ pre. ' '. $ ico.' <strong> <a href="view.php?id='.$file_info ['id' ].'"> '. $ name_file.' </a> </strong> '. $ extension. $ file_info ['size']. $ info. '[<a href="index.php?id='.$backdir ['id'>] .'"> In category </a>] <br> < / div> ';
$n++;
}

//------------------------------------------------------------------------------------------
echo '
<div class="a">Pages: ';
$asd = $page - 2;
$asd2 = $page + 3;
if($asd<$all && $asd>0 && $page>3) {if($id1)  echo '<a href="new.php?page=1&id1='.$id1.'">1</a> ... '; else echo '<a href="new.php?page=1&id1='.$id1.'">1</a> ... ';}
for($i=$asd; $i<$asd2;$i++)
{
if($i<$all && $i>0)
{
if ($i > $pages ) break;
if ($page==$i) 	echo '<strong>['.$i.']</strong> ';
else {if($id1)  echo '<a href="new.php?page='.$i.'&id1='.$id1.'">'.$i.'</a> '; else echo '<a href="new.php?page='.$i.'">'.$i.'</a> ';}
}
}

if ($i <= $pages)
{
if($asd2<$all) {if($id1) echo ' ... <a href="new.php?page='.$pages.'&id1='.$id1.'">'.$pages.'</a>'; else echo ' ... <a href="new.php?page='.$pages.'">'.$pages.'</a>';}
}
//------------------------------------------------------------------------------------------
echo '</div>';
echo '
<div class="menu1"><div class="menu3"><a href="index.php?">Downloads</a></div>
<div class="menu1"><a href="'.$setup['site_url'].'">Home</a></div>
';
echo '</div>';
if($setup['online'] == 1)echo '<div class="menu">Online: <strong>'.$all_online[0].'</strong></div>';
echo'<div class="title">';
include 'moduls/foot.php';
echo '</div>';
?>