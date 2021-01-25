<? php

// your site address
$site = 'http://wapking.co';

// script address
$url = 'click.php? gid =' . $_GET['gid'] . '& action = 2';

$links = preg_split('~ \ s *, \ s * ~', $setup['links']);

// password that is issued after activation of all links
$pas = $setup['click_pas'];
// link to file or page
$id = ($gid + 30) / 2;
$file = 'index.php? id =' . $id . '';

// Name of the link to the file or page
$filename = 'Login password:' . $pas . '';

// allow input from computers and opera mini? (1-yes, 0-no).
$stopcomp = $setup['stopcomp'];

// Text on entry
$textvhod = '
To access the archive you need: <br/>
1.Activate 3 links, following them one by one, returning back. <br/>
2. Everything! After you follow all 3 links and come back, you will see the password to access the archive. <br/>
3.If you already have a password, enter it below. <br/>
After you follow all 3 links and return to the bookmark back, you will immediately receive a password to access the archive. <br/> If you already have a password, enter it below. <br/>
<a href="click.php?gid=' . $_GET['gid'] . '&action=2"> START </a> <br/> <br/> ';

// Text that is shown when the user visits the page with links
$textlinks = 'Bookmark this page first. <br/>
Then activate the 3 links below (follow them and follow the bookmark back). <br/>
If after following the link it is not activated, just try refreshing this page. <br/>
After clicking on all 3 links on this page, a password will appear that you must remember for further viewing the archive and a direct link to the vip archive. <br/> <br/>
* Password validity period is 1 day <br/>
* When activating links, we recommend you wait until the pages are fully loaded. <br/> ';

// Text that is shown when the user has successfully activated all links
$textaktiv = 'You have successfully activated all 3 links. <br/>';
// Text above the counter (for example, "File downloaded:" or "Archive included").
$countname = 'Accessed:';

?>
