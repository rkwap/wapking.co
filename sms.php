<?php
// supported: cp1251, koi, utf8
$encoding = 'utf8';
// bind sms key to URL
$url_restrict = false;
// key activation resource
$limit = 0;
// display the panel for changing languages
$lang_switcher = true;
// default language
$default_lang = 'en';
// project number
$project_id = 21594;

if ($lang_switcher) {
	$language = isset($_GET['lng']) ? $_GET['lng'] : (isset($_COOKIE['z_lng']) ? $_COOKIE['z_lng'] : $default_lang);
} else {
	$language = $default_lang;
}
$result_code = false;
$result_message = "closed";
if (isset($_POST['code']) && ereg('^[a-z0-9]{4}-[a-z0-9]{4}$', $_POST['code'])) {
	$check_url = 'http://check.smszamok.ru/check/?p='.$_POST['code'].'&id='.$project_id;
	if ($url_restrict) {
		$check_url .= "&url_restricted=".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
	if ($limit > 0) {
		$check_url .= "&limit=".$limit;
	}
	$handle = fopen($check_url, "r");
	if ($handle !== FALSE) {
		$result_message = fgets($handle, 255);
		$result_code = ($result_message == "true");
		fclose($handle);
	} else {
		$result_message = "server_busy";
	}
}
if (!$result_code) {
	readfile(($result_message == "server_busy") ?
	'http://iface.smszamok.ru/client/sorry.php?lng='.$language.'&enc='.$encoding :
	'http://iface.smszamok.ru/client/'.$language.'.iface.'.$encoding.'.php?pid='.$project_id.'&message='.$result_message.'&ls='.($lang_switcher?'1':'0'));
	// халявы нема
	die();
}
?>