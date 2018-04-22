<?php  
/** 
 * applies blackwhite alpha mask on image 
 */ 
function imagealphamask( &$picture, $mask ) {
    // Get sizes and set up new picture
    $xSize = imagesx( $picture );
    $ySize = imagesy( $picture );
    $newPicture = imagecreatetruecolor( $xSize, $ySize );
    imagesavealpha( $newPicture, true );
    imagefill( $newPicture, 0, 0, imagecolorallocatealpha( $newPicture, 0, 0, 0, 127 ) );

    // Resize mask if necessary
    if( $xSize != imagesx( $mask ) || $ySize != imagesy( $mask ) ) { //echo "RESIZE";
        $tempPic = imagecreatetruecolor( $xSize, $ySize );
        imagecopyresampled( $tempPic, $mask, 0, 0, 0, 0, $xSize, $ySize, imagesx( $mask ), imagesy( $mask ) );
        imagedestroy( $mask );
        $mask = $tempPic;
    }

    // Perform pixel-based alpha map application
    for( $x = 0; $x < $xSize; $x++ ) {
        for( $y = 0; $y < $ySize; $y++ ) {
			$alphaSource = imagecolorsforindex( $picture, imagecolorat( $picture, $x, $y ) ); 
			$alphaSource = $alphaSource['alpha'];
			if($alphaSource > 0) $alpha = $alphaSource;
			$alpha = imagecolorsforindex( $mask, imagecolorat( $mask, $x, $y ) ); 
			$total = $alpha[ 'red' ] + $alpha[ 'red' ] + $alpha[ 'blue' ];
			$alpha = floor(127 * ( ( $alpha[ 'red' ] + $alpha[ 'red' ] + $alpha[ 'blue' ] ) / (255 * 3) ));
			if($alphaSource > $alpha) $alpha = $alphaSource;
			
            $color = imagecolorsforindex( $picture, imagecolorat( $picture, $x, $y ) );
            imagesetpixel( $newPicture, $x, $y, imagecolorallocatealpha( $newPicture, $color[ 'red' ], $color[ 'green' ], $color[ 'blue' ], $alpha ) );
        }
    }

    // Copy back to original picture
    imagedestroy( $picture );
    $picture = $newPicture;
}

/* settings */
$maskdir = 'masks/';
$maskimgs = array(
	//'mask1.png',
	'mask2.png',
	'mask3.png',
);

/* getting images from input directory */
$files = scandir($input_dir);
unset($files[0]); unset($files[1]);

/* going through all images */	
foreach($files as $filename) {

	/* creating image depending on its type */
	$size = getimagesize($input_dir . '/' . $filename);
	switch($size['mime']) {
		case 'image/png': $img = imagecreatefrompng($input_dir . '/' . $filename); break;
		case 'image/gif': $img = imagecreatefromgif($input_dir . '/' . $filename); break;
		case 'image/jpeg': $img = imagecreatefromjpeg($input_dir . '/' . $filename); break;
	}

	/* applying masks */
	foreach($maskimgs as $maskimg) {
		$mask = imagecreatefrompng( $maskdir . $maskimg);
		imagealphamask( $img, $mask );
		echo "Mask $maskimg applied on $filename<br>"; 	
	}			

	/* saving */
	//header('Content-Type: image/png');
	$outputfilename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) . '.png';
	imagepng($img, $output_dir . '/' . $outputfilename);
	imagedestroy($img);	
}
