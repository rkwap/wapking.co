<?php
	// VALUES FROM THE FORM
	$name		= $_POST['name'];
	$email		= $_POST['email'];
	$message	= $_POST['msg'];

	// ERROR & SECURITY CHECKS
	if ( ( !$email ) ||
		 ( strlen($_POST['email']) > 200 ) ||
	     ( !preg_match("#^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$#", $email) )
       ) 
	{ 
		print "Error: Invalid E-Mail Address"; 
		exit; 
	} 
	if ( ( !$name ) ||
		 ( strlen($name) > 100 ) ||
		 ( preg_match("/[:=@\<\>]/", $name) ) 
	   )
	{ 
		print "Error: Invalid Name"; 
		exit; 
	} 
	if ( preg_match("#cc:#i", $message, $matches) )
	{ 
		print "Error: Found Invalid Header Field"; 
		exit; 
	} 
	if ( !$message )
	{
		print "Error: No Message"; 
		exit; 
	} 
	if (eregi("\r",$email) || eregi("\n",$email)){ 
		print "Error: Invalid E-Mail Address"; 
		exit; 
	} 
	if (FALSE) { 
		print "Error: You cannot send to an email address on the same domain."; 
		exit; 
	} 


	// CREATE THE EMAIL
	$headers	= "Content-Type: text/plain; charset=iso-8859-1\n";
	$headers	.= "From: $name <$email>\n";
	$recipient	= "noreply@wapking.co";
	$subject	= "Contact From Your Website";
	$message	= wordwrap($message, 1024);

	// SEND THE EMAIL TO YOU
	mail($recipient, $subject, $message, $headers);

	// REDIRECT TO THE THANKS PAGE
	 include 'moduls/header.php';
echo '<div class="menu2">Contact Us ! </div>
<b><font color="red">Thanks !</font> We Received Your Mail, We Wil Get Back to You Shortly.</b><div class="menu1"><div class="menu3"><a href="index.php?">Downloads</a></div></div>
<div class="menu1"><a href="http://www.wapking.co">Home</a></div>';
?>
