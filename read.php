<?php


require 'moduls/ini.php';
require 'moduls/fun.php';
require 'moduls/connect.php';
require 'moduls/header.php';
require 'kodirovka.php';


$id = intval($_GET['id']);
$id2 = intval($_GET['id2']);
$page = intval($_GET['page']);
$file_info = mysql_fetch_assoc(mysql_query('SELECT * FROM `files` WHERE `id` = '.$id));
if(!is_file($file_info['path'])){
die('Файл не существует');
}
if(session_start()){
if(!empty($_SESSION["font"]) AND !empty($_POST['font'])){
$_SESSION["font"]=$_POST['font'];
}
elseif(empty($_SESSION["font"]) AND !empty($_POST['font']))
{
 $font=$_POST['font'];
 session_register ("font") ;
}


if(!empty($_SESSION["number"]) AND !empty($_POST['number']))
$_SESSION["number"]=$_POST['number'];
elseif(empty($_SESSION["number"]) AND !empty($_POST['number']))
{
 $number=$_POST['number'];
 session_register ("number") ;
}
 }
 if(!$_SESSION["number"]) $_SESSION["number"]=2000; 
 if(! $_SESSION["font"])  $_SESSION["font"]=2;
$font= intval($_SESSION["font"]);
$number= intval($_SESSION["number"]);
###################################################
$text=file_get_contents($file_info['path']);
$nf = pathinfo($file_info['path']);
$filename = $nf['basename'];
if(is_file($setup['spath'].'/'.$filename.'.gif') and empty($page))
echo '<div class="menu"><p align="center"><img src="'.$setup['spath'].'/'.$filename.'.gif" alt="prev"></p></div>';


function highlight_code($code) 

{ 

  $code = stripslashes($code); 
  $code = trim($code); 
  return highlight_string($code,true);

} 
///echo $text;
//$text=str_replace('<','&lt;',$text);
//$text=str_replace('>','&gt',$text);
//$text=str_replace("\n",'<br>',$text);
  $simvol = $number; // Число символов на страницу по умолчанию
                $tx =$text;
                if (!empty($_GET['page']))
                {
                    $page = intval($_GET['page']);
                } else
                {
                    $page = 1;
                }
                
                # для постраничного вывода используется модифицированный код от hintoz #
                $strrpos = mb_strrpos($tx, " ");
                $pages = 1;
                $t_si = 0;
                if ($strrpos)
                {
                    while ($t_si < $strrpos)
                    {
                        $string = mb_substr($tx, $t_si, $simvol);
                        $t_ki = mb_strrpos($string, " ");
                        $m_sim = $t_ki;
                        $strings[$pages] = $string;
                        $t_si = $t_ki + $t_si;
                        if ($page == $pages)
                        {
                            $page_text = $strings[$pages];
                        }
                        if ($strings[$pages] == "")
                        {
                            $t_si = $strrpos++;
                        } else
                        {
                            $pages++;
                        }
                    }
                    if ($page >= $pages)
                    {
                        $page = $pages - 1;
                        $page_text = $strings[$page];
                    }
                    $pages = $pages - 1;
                    if ($page != $pages)
                    {
                        $prb = mb_strrpos($page_text, " ");
                        $page_text = mb_substr($page_text, 0, $prb);
                    }
                } else
                {
                    $page_text = $tx;
                }
                $page_text=highlight_code($page_text);
                 $page_text=charset_x_win($page_text);
                 $page_text=iconv("windows-1251", "UTF-8", "$page_text");
                // Текст статьи
              /*  $page_text = htmlentities($page_text, ENT_QUOTES, 'UTF-8');
                $page_text = str_replace("\n",'<br>', $page_text); */
                echo '<font size="'.intval($font).'">'.$page_text.'</font>';
                echo '<hr />';
                $next = $page + 1;
                $prev = $page - 1;
                if ($pages > 1)
                {
                   
                    if ($page > 1)
                    {
                        print " <a href=\"read.php?id=$id&amp;page=$prev\">&lt;&lt;</a> ";
                    }
                    if ($offpg != 1)
                    {
                        if ($page > 1)
                        {
                            print "<a href=\"read.php?id=$id&amp;page=1\">1</a> ";
                        }
                        if ($prev > 2)
                        {
                            print " .. ";
                        }
                        $page2 = $pages - $page;
                        $pa = ceil($page / 2);
                        $paa = ceil($page / 3);
                        $pa2 = $page + floor($page2 / 2);
                        $paa2 = $page + floor($page2 / 3);
                        $paa3 = $page + (floor($page2 / 3) * 2);
                        if ($page > 13)
                        {
                            echo ' <a href="read.php?id='.$id.'&amp;page=' . $paa . '">' . $paa . '</a> <a href="read.php?id='.$id.'&amp;page=' . ($paa + 1) . '">' . ($paa + 1) . '</a> .. <a href="read.php?id='.$id.'&amp;page=' . ($paa * 2) . '">' . ($paa *
                                2) . '</a> <a href="read.php?id='.$id.'&amp;page=' . ($paa * 2 + 1) . '">' . ($paa * 2 + 1) . '</a> .. ';
                        } elseif ($page > 7)
                        {
                            echo ' <a href="read.php?id='.$id.'&amp;page=' . $pa . '">' . $pa . '</a> <a href="read.php?id='.$id.'&amp;page=' . ($pa + 1) . '">' . ($pa + 1) . '</a> .. ';
                        }
                        if ($prev > 1)
                        {
                            print "<a href=\"read.php?id=$id&amp;page=$prev\">$prev</a> ";
                        }
                        echo "<b>$page</b> ";
                        if ($next < $pages)
                        {
                            print "<a href=\"read.php?id=$id&amp;page=$next\">$next</a> ";
                        }
                        if ($page2 > 12)
                        {
                            echo ' .. <a href="read.php?id='.$id.'&amp;page=' . $paa2 . '">' . $paa2 . '</a> <a href="read.php?id='.$id.'&amp;page=' . ($paa2 + 1) . '">' . ($paa2 + 1) . '</a> .. <a href="read.php?id='.$id.'&amp;page=' . ($paa3) . '">' . ($paa3) .
                                '</a> <a href="read.php?id='.$id.'&amp;page=' . ($paa3 + 1) . '">' . ($paa3 + 1) . '</a> ';
                        } elseif ($page2 > 6)
                        {
                            echo ' .. <a href="read.php?id='.$id.'&amp;page=' . $pa2 . '">' . $pa2 . '</a> <a href="read.php?id='.$id.'&amp;page=' . ($pa2 + 1) . '">' . ($pa2 + 1) . '</a> ';
                        }
                        if ($next < ($pages - 1))
                        {
                            print " .. ";
                        }
                        if ($page < $pages)
                        {
                            print "<a href=\"read.php?id=$id&amp;page=$pages\">$pages</a> ";
                        }
                    } else
                    {
                        echo "<b>[$page]</b>";
                    }
                    if ($page < $pages)
                    {
                        print " <a href=\"read.php?id=$id&amp;page=$next\">&gt;&gt;</a>";
                    }
                    echo '<form action="read.php"><div class="i_bar">Стр:<input type="hidden" name="read" value="' . $read .'"/>
                                                                          <input type="hidden" name="id" value="' . $id .'"/>
                        <input class="enter" name="page" type="text" maxlength="4" size="2" value="' . $page .'">
&nbsp;<input class="buttom" type="submit" value="GO">
</div></form>';
                }
###################################################
echo '
<form action="read.php?id='.$id.'&amp;page='.$page.'" method="post">
<div class="i_bar">
Font
<select class="buttom" size="1" width="70" name="font"><option value="'.$font.'">'.$font.'</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select><br>
Number of characters per page
<select class="buttom" size="1" width="70" name="number"><option value="'.$number.'">'.$number.'</option><option value="500">500</option><option value="1000">1000</option><option value="2000">2000</option><option value="3000">3000</option><option value="4000">4000</option><option value="5000">5000</option><option value="6000">6000</option><option value="7000">7000</option><br>
<br/>
<input type="submit" value="OK"/></form>
</div><div class="a">

<a href="load.php?id='.$id.'">Download [TXT]</a><br/>
<a href="txt_zip.php?id='.$id.'">Download [ZIP]</a><br/>
<a href="txt_jar.php?id='.$id.'">Download [JAR]</a><br/>

</div>
<div class="a">
<div class="menu1"><div class="menu3"><a href="view.php?id='.$id.'">To file</a></div></div>
<div class="menu1"><div class="menu3"><a href="index.php?id='.$id2.'">In category</a></div></div>
<div class="menu1"><div class="menu3"><a href="index.php?">Downloads</a></div></div>
<div class="menu1"><a href="'.$setup['site_url'].'">Home</a></div>


';
echo '</div><div class="title">';
include 'moduls/foot.php';
echo '</div>';
  
?>
