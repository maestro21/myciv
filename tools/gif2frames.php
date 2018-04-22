<?php
include('GifFrameExtractor.php');
$fname = (isset($_GET['filename']) ? $_GET['filename'] : 'src');
$gifFilePath = $input_dir . "/{$fname}.gif";

if (GifFrameExtractor::isAnimatedGif($gifFilePath)) { // check this is an animated GIF

    $gfe = new GifFrameExtractor();
    $gfe->extract($gifFilePath, true);

    $frameImages = $gfe->getFrameImages();
	//print_r($frameImages); die();

	foreach($frameImages as $i => $image) { 
		imagepng($image, $output_dir . "/{$fname}{$i}.png");
		imagedestroy($image);
	}
}

echo "GIF into frames divided";