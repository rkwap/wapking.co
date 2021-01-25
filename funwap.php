<?php


ini_set('memory_limit', '50M');

// --------------------------------------------------------------------------
// define paths
// --------------------------------------------------------------------------

define('PATH_TO_THUMBS', isset($_GET['path_to_thumbs']) ? $_GET['path_to_thumbs'] : './Walls/');

// --------------------------------------------------------------------------
// activate error handling
// --------------------------------------------------------------------------

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// --------------------------------------------------------------------------
// instantiate the Thumber class
// --------------------------------------------------------------------------

$thumber = new Thumber();

class Thumber {

var $pathToImage, $pathToThumb;
var $imageType;

var $imageWidth, $imageHeight;
var $thumbArea;
var $thumbWidth, $thumbHeight;

function __construct() {	
	$this->logic();
}

private function logic() {
	
	// --------------------------------------------------------------------------
	// what this program is supposed to do
	// --------------------------------------------------------------------------
		
	$this->pathToImage = isset($_GET['img']) ? $_GET['img'] : '';
		
	$this->thumbArea   = @$_GET['a'];
	$this->thumbWidth  = @$_GET['h'];
	$this->thumbHeight = @$_GET['w'];
	
	$this->gatherInfo();
	$this->calculateThumbDimensions();
	$this->serveThumb();
}

function gatherInfo() {
	
	// --------------------------------------------------------------------------
	// determine the file type and the dimensions  of the original image
	// --------------------------------------------------------------------------
	
	// right now, only 'gif', 'jpg' and 'png' work as input files,
	// but future versions of the GD library might understand more formats
	
	$types = array (
	        1 =>  'gif',
	        2 =>  'jpg',
	        3 =>  'png',
	        4 =>  'swf',
	        5 =>  'psd',
	        6 =>  'bmp',
	        7 =>  'tiff(intel byte order)',
	        8 =>  'tiff(motorola byte order)',
	        9 =>  'jpc',
	        10 => 'jp2',
	        11 => 'jpx',
	        12 => 'jb2',
	        13 => 'swc',
	        14 => 'iff',
	        15 => 'wbmp',
	        16 => 'xbm'
	);
	
	$info = getimagesize($this->pathToImage);
	$this->imageWidth  = $info[0];
	$this->imageHeight = $info[1];
	$this->imageType   = $types[$info[2]];
	
}

function calculateThumbDimensions() {
	
	//$this->fitIntoBox = false;
	
	// --------------------------------------------------------------------------
	// if the 'a' (for area) parameter has been set, calculate the thumb 
	// dimensions so that its area will exactly correspond to the area 
	// (given in square pixels)
	// --------------------------------------------------------------------------
	
	if (isset($this->thumbArea)) {

		$imageArea = $this->imageWidth * $this->imageHeight;
		$sizeRatio = $this->thumbArea / $imageArea;
		
		$this->thumbWidth  = ceil($this->thumbArea / $this->imageHeight);
		$this->thumbHeight = ceil($this->thumbArea / $this->imageWidth);
						
	} else {
	
		// --------------------------------------------------------------------------
		// if the width has not been given, calculate it from the height
		// if the height has not been given, calculate it from the width
		// --------------------------------------------------------------------------

		if (!isset($this->thumbWidth)) {
			$sizeRatio = $this->imageHeight / $this->thumbHeight;
			$this->thumbWidth = ceil($this->imageWidth / $sizeRatio);
		} else if (!isset($this->thumbHeight)) {
			$sizeRatio = $this->imageWidth / $this->thumbWidth;
			$this->thumbHeight = ceil($this->imageHeight / $sizeRatio);
		}
	}
	
	// --------------------------------------------------------------------------
	// now that we know the definitive dimensions of our thumbnail,
	// why not use those to label the file properly?
	// --------------------------------------------------------------------------
		
	$pathParts = pathinfo($this->pathToImage);
	$pathParts['filename'] = str_replace('%28','(',$pathParts['filename']);
        $$pathParts['filename'] = str_replace('%29',')',$pathParts['filename']);
	$this->pathToThumb = PATH_TO_THUMBS 
					   . $pathParts['filename'] 
					   . '-'  . $this->thumbWidth 
					   . 'x'  . $this->thumbHeight 
					   . '.'  . $pathParts['extension'];
}

function serveThumb() {
	
	// --------------------------------------------------------------------------
	// if the thumbnail image already exists, serve it; 
	// otherwise generate one
	// --------------------------------------------------------------------------
	
	#$this->generateThumb(); return; // for testing
	
	if (file_exists($this->pathToThumb)) {
		
	
	
		
		$pathToThumb = ltrim($this->pathToThumb);
		
		// open the file in binary mode
		$fp = fopen($pathToThumb, 'rb');
		
		// send the right headers
		header('Content-Type: image/' . ($this->imageType == 'jpg' ? 'jpeg' : $this->imageType));
		header('Content-Disposition: inline; filename='. urlencode(basename($pathToThumb)) . '');
		header('Content-Length: ' . filesize($pathToThumb));
		header('Content-type: application/octet-stream;');
		
		// stream it through
		fpassthru($fp);
		
		exit;		
	} else {
		if (file_exists($this->pathToImage)) {
			$this->generateThumb();
		}
	}
}

function generateThumb() {
	
	// --------------------------------------------------------------------------
	// create an image from the input image
	// --------------------------------------------------------------------------

	switch($this->imageType) {
		case 'jpg':
			$image = @imagecreatefromjpeg($this->pathToImage);
		break;
		case 'gif':
			$image = @imagecreatefromgif($this->pathToImage);
		break;
		case 'png':
			$image = @imagecreatefrompng($this->pathToImage);
		break;
	}
	
	if ($image === false) {
		trigger_error('image could not be created', 1024);
		print 'nöööööö'; exit;
	}
		
	// --------------------------------------------------------------------------
	// create the thumbnail image and paste in the original in its new
	// dimensions
	// --------------------------------------------------------------------------
	
	$thumbImage = imagecreatetruecolor($this->thumbWidth, $this->thumbHeight);
	imagecopyresampled($thumbImage, $image, -1, -1, 0, 0, $this->thumbWidth + 2, $this->thumbHeight + 2, $this->imageWidth, $this->imageHeight);

	// --------------------------------------------------------------------------
	// sharpen it a little
	// --------------------------------------------------------------------------
	
	if (function_exists('imageconvolution')) {
		 $sharpen = array(array( -1, -1, -1 ),
		                  array( -1, 16, -1 ),
		                  array( -1, -1, -1 ));
		imageconvolution($thumbImage, $sharpen, 8, 0);
	}
	
	// --------------------------------------------------------------------------
	// spit it out
	// --------------------------------------------------------------------------
		
	switch($this->imageType) {
		case 'jpg':
			imagejpeg($thumbImage, $this->pathToThumb, 80);
			header("Content-type: image/jpeg"); 
			imagejpeg($thumbImage, NULL, 80);	
		break;
		case 'gif':
			imagegif($thumbImage, $this->pathToThumb);
			header("Content-type: image/gif"); 
			imagegif($thumbImage, NULL);
		break;
		case 'png':
			imagepng($thumbImage, $this->pathToThumb);
			header("Content-type: image/png");
			imagepng($thumbImage, NULL);
		break;
	}
	
	imagedestroy($image);
	imagedestroy($thumbImage);
}



} // class Thumber


?>