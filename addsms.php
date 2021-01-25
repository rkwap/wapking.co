<?php
echo '<h1>Submit SMS</h1>';
echo '<form action="addsms.php" method="post" name="addsms">';
echo 'Name: <input type="text" name="name" value=""><br>';
echo 'Category : <input type="text" name="category" value="Theme">';
echo " <br>It Should Start Or End Without '/' slash eg : Theme/Folder";
echo '<br><br>Your SMS : <br><textarea name="sms" rows="5" cols="40">'.$comment.'</textarea><br>';
echo '<input class="buttom" type="submit" value="Save"></form>';

$name = trim($_POST['name']);
$sms = trim($_POST['sms']);
$sms = ereg_replace("\n", "<br>",$sms);
$sms = '<p class="sms">'.$sms.'</p>';


$category = trim($_POST['category']);

$content = ''.$sms.'';
$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/files/$category/$name.txt","wb");
if(fwrite($fp,$content))
{echo'File added successfully';}
else{echo'File couldnt add!!';}



fclose($fp);



?>