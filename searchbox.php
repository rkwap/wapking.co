<?php
if(!$_GET['act'])
{
echo '<div class="search tCenter">
<form name="sfiles" action="search.php?act=search" method="post">Search : <form>
<input class="enter" name="word" type="text" maxlength="20" value="" size="15">
<input type="submit" value="Search"></form>
</div>
</div>


';
}
?>