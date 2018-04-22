<?php
/***

Generates map from screenshot

***/

$MAPNAME = 'world300x150';

$terrain = array(
	'snow' => array( 255,255,255),
	'taiga' => array( 68,135,67),
	'Swamp' => array( 0,0,0),
	'grassland' => array( 15,78,0),
	'plains' => array( 248,178,52),
	'desert' => array( 228,254,0),
	'Floodplains' => array( 188,53,251),
	'jungle' => array( 0,255,0),
	'forrest' => array( 87,32,2),
	'hills' => array( 173,173,173),
	'mountains' => array( 52,52,52),
	'water'		=> array(0,110,185)
);




function rnd($array) { //print_r($array);
	return $array[rand(0, count($array)-1)];
}

function yes($n = 1) { //return true;
	return $n == rand(0,$n);
}

function generateTile($ter) {
	$tile = array();
	
	$tile['terrain'] = $ter;
	
	if(!in_array($ter, array('water','swamp'))) {
		/** roads **/
		if(yes()) $tile['road'] = 'road';
		
		/** mine **/
		$mineTiles = array('hills', 'mountains');
		if(in_array($ter, $mineTiles)) {	
			if(yes()) $tile['mine'] = true;
		}
		/** farm **/
		$farmTiles = array('grassland', 'plains', 'floodplains');
		if(in_array($ter, $farmTiles) && yes()) $tile['land'] = 'farm';
		
		/** forrest **/
		$forrestTiles = array('grassland' => 4,  'taiga' =>2);
		if(isset($forrestTiles[$ter]) && yes($forrestTiles[$ter])) {
			$tile['terrain'] = 'forrest';
		}
	}
	return $tile;
}



/** loading main map **/
$fpath = $MAPNAME . '/map.png';
if(file_exists($fpath)) {
	$mapstring = '';
	
	$size = getimagesize($fpath);
	switch($size['mime']) {
		case 'image/png': $img = imagecreatefrompng($fpath); break;
		case 'image/gif': $img = imagecreatefromgif($fpath); break;
		case 'image/jpeg': $img = imagecreatefromjpeg($fpath); break;
	}
	$x = $size[0];
	$y = $size[1]; $i=0;
	
	/* creating minimap image */
	$im_minimap = imagecreatetruecolor($x * 2, $y);
	
	
	for($j = 0; $j < $y; $j++) {
		$tiles[$j] = array();
		for($i = 0 ; $i < $x; $i++) {
			$rgb = imagecolorat($img, $i, $j); 
			$cols = imagecolorsforindex($img, $rgb);
			$r = $cols['red'];
			$g = $cols['green'];
			$b = $cols['blue'];
			$rgb = array($r,$g,$b);
			$_tile = null;
			foreach($terrain as $tname => $t) {
				if($t == $rgb) {
					$_tile = $tname;
					continue;
				}
			}
			if($_tile == null) {
				$_tile = 'water';
			}
			
			$tiles[$j][$i] = generateTile($_tile);
			$tiles[$j][$i]['x'] = $i;
			$tiles[$j][$i]['y'] = $j;	
			
			
			/** setting data **/
			$ter = $tiles[$j][$i]['terrain'];
			$mapstring .= $ter[0];
			//putting pixel to minimap
			$rgb = $terrain[$ter];
			$color = imagecolorallocate($im_minimap, $rgb[0], $rgb[1], $rgb[2]); 
			$offset = $j % 2;
			$_i = $i * 2 + $offset;
			imagesetpixel($im_minimap, $_i, $j, $color); 
			if($offset > 0 && $i == $x - 1) $_i = -1;
			imagesetpixel($im_minimap, $_i + 1, $j, $color); 
			
		}
		$mapstring .= "\r\n";
	}	
	
	/** outputing data **/
	file_put_contents($MAPNAME . '/map.txt', $mapstring);
	imagepng($im_minimap, $MAPNAME . '/minimap.png');
	
	echo "Map $fpath successfully generated";
} else {
	echo "Map $fpath dont exist";
}


/** loading river **/
$fpath = $MAPNAME . '/river.png';
if(file_exists($fpath)) {
	$mapstring = '';
	
	$size = getimagesize($fpath);
	switch($size['mime']) {
		case 'image/png': $img = imagecreatefrompng($fpath); break;
		case 'image/gif': $img = imagecreatefromgif($fpath); break;
		case 'image/jpeg': $img = imagecreatefromjpeg($fpath); break;
	}
	$x = $size[0];
	$y = $size[1]; $i=0;
	
	/* creating minimap image */
	$im_minimap = imagecreatetruecolor($x * 2, $y);
	
	
	for($j = 0; $j < $y; $j++) {
		$tiles[$j] = array();
		for($i = 0 ; $i < $x; $i++) {
			$rgb = imagecolorat($img, $i, $j); 
			$cols = imagecolorsforindex($img, $rgb);
			if($cols['alpha'] < 50) $mapstring .= 'r'; else $mapstring .= ' '; 
			
		}
		$mapstring .= "\r\n";
	}	
	
	/** outputing data **/
	file_put_contents($MAPNAME . '/river.txt', $mapstring);
	
	echo "Rivers for map $fpath successfully generated";
} else {
	echo "Rivers for map $fpath dont exist";
}

