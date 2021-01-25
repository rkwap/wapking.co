<?php
echo '<div class="a">';
if($setup['search_change']==1) echo '<img src="imagini/search.png"width="14" height="14" alt="*"/><a href="search.php">Search</a></div>';

if($setup['top_change']==1) echo '<div class="menu3"><img src="imagini/top.png"width="14" height="14" alt="*"/><a href="top.php">TOP '.$setup['top_num'].' files</a></div>';
  $new_all_files = mysql_fetch_row(mysql_query('SELECT COUNT(*) FROM `files` WHERE `timeupload` > '.($time-(86400*$setup['day_new'])).' AND `size` > 0'));
if($new_all_files[0]!=0 AND $setup['new_change']==1) echo '<div class="menu3"><a href="new.php">New (+'.$new_all_files[0].')</a></div>';

if(!$id AND $setup['new_komm']==1) echo '<div class="menu3"><img src="imagini/nou.gif"width="14" height="14" alt="*"/> <a href="allkomm.php?">New. '.$setup['komm_num'].' Comments.</a></div>';
echo '</div></div>';
?>