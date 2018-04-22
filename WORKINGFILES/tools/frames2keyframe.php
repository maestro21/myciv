<?php 
$imgx = (int)$_GET['imgx']; 
/*
$input_dir = 'in';
$output_dir = 'out';*/

$directory = $input_dir;
$dir = array_diff(scandir($directory), array('..', '.')); natsort($dir);
if($imgx == 0) {
	$rows = 1; $imgx = count($dir); 
} else {
	$rows = ceil(count($dir) / $imgx);
} 

$di = $dj = 0;
foreach($dir as $file) { 		
	$fpath = $directory . '\\' . $file;		
	if(is_dir($fpath)) continue;
	$size = getimagesize($fpath);
	if(!isset($im)) {
		$x = $size[0];
		$y = $size[1];
		$im = @imagecreatetruecolor($x * $imgx, $y * $rows);
		imagealphablending($im, false);
		imagesavealpha($im, true);
		$alpha = imagecolorallocatealpha($im, 0, 0, 0, 127);
		imagefill($im, 0, 0, $alpha );		
	}
	
	$ox = $x * $di; 
	$oy = $y * $dj;
	
	switch($size['mime']) {
		case 'image/png': $img = imagecreatefrompng($fpath); break;
		case 'image/gif': $img = imagecreatefromgif($fpath); break;
		case 'image/jpeg': $img = imagecreatefromjpeg($fpath); break;
	}
	
	imagecopy($im, $img, $ox, $oy, 0, 0, $x, $y);
	
	if(0 < $imgx) {
		$di++; if($di == $imgx) { $dj++; $di = 0; }
	}
}

imagepng($im, $output_dir . '/out.png');
imagedestroy($im);
echo "Frameset from frames created";
