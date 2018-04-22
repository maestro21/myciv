<?php
$directory = $input_dir;
$dir = array_diff(scandir($directory), array('..', '.')); natsort($dir);

foreach($dir as $filename) { 
	$fpath = $directory . '\\' . $filename;		
	if(is_dir($fpath)) continue;
	$size = getimagesize($fpath); //print_r($fpath); print_r($size);

	$x = $size[0];
	$y = $size[1];
	$im = imagecreatetruecolor($x, $y);
	imagealphablending($im, false);
	imagesavealpha($im, true);
	$alpha = imagecolorallocatealpha($im, 0, 0, 0, 127);
	imagefill($im, 0, 0, $alpha );		
	
	switch($size['mime']) {
		case 'image/png': $img = imagecreatefrompng($fpath); break;
		case 'image/gif': $img = imagecreatefromgif($fpath); break;
		case 'image/jpeg': $img = imagecreatefromjpeg($fpath); break;
	}
	if(isset($img)) {
		for($i = 0 ; $i < $x; $i++) {
			for($j = 0; $j < $y; $j++) {
				$rgb = imagecolorat($img, $i, $j);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF; 
				$total = $r + $g + $b;
				$alpha = round(($r + $g + $b) / (255 * 3) * 127);
				if($alpha == 0) echo "YES";
				$color = imagecolorallocatealpha($im, 0,0,0,$alpha); 
				imagesetpixel($im,$i,$j,$color); 					
			}		
		}
		imagepng($im, $output_dir . '/' . $filename);
		imagedestroy($im);
	}
}
echo "Conversion from white to alpha done";