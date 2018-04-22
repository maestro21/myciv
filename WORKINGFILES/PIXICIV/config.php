<?php 
session_start();/*
unset($_SESSION['screen_width']);
unset($_SESSION['screen_height']);*/
/* ==================================================
	Define screen dimensions if they are undefined 
===================================================== */
if(!isset($_SESSION['screen_width']) OR !isset($_SESSION['screen_height'])){	
	/** if screen dimensions are sent - save them and redirect **/	
	if(isset($_REQUEST['width']) AND isset($_REQUEST['height'])) {
		$_SESSION['screen_width'] = $_REQUEST['width'] - 200;
		$_SESSION['screen_height'] = $_REQUEST['height'];
		header('Location: ' . $_SERVER['PHP_SELF']);
	}	
	/** define and screen dimensions **/
	echo '<script type="text/javascript">window.location = "' . $_SERVER['PHP_SELF'] . '?width="+screen.width+"&height="+screen.height;</script>';	
}
//print_r($_SESSION);

/* ==================================================
	Global settings
===================================================== */
/* Screen offset from top of page */
$_PAGEOFFSETPXX = 0;
$_PAGEOFFSETPXY = 0;

/* Offset from top of screen */
$_SCREENOFFSETPXX = 0;
$_SCREENOFFSETPXY = 0;
/* Tile size in pixels */
$_TILESIZEPX = 100;
/* Image directory */
$_IMGDIR = 'img/';


/* ==================================================
	Config file
===================================================== */
$CONFIG = [ 
	'screen' 	=> [], 
	'tile' 		=> []
];
/* Screen layers */
$config['screen']['layers'] = array_flip([
	'terrainLayer', 'coastLayer', 'landLayer', 'topLayer'
]);

$config['rand'] = bin2hex(openssl_random_pseudo_bytes(4));

/* Screen offset in pixels */
$config['screen']['offsetPxX'] = $_SCREENOFFSETPXX;
$config['screen']['offsetPxY'] = $_SCREENOFFSETPXY;

/* Screen size in pixels */
$config['screen']['sizePxX'] = $_SESSION['screen_width'] - $_PAGEOFFSETPXX;
$config['screen']['sizePxY'] = $_SESSION['screen_height'] - $_PAGEOFFSETPXY;

/* Tile size in pixels */
$config['tile']['sizePxX'] = $_TILESIZEPX;
$config['tile']['sizePxY'] = $config['tile']['sizePxX'];

/* Number of tiles on screen */
$config['screen']['tilesX'] = ceil( $config['screen']['sizePxX'] / $config['tile']['sizePxX'] );
$config['screen']['tilesY'] = ceil( $config['screen']['sizePxY'] / $config['tile']['sizePxY'] );

/* Coordinates of central screen tile */
$config['screen']['centerTileX'] = ceil( $config['screen']['tilesX'] / 2 ) - 1;
$config['screen']['centerTileY'] = ceil( $config['screen']['tilesY'] / 2 ) - 1;

/* Tile Shadow offset compared to tileSize. I.e. 0.25 means that tile will have 25% offset that would overlap with another tile */
$config['tile']['shadowOffsetX'] = 0.25;
$config['tile']['shadowOffsetY'] = $config['tile']['shadowOffsetX'];

/* Tile image size in pixels */
$config['tile']['imageSizePxX'] = $config['tile']['sizePxX'] * ( 1 + $config['tile']['shadowOffsetX'] * 2 );
$config['tile']['imageSizePxY'] = $config['tile']['sizePxY'] * ( 1 + $config['tile']['shadowOffsetY'] * 2 );

/* Image directory */
$config['imgdir'] = $_IMGDIR;

/* Directions: direct, corners, both, unit directions */
$dir1 = [ 'left', 'right', 'top', 'bottom' ];
$dir2 = [ 'topleft', 'topright', 'bottomleft', 'bottomright'];
$config['directions'] = [
	'direct' 	=> $dir1,
	'corners' 	=> $dir2, 
	'all' 		=> array_merge($dir1, $dir2),	
	'unit'		=>['bl','l','br','r','tr','t','tl','l'],
];

/* Symbol to terrain - for map reading from .txt */
$config['terrain'] = [
	'a' => [ 'snow',[255,255,255] ],
	't' => ['taiga', [68,135,67] ],
	's' => ['swamp',  [0,0,0]],
	'g' => ['grassland', [15,78,0] ],
	'p' => ['plains', [248,178,52] ],
	'd' => ['desert', [228,254,0] ],
	'l' => ['floodplains', [188,53,251] ],
	'j' => ['jungle', [0,255,0] ],
	'f' => ['forrest', [ 87,32,2] ],
	'h' => ['hills', [173,173,173] ],
	'm' => ['mountains', [52,52,52] ],
	'w' => ['water', [0,110,185] ],
];

/* Subterrain which would be converted */
$config['terrain2'] = [
	'jungle' => 'desert',
	'forest' => 'taiga',
	'mountains' => 'plains',
	'hills' => 'plains'
];

/**
	Civilization graphics configuration
	Later to be loaded from Ruleset
**/
$config['civilizations'] = [ 
	'rome' => [
		'city' 	=> 'roman',
		'color' => '#9a0000',
		'flag'  => 'rome',
	], 
	'tartary' => [
		'city' 	=> 'pagan',
		'color' => '#ffce3f',
		'flag'  => 'tartary',
	],
	'cccp' => [
		'city' => 'roman',
		'color' => '#cc0000',
		'flag' => 'cccp',
	],
];

/**
	Unit graphics configuration
	Later to be loaded from Ruleset
**/
$config['units'] = [
	'legio' => [
		'size' => '120',
		'units' => [
				[ 'left' => 20, 'top' => 50 ],
				[ 'left' => 50, 'top' => 30 ],
				[ 'left' => 50, 'top' => 70 ],
				[ 'left' => 80, 'top' => 50 ]
		],
		'unitflag' => [ 'left' => 130, 'top' => 60 ],
		'animation' => [
			'stand' => [ '16','2' ],
		],
	],
	'trireme' => [
		'size' => '160',
		'unitflag' => [ 'left' => 120, 'top' => 70 ],
		'units' => [
			[ 'left' => 35, 'top' => 35 ],
		],
		'animation' => [
			'stand' => [ '10','2' ],
		],
	],
];

/* List of graphics to load */
scanImageDirs($config['imgdir']);

/* ==================================================
	Save config in file
===================================================== */
//echo "<pre>";print_r($config);
$data = "var conf = $.parseJSON('" . json_encode($config) . "');";
file_put_contents('data/game.config.js', $data);


/* ==================================================
	Functions
===================================================== */
/* 
	Config getter and setter
	@param $var string - config variable name
	@param $val mixed  - config variable value
	@param $arr string - array where to add variable
*/

function conf($var, $val = null, $arr = null) {
	global $config;
	if(NULL != $val) {
		if(NULL != $arr) {
			$config[$arr][$var] = $val;
		} else {
			$config[$var] = $val;
		}
	}
	return @$config[$var];
}

/* 
	Scans directiories for images 
	@param $dir string - directory path
*/
function scanImageDirs($dir) {
    $tree = glob(rtrim($dir, '/') . '/*');
    if (is_array($tree)) {
        foreach($tree as $file) {
            if (is_dir($file)) {
                scanImageDirs($file);
            } elseif (is_file($file)) {
				$imgext = ".png";
				/* check if image is tileset */
				if(strpos($file, $imgext)) {					
					/* create image name */
					$imgname = str_replace('/', '-', str_replace($imgext, '', $file));
					conf($imgname, $file, 'img');
				}
            }
        }
    }
}