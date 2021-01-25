<?php	

include('vvv.php');
$file = $_GET["lf"];
$q = array("res/drawable-mdpi/icon.png","res/drawable/ic_launcher.png","res/drawable/ic.png","res/drawable/appicon.png","res/drawable/icon.png","res/drawable-hdpi/icon.png","res/drawable-hdpi/ic_launcher.png","res/drawable-hdpi/appicon.png","res/drawable-hdpi/ic.png","res/drawable-mdpi/ic_launcher.png","res/drawable-mdpi/ic.png","res/drawable-mdpi/appicon.png","res/drawable-ldpi/ic_launcher.png","res/drawable-ldpi/ic.png","res/drawable-ldpi/icon.png","res/drawable-ldpi/icon.png","res/drawable-ldpi/appicon.png","res/drawable-xhdpi/ic_launcher.png","res/drawable-xhdpi/ic.png","res/drawable-xhdpi/icon.png","res/drawable-xhdpi/ot_ic_launcher.png","res/drawable-xhdpi/appicon.png","res/drawable-xxhdpi/ic_launcher.png","res/drawable-xxhdpi/ic.png","res/drawable-xxhdpi/icon.png","res/drawable-xxhdpi/appicon.png","res/drawable-nodpi/fk_icon_96.png","res/drawable-hdpi/ic_app.png","res/drawable-hdpi/widget_icon.png","res/drawable-mdpi/icon_zdevicetest.png","res/drawable-mdpi/app_icon_my_own.png","res/drawable/app_icon.png","res/drawable-hdpi/icon_green.png","res/drawable-hdpi/jb_smsmms.png","res/drawable/ic_launcher_wallpaper.png","res/drawable-hdpi/theme_icon.png","res/drawable/theme_icon.png","res/drawable-nodpi/icon.png","res/drawable/board.jpg");

$name = $setup['tpath'].'/'.basename($file).'.gif';


$apk = new PclZip($file);
$a = $apk->extract(PCLZIP_OPT_BY_NAME,$q,PCLZIP_OPT_EXTRACT_IN_OUTPUT);
if(!empty($a)) {Header("Content-type: zipdata/png");}
else {  Header("Content-type: ext/jar.png"); }

?>