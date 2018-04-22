<?php  
	$mask = 'masks/mask2.png';	
	$files = scandir($input_dir);
	unset($files[0]); unset($files[1]);
	$alpha = imagecreatefrompng($mask);
	
			
		
	function copyPixels($src_img, $dst_img, $src_x, $src_y, $dst_x, $dst_y, $alpha){
		$rgb = imagecolorat($src_img, $src_x, $src_y);
		$colors = imagecolorsforindex($dst_img, $rgb);	
		$color = imagecolorallocate($dst_img, $colors['red'], $colors['green'], $colors['blue']); 
		imagesetpixel($dst_img, $dst_x, $dst_y, $color); 	
	}	
	
	function copySwapPixels($src_img, $dst_img, $src_x, $src_y, $dst_x, $dst_y, $alpha){
		copyPixels($src_img, $dst_img, $src_x, $src_y, $dst_x, $dst_y, $alpha);	
		if($src_x == $src_y && $dst_x == $dst_y) return;
		copyPixels($src_img, $dst_img, $src_y, $src_x, $dst_y, $dst_x, $alpha);	
	}
	
	
	foreach($files as $filename) {
		$size = getimagesize($input_dir . '/' . $filename);
		if($size[0] != $size[1] || $size[0] % 4 > 0) die('image size should be the same and %4');					
		switch($size['mime']) {
			case 'image/png': $img = imagecreatefrompng($input_dir . '/' . $filename); break;
			case 'image/gif': $img = imagecreatefromgif($input_dir . '/' . $filename); break;
			case 'image/jpeg': $img = imagecreatefromjpeg($input_dir . '/' . $filename); break;
		}
		
		$sizesrc = $size[0]; //x and y size of source image in pixels;
		$side = round($sizesrc / 4); // x and y size of a side in pixels;
		$sizedst = round($sizesrc * 1.5); // x and y size of a new image in pixels;
		$pxa = 128 / $side ;	//alpha per pixel;
		$im = @imagecreatetruecolor($sizedst, $sizedst);

		
		/* alpha */
		imagealphablending($im, false);
		imagesavealpha($im, true); 
		/*bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )*/
		imagecopyresampled($im, $img, $side, $side, 0, 0, $sizesrc, $sizesrc, $sizesrc, $sizesrc);
		
		for($i = 0; $i < $side; $i++) {
			//$alpha = $pxa * $i;
			/* sides */
			for($j = 0; $j < $sizesrc; $j++) {	
				/* top & left */
				copySwapPixels($img, $im, $j, $i, $side - $i, $side + $j, $alpha);		
				/* bottom & right*/
				copySwapPixels($img, $im,  $j, $sizesrc - $i - 1, $side + $j, $side + $sizesrc + $i, $alpha);
			}
			/* corners */
			for($z = 0; $z <= $i; $z++) {
				//$alpha = round($pxa * ($i + sqrt($z)));
				if($alpha > 127) $alpha = 127;
				/* topleft */
				copySwapPixels($img, $im, $i, $z, $side - $z, $side - $i, $alpha);
				/* topright-bottomleft */
				copySwapPixels($img, $im, $sizesrc - $i - 1, $z, $side + $sizesrc + $z, $side - $i, $alpha);
				copySwapPixels($img, $im, $sizesrc - $z - 1, $i, $side + $sizesrc + $i, $side - $z, $alpha);
				/* bottomright */
				copySwapPixels($img, $im, $sizesrc - $i - 1, $sizesrc - $z - 1, $sizesrc + $side + $z, $sizesrc + $side +$i, $alpha);
			} /**/
		}
		
		
		/* transparency */	
		for($x = 0; $x < $sizedst; $x++){
			for($y = 0; $y < $sizedst; $y++){	
				$rgba = imagecolorat($alpha, $x, $y);
				$colorsa = imagecolorsforindex($alpha, $rgba);
				$a = $colorsa['alpha'] * 1.5;
				if($a > 127) $a = 127;
			
				$rgb = imagecolorat($im, $x, $y);
				$colors = imagecolorsforindex($im, $rgb);
			
				$color = imagecolorallocatealpha($im, $colors['red'], $colors['green'], $colors['blue'], $a); 
				imagesetpixel($im, $x, $y, $color); 
			}
		}
		
		/* rotate */
		$transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
		$im = imagerotate($im, 45, $transparent);
		
		/* resize */
		$x = ImageSX($im);
		$y = ImageSY($im);
		$y2 = round($y / 2);
		$imo = imagecreatetruecolor($x, $y2);
		imagealphablending($imo, false);
		imagesavealpha($imo, true); 
		imagecopyresampled($imo, $im, 0, 0, 0, 0, $x, $y2, $x, $y);
		
		/* save */
		//header('Content-Type: image/png');
		$outputfilename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) . '.png';
		imagepng($imo, $output_dir . '/' . $outputfilename);
		imagedestroy($im);
		imagedestroy($imo);
	}
