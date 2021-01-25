<?

// $im 
// $VALUES 
// $LEGEND 
function Diagramm($im,$VALUES,$LEGEND) {
    GLOBAL $COLORS,$SHADOWS;

    $black=ImageColorAllocate($im,0,0,0);

    $W=ImageSX($im);
    $H=ImageSY($im);

    $legend_count=count($LEGEND);


   $max_length=0;
foreach($LEGEND as $v) if ($max_length<strlen($v)) $max_length=strlen($v);

   $FONT=2;
    $font_w=ImageFontWidth($FONT);
    $font_h=ImageFontHeight($FONT);


    $l_width=($font_w*$max_length)+$font_h+10+5+10;
    $l_height=$font_h*$legend_count+10+10;


    $l_x1=$W-10-$l_width;
$l_y1=($H-$l_height)/2;

ImageRectangle($im, $l_x1, $l_y1, $l_x1+$l_width, $l_y1+$l_height, $black);

$text_x=$l_x1+10+5+$font_h;
$square_x=$l_x1+10;
$y=$l_y1+10;
$i=0;
 foreach($LEGEND as $v) {
        $dy=$y+($i*$font_h);
        ImageString($im, $FONT, $text_x, $dy, $v, $black);
        ImageFilledRectangle($im,
                             $square_x+1,$dy+1,$square_x+$font_h-1,$dy+$font_h-1,
                             $COLORS[$i]);
        ImageRectangle($im,
                       $square_x+1,$dy+1,$square_x+$font_h-1,$dy+$font_h-1,
                       $black);
        $i++;
        }


    $total=array_sum($VALUES);
    $anglesum=$angle=Array(0);
    $i=1;

    while ($i<count($VALUES)) {
        $part=$VALUES[$i-1]/$total;
        $angle[$i]=floor($part*360);
        $anglesum[$i]=array_sum($angle);
        $i++;
        }
    $anglesum[]=$anglesum[0];

    $diametr=$l_x1-10-10;

    $circle_x=($diametr/2)+10;
    $circle_y=$H/2-10;

    if ($diametr>($H*2)-10-10) $diametr=($H*2)-20-20-40;

    for ($j=20;$j>0;$j--)
        for ($i=0;$i<count($anglesum)-1;$i++)
            ImageFilledArc($im,$circle_x,$circle_y+$j,
                               $diametr,$diametr/2,
                               $anglesum[$i],$anglesum[$i+1],
                               $SHADOWS[$i],IMG_ARC_PIE);

    for ($i=0;$i<count($anglesum)-1;$i++)
        ImageFilledArc($im,$circle_x,$circle_y,
                           $diametr,$diametr/2,
                           $anglesum[$i],$anglesum[$i+1],
                           $COLORS[$i],IMG_ARC_PIE);
    }
$an=0;
$an1=1;
$an2=2;
$an3=3;
$an4=4;
$an5=5;
$an6=6;
$VALUES=Array($an,$an1,$an2,$an3,$an4,$an5,$an6);
$LEGEND=Array("Kartinki","Video","Myzik","Anime","Porno","Xren","AS");

header("Content-Type: image/png");
$im=ImageCreate(300,300); 

$bgcolor=ImageColorAllocate($im,255,255,255);

$COLORS[0] = imagecolorallocate($im, 255, 203, 3);
$COLORS[1] = imagecolorallocate($im, 220, 101, 29);
$COLORS[2] = imagecolorallocate($im, 189, 24, 51);
$COLORS[3] = imagecolorallocate($im, 214, 0, 127);
$COLORS[4] = imagecolorallocate($im, 98, 1, 96);
$COLORS[5] = imagecolorallocate($im, 0, 62, 136);
$COLORS[6] = imagecolorallocate($im, 0, 102, 179);
$COLORS[7] = imagecolorallocate($im, 0, 145, 195);

$SHADOWS[0] = imagecolorallocate($im, 205, 153, 0);
$SHADOWS[1] = imagecolorallocate($im, 170, 51, 0);
$SHADOWS[2] = imagecolorallocate($im, 139, 0, 1);
$SHADOWS[3] = imagecolorallocate($im, 164, 0, 77);
$SHADOWS[4] = imagecolorallocate($im, 48, 0, 46);
$SHADOWS[5] = imagecolorallocate($im, 0, 12, 86);
$SHADOWS[6] = imagecolorallocate($im, 0, 52, 129);
$SHADOWS[7] = imagecolorallocate($im, 0, 95, 145);


Diagramm($im,$VALUES,$LEGEND);

ImagePNG($im)
?>
