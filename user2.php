<?php

if($id){

if($setup['eval_change']==1) $eval = ',<a href="\Sort/'.$id.'/eval/'.$ssort.'.html">rating</a>'; else $eval='';

if ($sort == 'timeupload') 
$sortlink = '<a href="\Sort/'.$id.'/load/'.$ssort.'.html">Popular</a> | <a href="\Sort/'.$id.'/name/'.$ssort.'.html">A to Z</a>';


elseif ($sort == 'name') 
$sortlink = '<a href="\Sort/'.$id.'/new2old/'.$ssort.'.html">New 2 Old</a> | <a href="\Sort/'.$id.'/load/'.$ssort.'.html">Popular</a>';


elseif ($sort == 'load') 
$sortlink = '<a href="\Sort/'.$id.'/new2old/'.$ssort.'.html">New 2 Old</a> | <a href="\Sort/'.$id.'/name/'.$ssort.'.html">A to Z</a>';


elseif ($sort == 'eval' and $setup['eval_change']==1) $sortlink = '<a href="\Sort/'.$id.'/load/'.$ssort.'.html">Popular </a> | <a href="\Sort/'.$id.'/name/'.$ssort.'.html">A to Z</a>';


echo '
<div class="dtype">
      Sort By: '.$sortlink.'</div>
';
}
?>
