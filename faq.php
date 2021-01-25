<?php

require 'moduls/ini.php';
require 'moduls/fun.php';
require 'moduls/connect.php';
require 'moduls/header.php';
echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';
echo "
<meta name=\"title\" content=\" Funwap.Org - $list[3]|$put1\"/>";
echo '
<meta name="robots" content="index,follow"/>
<meta name="language" content="en" />';
echo "
<meta name=\"description\" content=\" Funwap.Org - $list[3].$ext|$put1\"/>";
echo "
<meta name=\"keywords\" content=\"$list[3],wapking,android games,android apps,games,wallpapers,mp3,jar,themes,nokia, micromax,wapindia,wapking.in,free games\"/>";
echo "

<title>Funwap.Org - $list[3]|$put1</title>";
echo '
<link rel="shortcut icon" href="icon.ico" />';
echo '
<link href="http://m.krazysms.in/css/krazysms_m.css?1.2" rel="stylesheet" style="text/css">

</head>
<body>    
         <div class="logo"><img alt="Wapking" src="http://m.wapsms.in/images/m.WapSMS.in_logo.gif" /><br></div>


';
require 'online.php';

############### If the top is off ###############
if ($setup['top_change'] == 0) die('Not found');
############### Checking Variables ###############
$onpage = 5;
$allpage = 100000000000000;
$prew = get2ses('prew');
$sort = get2ses('sort');
$id = intval($_GET['id']);
$page = intval($_GET['page']);

is_num($onpage, 'onpage');
is_num($prew, 'prew');

if ($prew! = 0 and $prew! = 1)
{
    $prew = $setup['preview'];
}

$MODE = '`priority` ASC,` timeupload` DESC';

$valid_sort = array(
    'load' => '',
    'eval' => ''
);
if (!isset($valid_sort[$sort])) $sort = 'load';
if ($sort == 'load') $MODE = '`loads`> 0 AND` size`> 0 ORDER BY `loads` DESC';
if ($sort == 'eval' and $setup['eval_change']) $MODE = 'yes`> 0 AND `size`> 0 ORDER BY` yes` DESC';
############### Preparing the header ###################
if ($setup['eval_change'] == 1) $eval = '<div class = "menu1"> <div class = "menu4"> <a href="faq.php?sort=eval"> Rating </ a> </div> </div> ';
else $eval = '';
if ($sort == 'load') $sortlink = $eval;
if ($sort == 'eval' and $setup['eval_change'] == 1) $sortlink = '<div class = "menu1"> <div class = "menu4"> <a href = "faq.php? sort = load "> Popularity </a> </div> </div> ';
############### Getting the list of files ###############
$query = mysql_query('SELECT * FROM `files` WHERE' . $MODE . 'LIMIT 0,' . $allpage);

while ($list_sw = mysql_fetch_array($query))
{
    $array_id[] = $list_sw['id'];
}
$all = sizeof($array_id);
###############Conclusion###############
echo '<br> <h1> Latest SMS </h1>';
############### Pages ###############
if (!isset($page)) $page = 1;
$n = 0;
$pages = ceil($all / $onpage);
if (!$pages) $pages = 1;
if ($page) $n = ($onpage * $page) - $onpage;
############### If not ... ###########
if ($all == 0) echo 'While empty :(';
############### Listing #############
for ($i = 1;$i <= $onpage;$i++)
{
    if (!isset($array_id[$n]))
    {
        $n++;
        continue;
    }
    if (is_integer($n / 2)) $row = '<div class = "a">';
    else $row = '<div class = "a">';
    $file_info = mysql_fetch_array(mysql_query('SELECT * FROM `files` WHERE` id` =' . $array_id[$n]));
    $backdir = @mysql_fetch_array(mysql_query("SELECT * FROM` files` WHERE `path` = '" . clean($file_info[' infolder ']) . "'"));
    $basename = basename($file_info['path']);
    $ex = pathinfo($file_info['path']);
    $ext = strtolower($ex['extension']);
    $name_file = str_replace('.' . $ex, '', $basename);
    // Transliteration
    if (strpos($basename, '!') ! == false)
    {
        $name_file = trans($name_file);
    }
    else
    {
        $name_file = trans2($name_file);
    }

    // Nice size
    if ($file_info['size'] < 1024) $file_info['size'] = '(' . $file_info['size'] . 'b)';
    elseif ($file_info['size'] < 1048576 and $file_info['size'] > = 1024) $file_info['size'] = '(' . round($file_info['size'] / 1024, 2) . 'Kb)';
    else $file_info['size'] = '(' . round($file_info['size'] / 1024 / 1024, 2) . 'Mb)';

    // Preview
    $pre = '';
    if ($prew == 1)
    {
        if ($ext == 'bmp')
        {
            $pre = 'Impossible Preview <br>';
        }
        elseif ($ext == 'gif' or $ext == 'jpeg' or $ext == 'jpe' or $ext == 'jpg' or $ext == 'png')
        {
            $pre = '<img style = "margin: 1px;" src = "im.php? bab = 1 & id = ' . $file_info[' id '] . '" alt = "" /> <br/> ';
        }
    }
    $new_info = '';
    if ($sort == 'load') $info = '[<font color = "# FFFF00">' . $file_info['loads'] . '</font>]';
    if ($sort == 'eval' and $setup['eval_change'] == 1) $info = '[<font color = "# 800000">' . $file_info['yes'] . ' </font> / <font color = "# 004080"> ' . $file_info[' no '] . ' </font>] ';
    $filtime2 = $file_info['timeupload'] + (3600 * 24 * $setup['day_new']);

    /////// files
     / *echo $row . $pre . ' ' . $ico . ' <strong> <a href="view.php?id=' . $file_info['id'] . '"> ' . $name_file . ' </a> </strong> ' . $extension . $file_info['size'] . $info . '[<a href="index.php?id=' . $backdir['id' > ] . '"> In category </a>] <br> < / div> '; * /

    if ($setup['ext'] == 1) $extension = "($ ext)";
    else $extension = '';

    $file_info2 = mysql_fetch_array(mysql_query('SELECT `id`,` name`, `path`,` fastabout`, `timeupload`,` infolder`, `size`,` loads`, `yes`,` no` FROM ` files` WHERE `id` =" ' . $value2 . ' "; '));

    $file_info = mysql_fetch_array(mysql_query('SELECT `id`,` name`, `path`,` fastabout`, `timeupload`,` infolder`, `size`,` loads`, `yes`,` no` FROM ` files` WHERE `id` =" ' . $value2 . ' "; '));

    $ex = pathinfo($file_info['path']);
    $ext = strtolower($ex['extension']);
    $id2 = $file_info[id];
    $file_infoff = mysql_fetch_array(mysql_query('SELECT * FROM `files` WHERE` id` =' . $id2));
    $filename = pathinfo($file_info2['path']);
    $ext = $filename['extension'];
    $dir = $filename['dirname'] . '/';
    $filename = $filename['basename'];
    $id = intval($_GET['id']);

    if ($setup['ext'] == 1) $extension = "($ ext)";
    else $extension = '';

    if (is_file($setup['opath'] . '/' . $filename . '. txt')) // if it is in a file
    
    {
        $f = file_get_contents($setup['opath'] . '/' . $filename . '. txt');
        $f = substr($f, 0.300);
        $f = htmlentities($f, ENT_QUOTES, 'UTF-8');
        echo '' . $f . '... ';
        $outp = 1;
    }
    $popis = file_get_contents($file_info2['path']);
    $popis = substr($popis, 0.1000000);
    echo '' . $row . '<div class = "smsBy"> By: <a href=""> <strong>' . $file_info['name'] . '</strong> </a> In: < a href = ""> // <strong> ' . $s[' name '] . ' </strong> </a> </div> ' . $popis . ' <br> ';

    $popistxt = str_replace('<br>', '', $popis);
    $popistxt = str_replace('<p class = "sms">', '', $popistxt);
    $popistxt = str_replace('</p>', '', $popistxt);

    echo '<div class = "smsInfo">';
    if ($setup['eval_change'] == 1)
    {
        $i = @round(($file_info['yes']) / ($file_info['yes'] + $file_info['no']) * 100, 0);

        echo '<div> Like:' . $file_info['yes'] . ' - SMS Length: ';
        echo strlen($popis);
        echo '</div>';
        if ($vote == 0)

        echo '<div> <a href="http://m.funwap.org/indexsms.php?id=' . $file_info['id' > ] . '&eval=1"> <img src = "http: / /m.krazysms.in/images/heart.png">Like SMS </a> - <a href = "sms:? body = ' . $popistxt . ' - By SMS.in "> Forward SMS </a> </div> ';

        echo '<div> <a href = "mailto:? subject = An SMS For You - SMS.In & body =' . $popistxt . ' - By SMS.in "> Send By Email </a> </div> ';

        $file_info['timeupload'] = date('D - d: F: Y (g: i A)', $file_info['timeupload']);

        echo '<div>' . $file_info['timeupload'] . ' ago </div> ';
    }
    ///////////////
    

    $n++;
}
// ------------------------------------------------ ------------------------------------------
echo '
<div class = "a"> Pages: ';
$asd = $page - 2;
$asd2 = $page + 3;
if ($asd < $all && $asd > 0 && $page > 3) echo '<a href="faq.php?page=1"> 1 </a> ...';
for ($i = $asd;$i < $asd2;$i++)
{
    if ($i < $all && $i > 0)
    {
        if ($i > $pages) break;
        if ($page == $i) echo '<strong> [' . $i . '] </strong>';
        else echo '<a href="faq.php?page=' . $i . '">' . $i . '</a>';
    }
}

if ($i <= $pages)
{
    if ($asd2 < $all) echo '... <a href = "faq.php? page =' . $pages . '">' . $pages . '</a> </div>';
}
// ------------------------------------------------ ------------------------------------------
echo '
</div>
<div class = "menu1"> <div class = "menu3"> <a href="index.php?"> Downloads </a> </div>
<div class = "menu1"> <a href="' . $setup['site_url' > ] . '"> Home </a> </div>
';
echo '</div>';
if ($setup['online'] == 1) echo '<div class = "menu"> Online: <strong>' . $all_online[0] . '</strong> </div>';
echo '<div class = "title">';
include 'moduls / foot.php';
echo '</div>';

?>
