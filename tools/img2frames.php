<?php
/* getting images from input directory */
$tsize = $_GET['size'];
$files = scandir($input_dir);
unset($files[0]); unset($files[1]);

/* going through all images */	
foreach($files as $filename) {
	$isize = getimagesize($input_dir . '/' . $filename); 
	switch($isize['mime']) {
		case 'image/png': $src = imagecreatefrompng($input_dir . '/' . $filename); break;
		case 'image/gif': $src = imagecreatefromgif($input_dir . '/' . $filename); break;
		case 'image/jpeg': $src = imagecreatefromjpeg($input_dir . '/' . $filename); break;
	}
	$xtiles = ceil($isize[0] / $tsize);
	$ytiles = floor($isize[1] / $tsize);

	$i = 0;
	for($y = 0 ; $y < $ytiles; $y++) {
		for($x = 0; $x < $xtiles; $x++) {
			$dest = imagecreatetruecolor($tsize, $tsize);	
			imagesavealpha($dest, true);
			$transparent = imagecolorallocatealpha($dest, 0, 0, 0, 127);
			imagefill($dest, 0, 0, $transparent);
			imagecopy($dest, $src, 0, 0, $x * $tsize, $y * $tsize, $tsize, $tsize);
			imagepng($dest, $output_dir . "/{$filename}_{$x}_{$y}.png");
			imagedestroy($dest);
		}
	}
	imagedestroy($src);
}
echo "Image divided into frames";