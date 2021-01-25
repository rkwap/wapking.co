<?php
include('config_click.php');



include 'moduls/header.php';
echo '<div class="menu">Access to the section is closed!</div>';
echo '<div class="a">';  

$surl = str_replace('http://','',$url);

echo "<b>ERROR</b><br/>
Sorry, but no access from a computer or Opera-Mini. <br/>
Please go to<br/>
<a href=\"$url\">$surl</a><br/>
from your mobile phone browser.<br/>";

echo '</div>';
echo '
<div class="a"><div class="i_bar_t"><a href="index.php?">Downloads</a></div>
<div class="i_bar_t"><a href="'.$setup['site_url'].'">To the main</a></div>
';

echo '</div><div class="title">';
include 'moduls/foot.php';
echo '</div></div>';

?>