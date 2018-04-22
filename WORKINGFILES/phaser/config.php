<?php 
session_start();



if(isset($_SESSION['screen_width']) AND isset($_SESSION['screen_height'])){
	$tileX = $tileY = $tile = 240;
	$tileWidth = 160;
	$tileWidthWithShadows = round($tileWidth * 1.5);
	$tileHeight = round($tileWidth * 0.5);
	$tileHeightWithShadows = round($tileHeight * 1.5);
	$offX = round($tileWidth * 0.25);
	$offY = $tileHeight * 1.4;//round($tileHeight * 0.25);
	
	$shoreStart = 1;
	$shoreEnd = 0;
	$shoreLen = 50;
	
	$imgdir = 'img/';

   $_SCREENPXX = $_SESSION['screen_width'];
   $_SCREENPXY = $_SESSION['screen_height'];
   $_SCREENX = floor($_SCREENPXX / $tileWidth);
   $_SCREENY = floor($_SCREENPXY / $tileHeight * 2);
   
   
} else if(isset($_REQUEST['width']) AND isset($_REQUEST['height'])) {
    $_SESSION['screen_width'] = $_REQUEST['width'];
    $_SESSION['screen_height'] = $_REQUEST['height'];
    header('Location: ' . $_SERVER['PHP_SELF']);
} else {
    echo '<script type="text/javascript">window.location = "' . $_SERVER['PHP_SELF'] . '?width="+screen.width+"&height="+screen.height;</script>';
}

/** graphic css config **/
$dir1 = array('left', 'right', 'top', 'bottom');
$dir2 = array('topleft', 'topright', 'bottomleft', 'bottomright');
$directions = array_merge($dir1,$dir2);	
$unitdirections = array('bl','l','br','r','tr','t','tl','l');	


$terrain = array(
	's' => 'snow',
	't' => 'taiga',
	'S' => 'swamp',
	'g' => 'grassland',
	'p' => 'plains',
	'd' => 'desert',
	'F' => 'floodplains',
	'j' => 'jungle',
	'f' => 'forrest',
	'h' => 'hills',
	'm' => 'mountains',
	'w' => 'water'
);

$terrain2 = array(
	'jungle' => 'floodplains',
	'forrest' => 'taiga',
	'mountains' => 'plains',
	'hills' => 'plains'
);


$config = array(
	'rand' => uniqid(),
	
	'mapwidth' => 150,//floor(175 * 0.5),//50,
	'mapheight' => 150,//138 * 2,//100,

	'tileX' => (int) $tileWidth,
	'tileY' => (int) round($tileHeight  * 0.5),
	'offset' => (int) $tileHeight,

	'imgTileX' => (int) $tileX,
	'imgTileY' => (int) $tileY,

	'screenX' => (int) $_SCREENPXX,
	'screenY' => (int) $_SCREENPXY,
	
	'halfScreenX' => (int) $_SCREENX * 0.5,
	'halfScreenY' => (int) $_SCREENY * 0.5,

	'screenTilesX' => (int) $_SCREENX,
	'screenTilesY' => (int) $_SCREENY,
	
	'imgdir'	=> 'img/',
	
	
	'terrain' => array(
		's' => 'snow',
		't' => 'taiga',
		'S' => 'swamp',
		'g' => 'grassland',
		'p' => 'plains',
		'd' => 'desert',
		'F' => 'floodplains',
		'j' => 'jungle',
		'f' => 'forrest',
		'h' => 'hills',
		'm' => 'mountains',
		'w' => 'water'
	),

	'terrain2' => array(
		'jungle' => 'floodplains',
		'forrest' => 'taiga',
		'mountains' => 'plains',
		'hills' => 'plains'
	),
	

	'players' => array( 
		'rome' => array(
			'city' 	=> 'roman',
			'color' => '#9a0000',
			'flag'  => 'rome',
		), 
		'tartary' => array(
			'city' 	=> 'pagan',
			'color' => '#ffce3f',
			'flag'  => 'tartary',
		),
		'cccp' => array(
			'city' => 'roman',
			'color' => '#cc0000',
			'flag' => 'cccp',
		)
	),

	'units' => array(
		'legio' => array(
			'size' => '120',
			'units' => array(
					array('left' => 20, 'top' => 50),
					array('left' => 50, 'top' => 30),
					array('left' => 50, 'top' => 70),
					array('left' => 80, 'top' => 50)
			),
			'unitflag' => array('left' => 130, 'top' => 60),
			'animation' => array(
				'stand' => array('16','2'),
			),
		),
		'trireme' => array(
			'size' => '160',
			'unitflag' => array('left' => 120, 'top' => 70),
			'units' => array(
				array('left' => 35, 'top' => 35),
			),
			'animation' => array(
				'stand' => array('10','2'),
			),
		),
	),
		
	'cities' => array(
		'roman' => array(
			3 => array(
				'flags' => array(
					array('top' => 12,  'left' => 80),
					array('top' => 0, 	'left' => 111),
					array('top' => 2, 	'left' => 144),
					array('top' => 12,  'left' => 169),
					array('top' => 22, 	'left' => 116),
				),
				'smoke' => array(
					array('top' => 28, 'left' => 55),
					array('top' => -9, 'left' => 125),
					array('top' => 18, 'left' => 150),
					array('top' => 42, 'left' => 103),
				),
			)
		),
		'pagan' => array(
			3 => array(
				'flags' => '',
				'smoke' => '',
			)
		), 
	),
	
	'images' => array(
	
		'prod'			=> 'misc/prod.png',
		'food'			=> 'misc/food.png',
		'trade'			=> 'misc/trade.png',
		'star'			=> 'misc/star.png',
		'smoke'			=> 'misc/smoke.png',

		'flag-rome'		=> 'flags/rome.png',
		'flag-tartary'	=> 'flags/tartary.png',
		'flag-cccp'		=> 'flags/cccp.png',


		'land-farm'		=> 'improvements/farm.png',
		'mine'		=> 'improvements/mine.png',
		
		'terrain-snow' 			=> 'terrain/snow.png',
		'terrain-taiga' 		=> 'terrain/taiga.png', 
		'terrain-swamp' 		=> 'terrain/swamp.png',			
		'terrain-grassland' 	=> 'terrain/grassland.png',			
		'terrain-plains' 		=> 'terrain/plains.png' ,			 				
		'terrain-floodplains' 	=> 'terrain/floodplains.png',
		'terrain-desert' 		=> 'terrain/desert.png',
		'terrain-forrest'		=> 'terrain/forrest.png',
		'terrain-mountains'		=> 'terrain/mountains.png' ,
		'terrain-hills'			=> 'terrain/hills.png' ,
		'terrain-jungle'		=> 'terrain/jungle.png' ,
		
		'city-roman'	=> 'cities/roman.png',
		'city-pagan'	=> 'cities/pagan.png',
		
		'imp-mine'			=> 'improvements/mine.png' ,
		'imp-farm'		    => 'improvements/farm.png' ,
		
		'flag-rome'		=> 'flags/rome.png',
		'flag-tartary'	=> 'flags/tartary.png',
		'flag-cccp'		=> 'flags/cccp.png',
		
	),

	'spritesheets' => array(
		
		'cursor'		=> array('misc/cursor.png', 140.5, 70),
	
		'water' 	  => array( 'misc/water.png', 100, 50),
		'coast'		 => array('terrain/coast.png', 240, 121),
		'river'		 => array('terrain/river.png', 240, 121),
		
		/* improvements here; irrigation, farm, railroad yet to come */	
		'roads'		 => array('improvements/roads.png', 240, 121),
		
		/* flags here */
		'flag-rome-anim'  => array( 'flags/anim/rome_anim.png',15,12),
		
		/* units here */
		'unit-legio-stand' => array( 'units/legio/stand.png',120,120),
		'unit-trireme-stand' => array( 'units/trireme/stand.png',160,160),
		
		/* later terrain & cities would also move here */
	),
);
$data = "var conf = $.parseJSON('" . json_encode($config) . "');";
file_put_contents('scripts/game.config.js', $data);



/** screen **/

$screen = 	array(

	'offsetX' 	=> 0,
	'offsetY'	=> 0,
	'cursorX'	=> (int) $_SCREENX * 0.5,
	'cursorY'	=> (int) $_SCREENY * 0.5,


	'tileW' => (int) $tileWidth,
	'tileH' => (int) round($tileHeight  * 0.5),
	'tileCenterX' => (int) $tileHeight,
	'tileCenterY' => (int) round($tileHeight  * 0.5),	
	'offsetXpx' => (int) $tileHeight,

	'imgTileW' => (int) $tileX,
	'imgTileH' => (int) $tileY,

	'Xpx' => (int) $_SCREENPXX,
	'Ypx' => (int) $_SCREENPXY,

	'X' => (int) $_SCREENX,
	'Y' => (int) $_SCREENY,
);


function getOffsetXY($x, $y) {
	global $tileWidth, $tileHeight;
	if($y % 2 == 0) $off = $tileWidth * 0.5; else $off = 0;
	$oX = $x * $tileWidth + $off - $tileWidth * 0.5 - 40; 
	$oY = $y * $tileHeight * 0.5 - 20;
	$centerX = $oX + $tileHeight;
	$centerY = $oY + $tileHeight * 0.5;
	
	return array('x' => $oX, 'y' => $oY , 'centerX' => $centerX, 'centerY' => $centerY);	
}

$arr = array();
for($y = -1; $y <= $_SCREENY; $y++) {
	$arr[$y] = array();
	for($x = -1; $x <= $_SCREENX; $x++) {
		$arr[$y][$x] = getOffsetXY($x, $y);
	}
}
$screen['tiles'] = $arr;

function conf($var) {
	global $config;
	return @$config[$var];
}
