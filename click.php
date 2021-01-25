<?php

require 'moduls/ini.php';
require 'moduls/fun.php';
require 'moduls/connect.php';

ob_start();
error_reporting(0);

// Checking variables
$gid = intval($_GET['gid']);
$gid = $_GET['gid'];
$kod = $_POST['kod'];
$gosite = $_POST['gosite'];
$sid = $_GET['sid'];
$action = $_GET['action'];

include ('config_click.php');

// set the session name
session_name("click");
// start session
session_start();
// write the session identifier to the sid variable
$sid = session_id();

if ($_SESSION['ok'] == 1)
{ // if all links are activated
    header('Location:' . $file);
    die();
}

if ($stopcomp == 0)
{
    if (strstr($_SERVER['HTTP_USER_AGENT'], 'Opera') or strstr($_SERVER['HTTP_USER_AGENT'], 'Mozilla'))
    {
        header("Location: stop.php? gid = $ gid");
        exit;
    }
}

else
{
    if ($action)
    {
        switch ($_GET['action'])
        {
                #################################### INFA
                
            case '1':

                include 'moduls / header.php';
                echo '<div class = "menu"> Access to this section is closed! </div>';
                echo '<div class = "a">';
                $time = date("H");

                if ($time > 5 && $time < 13) echo ("Good morning! <br />");
                elseif ($time > 12 && $time < 19) echo ("Hello! <br />");
                elseif ($time > 18 && $time < 23) echo ("Good evening! <br />");
                else echo ("Good night! <br />");

                echo "$ textvhod";
                echo '</div> <div class = "menu"> Enter the code you received: </div> <div class = "a">
<form action = "click.php? gid = ' . $gid . ' & action = 3" method = "post">
<input maxlength = "10" class = "enter" type = "text" name = "kod" /> <br>
<input class = "buttom" type = "submit" name = "a" value = "ok" />
</form>
</div> ';

                echo '
<div class = "a"> <div class = "i_bar_t"> <a href="index.php?"> Downloads </a> </div>
<div class = "i_bar_t"> <a href="' . $setup['site_url' > ] . '"> Home </a> </div>
';
                echo '</div>';
                echo '<div class = "title">';
                include 'moduls / foot.php';
                echo '</div> </div>';
                break;
                #####################################Activation
                
            case '2':
                include 'moduls / header.php';

                echo '<div class = "menu"> Access to this section is closed! </div>';
                echo '<div class = "a">';

                // disable cookies and forwarding sid
                ini_set('session.use_cookies', '0');
                ini_set('session.use_trans_sid', '0');

                // load the counter file
                $gocount = file("gocount.txt");
                // for today
                $today = @intval($gocount[0]);
                // Total
                $all = @intval($gocount[1]);
                // date of the last call
                $ldate = @intval($gocount[2]);
                // if the date of the last call does not match the current date
                if ($ldate! = date('d'))
                {
                    // then reset the counter for today and overwrite the file
                    $today = 0;
                    $ldate = date('d');
                    $fp = fopen('gocount.txt', 'w');
                    fwrite($fp, "$ today \ n");
                    fwrite($fp, "$ all \ n");
                    fwrite($fp, "$ ldate \ n");
                    fclose($fp);
                }


				// disable caching
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Pragma: no-cache");
				
				$active = false;
				foreach ($links as $n => $link)
				{
					if (@$_SESSION['link' . $n]! = true)
					{
						$active = true;
					}
				}
				
				// if sid is not passed, then issue a redirect to ourselves (for old browsers)
				if (!isset($_GET['sid']))
				{
					header("Location: click.php? sid = $ sid & gid = $ gid & action = 2");
					exit;
				}
				
				// if the gosite parameter is passed (enter the site)
				if (@$_GET['gosite'] == 'true')
				{
					// increase the counters
					$today++;
					$all++;
					$id = ($gid + 30) / 2;
					// redirect to the site
					header("Location: $ file");
					// overwrite the counter file
					$fp = fopen('gocount.txt', 'w');
					fwrite($fp, "$ today \ n");
					fwrite($fp, "$ all \ n");
					fwrite($fp, "$ ldate \ n");
					fclose($fp);
					exit;
				}
				
				// if the go GET parameter with a link number is passed
				if (isset($_GET['go']))
				{
					// the number of the link that the user is going to follow
					$l = $_GET['go'];
					// write a parameter to the session with the link number and the value true
					$_SESSION['link' . $l] = true;
					// issue a redirect to the link from the links array
					header("Location: $ links [$ l]");
				}
				else
				{
				
					if (@!$active)
					{
						echo "$ textaktiv";
						$ok = 1;
						session_register("ok");
					}
					else
					{
						echo "$ textlinks";
					}
				
					// if there are no active links
					if (@!$active)
					{
						// link to this file with the gosite parameter (to count the number of transitions)
						echo "<a href=\"click.php?action=2&gid=$gid&gosite=true&amp;sid=$sid\"> $ filename </a> <br/>";
					}
				
					// go through the links array
					foreach ($links as $n => $link)
					{
						// n - number of the current element, link - value (url of the link)
						// if the session has a parameter with a link number and value true
						// @ is necessary so that no notice error occurs
						if (@$_SESSION['link' . $n] == true)
						{
							echo "Link $ n [active] <br/>";
						}
						else
						{
							// otherwise, display a link to this file with the go parameter with the link number and session identifier
							// url cannot be displayed immediately, because then it is impossible to find out if the user has followed the link
							echo "<a href=\"click.php?action=2&gid=$gid&go=$n&amp;sid=$sid\"> Link $ n </a> [not active] <br/>";
							// this means that there are still active links and you cannot enter the site
							$active = true;
						}
					}
				
					echo "<br/>";
					// counter
					echo "$ countname <br/>
				Today: $ today person (s) <br/>
				Total: $ all person (s) <br/> <br/> ";
					echo '</div>';
					echo '
				<div class = "a"> <div class = "i_bar_t"> <a href="index.php?"> Downloads </a> </div>
				<div class = "i_bar_t"> <a href="' . $setup['site_url' > ] . '"> Home </a> </div>
				';
				
					echo '</div> <div class = "title">';
					include 'moduls / foot.php';
					echo '</div> </div>';
				
				}
				
				// to cancel passing sid-s, DO NOT CHANGE !!!
				$text = ob_get_contents();
				ob_end_clean();
				echo $text;
				break;
				#################################### Check password
				
				case '3':
					if ($kod == $pas)
					{
						$id = ($gid + 30) / 2;
						header('Location: index.php? id =' . $id . '');
						die();
					}
					else
					{
						include 'moduls / header.php';
						echo '<div class = "menu"> <font color = "red"> Wrong password! Please try again. </font> </div>';
						echo '<div class = "menu"> Access to this section is closed! </div>';
						echo '<div class = "a">';
						$time = date("H");
				
						if ($time > 5 && $time < 13) echo ("Good morning! <br />");
						elseif ($time > 12 && $time < 19) echo ("Hello! <br />");
						elseif ($time > 18 && $time < 23) echo ("Good evening! <br />");
						else echo ("Good night! <br />");
				
						echo "$ textvhod";
						echo '</div> <div class = "menu"> Enter the code you received: </div> <div class = "a">
				<form action = "click.php? gid = ' . $gid . ' & action = 3" method = "post">
				<input maxlength = "10" class = "enter" type = "text" name = "kod" /> <br>
				<input class = "buttom" type = "submit" name = "a" value = "ok" />
				</form>
				</div> ';
				
						echo '
				<div class = "a"> <div class = "i_bar_t"> <a href="index.php?"> Downloads </a> </div>
				<div class = "i_bar_t"> <a href="' . $setup['site_url' > ] . '"> Home </a> </div>
				';
						echo '</div>';
						echo '<div class = "title">';
						include 'moduls / foot.php';
						echo '</div> </div>';
					}
					break;
				}
				}
				else exit;
				}
				
								
?>
