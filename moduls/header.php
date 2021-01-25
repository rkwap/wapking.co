<?php
list($msec,$sec)=explode(chr(32),microtime());
$HeadTime=$sec+$msec;
$kop=616;
if(@$_SERVER['HTTP_ACCEPT_ENCODING']){
$compress = strtolower(@$_SERVER['HTTP_ACCEPT_ENCODING']);}
else{
$compress = strtolower(@$_SERVER['HTTP_TE']);}
if(substr_count($compress,'deflate')){
function compress_output_deflate($output)
{return gzdeflate($output,5);}
header('Content-Encoding: deflate');
ob_start('compress_output_deflate');
ob_implicit_flush(0);}
elseif(substr_count($compress,'gzip')){
function compress_output_gzip($output){
return gzencode($output,5);}
header('Content-Encoding: gzip');
ob_start('compress_output_gzip');
ob_implicit_flush(0);}
elseif(substr_count($compress,'x-gzip')){
function compress_output_x_gzip($output){
$x = "\x1f\x8b\x08\x00\x00\x00\x00\x00";
$size = strlen($output);
$crc = crc32($output);
$output = gzcompress($output,5);
$output = substr($output, 0, strlen($output) - 5);
$x.= $output;
$x.= pack('V',$crc);
$x.= pack('V',$size);
return $x;}
header('Content-Encoding: x-gzip');
ob_start('compress_output_x_gzip');
ob_implicit_flush(0);}
session_name('lid');
session_start();
header('Content-type: text/html; charset=utf-8');
header('Expires: Thu, 21 Jul 1977 07:30:00 GMT');
header('Last-Modified: '.gmdate('r').' GMT');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');