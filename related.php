<?php
$file_info[id]
echo(rand() . "<br>");
echo(rand() . "<br>");
echo(rand($file_info[id],$file_info[id]));





$filenameddn = pathinfo($file_info['name']);
$filenameddn = $filenameddn['basename'];
$filenameddn = str_replace(' ','-',$filenameddn);
$kamlin = "Name";
$urlhhn = "http://wapking.co/Download/$file_info[id]";
$newUrln = $urlhhn . "/$filenameddn(Wapking.net78.net).html";



  echo '<a href="'.$newUrln.'"><strong>'.$file_info['name'].'.'.$ext.'</strong></a>
       <br>Size : '.$size2.'';
       if($ext =='txt')     {  echo '<a href="read.php?id='.$file_info['id'].'&id2='.$id.'"><font color="red">Read</font></a>';}  
  	echo'<br>Hits : </font>['.$file_info['loads'].']</td></tr>';
?>