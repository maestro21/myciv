<?php 


class Map {

	public $conf;

	public $map;
	
	public $mapsize;

	public $round = true;
	
	public $dimensions = [
		'left' 			=> [ 'x' => -1, 'y' => 0 ],
		'right' 		=> [ 'x' => 1, 'y' => 0 ],
		'top' 			=> [ 'x' => 0, 'y' => -1 ],
		'bottom'		=> [ 'x' => 0, 'y' => 1 ], 
		'topleft' 		=> [ 'x' => -1, 'y' => -1 ],
		'topright' 		=> [ 'x' => 1, 'y' => -1 ],
		'bottomleft' 	=> [ 'x' => -1, 'y' => 1],
		'bottomright' 	=> [ 'x' => 1, 'y' => 1],
	];
	
	public $dim4 = ['left', 'right', 'top', 'bottom'];
	
	public function __construct() {
		global $config;
		$this->conf = $config;
	}

	function randomMap($x = 26, $y = 10) {
		$map = array();
		$this->mapsize = [ 'x' => $x, 'y' => $y];
		
		$terr = $this->conf['terrain'];
		for($j = 0; $j < $y; $j++) {
			$map[$j] = array();
			for($i = 0; $i< $x; $i++) {
				$tile = array();
				
				$water = rand(0,1);
				if((bool)$water) {
					$terrain = 'water';
				} else {
					$terrain = $terr[array_rand($terr)][0];
				}
				$tile['terrain'] = $terrain;
				
				$tile = $this->generateTile($tile);		
				
				
				
				$map[$j][$i] = $tile;		
			}
		}
		$this->map = $map;
		return $map;
	}


	function getNeightbourTile($x,$y, $dimension) {
		$xy = $this->dimensions[$dimension];
		
		$y = $y + $xy['y'];		
		$x = $x + $xy['x'];

		$xy = $this->fixXY($x, $y);
		$x = $xy['x']; 
		$y = $xy['y'];
		if($xy && isset($this->map[$y][$x])) {
			return $this->map[$y][$x];
		}
		return false;		
	}
	
	function fixXY($x,$y) {		
		if($y > $this->mapsize['y'] || $y < 0) return FALSE;
		if($x > $this->mapsize['x'] || $x < 0) { 
			if(!$this->round) return FALSE;
			if($x < 0) $x = $this->mapsize['x'] - $x;
			if($x >= $this->mapsize['x']) $x = $x - $this->mapsize['x'];	
		}
		return ['x' => $x, 'y' => $y];
	}


	function getMapTiles($config = null, $map = null) {
		
		if(!$config) $config = $this->conf;
		if(!$map) $map = $this->map; 
		
		$this->map = $map = $this->setBorders($map);
		
		$y = sizeof($map);
		$x = sizeof($map[0]);  
		for($j = 0; $j <= $y; $j++) {
			for($i = 0; $i <= $x; $i++) {
				$tile = @$map[$j][$i];
				if($tile['terrain'] == 'water'){					
					unset($tile['city']);
					//continue;
				} elseif($this->hasWater($i, $j)) {
					$tile['coast'] = 1;	
				}
				if(@$tile['road']) $tile['roads'] = $this->getRoads($i, $j, (bool)$tile['city']);
				if(@$tile['river']) $tile['rivers'] = $this->getRivers($i,$j);		
				
				if(@$tile['city']) { $tile = $this->getDocks($i, $j, $tile);	}
				//print_r($tile['owner']);
				if(@$tile['owner'] == 'roman') 
					$tile['borders'] = $this->getBorders($i, $j,$tile);
				
				$map[$j][$i] = $tile;
			} 
		} 
		$this->map = $map;
		return $map;
	}

	function getImprovementByTerrain($terrain) {
		$ret = '';
		switch($terrain) {
			case 'hills':
			case 'mountains':
				$ret = 'mine';
			break;
			
			case 'forrest':
			case 'jungle':
				$ret = 'lumbermill';
			break;

			default:
				$ret = 'irrigation';
			break;
		}
		return $ret;
	}
	
	
	function nearCity($x, $y) {
		$ret = array();
		foreach($this->dimensions as $dimension => $v) {
			$tile = $this->getNeightbourTile($x, $y, $dimension);
			if((bool)@$tile['city']) return true;
		}
		return FALSE;
	}
	
	function getWater($x, $y) {
		$water = array();
		foreach($this->dimensions as $dimension => $v) {
			$tile = $this->getNeightbourTile($x, $y, $dimension);
			if($tile['terrain'] == 'water') $water[] = $v;
		}
		return $water;
	}
	
	
	function getDocks($x, $y, $tile) {
		$tile['dock1'] = $tile['dock2'] = array();
		$front = [ 'bottom' , 'bottomleft', 'bottomright', 'left', 'right'];
		
		foreach($this->dimensions as $dimension => $v) {
			$_tile = $this->getNeightbourTile($x, $y, $dimension);
			if($_tile['terrain'] == 'water') {
				if(in_array($dimension, $front)) {
					$tile['dock2'][] = $v;
				} else {
					$tile['dock1'][] = $v;
				}
			}
		}
		return $tile;
	}
	
	
	function hasWater($x, $y) {
		foreach($this->dim4 as $dimension) {
			$tile = $this->getNeightbourTile($x, $y, $dimension);
			if($tile['terrain'] == 'water') return true;
		}
		return FALSE;
	}
	
	function getRoads($x, $y, $city) {
		$ret = array();
		foreach($this->dimensions as $dimension => $v) {
			$tile = $this->getNeightbourTile($x, $y, $dimension);
			if(@$tile['road'] || @$city) $ret[] = $dimension;
		}
		return $ret;
	}
	
	function getRivers($x, $y) {
		$ret = array();
		foreach($this->dim4 as $dimension) {
			$tile = $this->getNeightbourTile($x, $y, $dimension);
			if($tile['terrain'] == 'water') $ret[] = 'start_' . $dimension;
			if(@$tile['river']) $ret[] = $dimension;
		}
		return $ret;
	}
	
	
	function getBorders($x, $y, $tile) {
		$ret = array();
		foreach($this->dim4 as $dimension) {
			$_tile = $this->getNeightbourTile($x, $y, $dimension);
			if(@$_tile['owner'] != 'roman') $ret[] = $dimension;
		}
		return $ret;
	}
	
	function generateTile($tile = array()) { 
		if(!is_array($tile)) $tile = array();
		if(!isset($tile['terrain'])) {
			$water = yesno(2);
			if((bool)$water) {
				$terrain = 'water';
			} else {
				$terr = $this->conf['terrain'];
				$terrain = $terr[array_rand($terr)][0];
			}
			$tile['terrain'] = $terrain;
		}
				
		if(!isset($tile['owner'])) {
			$tile['owner'] = 'none';
		}

		if(!isset($tile['unit'])) $tile['unit'] = yesno(5);
		if($tile['unit']) {
			$tile['nation'] = 'roman';
			if($tile['terrain']  == 'water') {
				$tile['unit'] = 'trireme';
			} else {
				$tile['unit2'] = 'legio'; 
			}
		}
		
		if($tile['terrain'] == 'water') { return $tile; }			
		switch($tile['terrain']) {
			case 'hills':
			case 'mountains':
			case 'forrest':
			case 'jungle':
				$tile['terrain2'] = $tile['terrain'];
			break;
		}	
		
		$gen = [
			'city' => 10,
			'improvement' => 2,
			'river' => 2,
			'road' => 1,		
		];

		if(!empty($gen)) {
			foreach($gen as $k => $v) {
				
				if(!isset($tile[$k])) {
					$tile[$k] = yesno($v);
				}
			}
		}	

		if((bool)$tile['city']) {
			if($this->nearCity($tile['x'], $tile['y'])) {
				unset($tile['city']);
			} else {
				$tile['improvement'] = 1;
				$tile['city'] = $this->findClosestCity($tile['x'], $tile['y']);
				$tile['city']['gfxsize'] = $this->getCityGfxSizeByCitySize($tile['city']['size']);
			}
		}
		
			
		if((bool)$tile['unit'] || (bool)@$tile['city']) {
			$tile['nation'] = 'roman';
		}
		if((bool)$tile['improvement']) { 
			$tile['improvement'] = $this->getImprovementByTerrain(@$tile['terrain']);
		}
		


		
		return $tile;	
	}
	
	
	function claimLandByCity($x, $y, $gfxsize, $map) {
		$rad = ($gfxsize > 1 ? 2 : 1);
		$ystart = ($y - $rad); $yend = ($y + $rad);
		$xstart = ($x - $rad);  $xend = ($x + $rad); 
		for($j = $ystart; $j < $yend + 1; $j++) {
			for($i = $xstart; $i < $xend + 1; $i++) {
				if($rad > 1) {
					if(in_array($j, [$ystart, $yend]) && in_array($i, [$xstart, $xend])) continue;
				}
				if(isset($map[$j][$i])) {
					$map[$j][$i]['owner'] = 'roman'; //echo $i . ' ' . $j;
				}
			}
		} 
		return $map;
	}
	
	function getCityGfxSizeByCitySize($citysize) {
		$gfxsize = floor($citysize / 4) + 1;
		if($gfxsize > 4) $gfxsize = 4;
		return $gfxsize;
	}
	
	function findClosestCity($x,$y) {
		if(!isset($this->conf['cities'])) return FALSE;
		$cities = $this->conf['cities'];
		$diff = 99999;
		$city = 'Rome';
		
		foreach($cities as $_city) {
			$_x = abs($_city['x'] - $x);
			$_y = abs($_city['y'] - $y);
			$_diff = $_x + $_y;
			if($_diff < $diff) {
				$diff = $_diff;
				$city = $_city;
			}
		}
		return $city;		
	}
	
	function findClosesTerrain($rgb) {
		$diff = 255 * 3;
		$terrain = 'water';		
		$terr = $this->conf['terrain'];
		foreach($terr as  $t) {
			$trgb = $t[1];
			$r = abs($rgb[0] - $trgb[0]);
			$g = abs($rgb[1] - $trgb[1]);
			$b = abs($rgb[2] - $trgb[2]);
			$_diff = $r + $g + $b;
			if($_diff < $diff) {
				$diff = $_diff;
				$terrain = $t[0];
			}
		}
		return $terrain;
	}
	
	function loadMap($map = 'demomap') { //die('11');		

		$tiles = array();
	
		/** loading image **/
		$fpath = 'maps/' . $map . '.png';
		$size = getimagesize($fpath);
		if(!$size) return FALSE;
		
		switch($size['mime']) {
			case 'image/png': $img = imagecreatefrompng($fpath); break;
			case 'image/gif': $img = imagecreatefromgif($fpath); break;
			case 'image/jpeg': $img = imagecreatefromjpeg($fpath); break;
		}
		$x = $size[0];
		$y = $size[1]; $i=0;
		$this->mapsize = [ 'x' => $x, 'y' => $y];
		for($j = 0; $j < $y; $j++) {
			$tiles[$j] = array();
			for($i = 0 ; $i < $x; $i++) {
				$rgb = imagecolorat($img, $i, $j); 
				$cols = imagecolorsforindex($img, $rgb);// print_r($cols);
				$r = $cols['red'];
				$g = $cols['green'];
				$b = $cols['blue'];
				$rgb = array($r,$g,$b);
				$_tile = $this->findClosesTerrain($rgb);
				$tiles[$j][$i]['terrain'] = $_tile;
				$tiles[$j][$i]['x'] = $i;
				$tiles[$j][$i]['y'] = $j;	
				$tiles[$j][$i]['owner'] = 'none';
			}
		}

		/** adding Data **/
		$data = ['river', 'road', 'improvement', 'city']; 
		foreach($data as $load) {
			$fpath = 'maps/' . $map . '_' .  $load . '.png';
			if(file_exists($fpath)) {
				$size = getimagesize($fpath);
				if(!$size) continue;
				
				switch($size['mime']) {
					case 'image/png': $img = imagecreatefrompng($fpath); break;
					case 'image/gif': $img = imagecreatefromgif($fpath); break;
					case 'image/jpeg': $img = imagecreatefromjpeg($fpath); break;
				}
				$x = $size[0];
				$y = $size[1]; $i=0;
				for($j = 0; $j < $y; $j++) {
					for($i = 0 ; $i < $x; $i++) {
						$rgb = imagecolorat($img, $i, $j); 
						$cols = imagecolorsforindex($img, $rgb);
						$alpha = $cols['alpha'];
						$tiles[$j][$i][$load] = (int)($alpha < 50 );
					}
				}
			}
		}		
		/** load city info **/
		if(file_exists('maps/' . $map . '_cities.php')) include('maps/' . $map . '_cities.php');
		if(file_exists('maps/' . $map . '_cities.json')){
			$this->conf['cities'] = json_decode(file_get_contents('maps/' . $map . '_cities.json'), true);
			//print_r($this->conf['cities']);
		}
	
		for($j = 0; $j < $y; $j++) {
			for($i = 0 ; $i < $x; $i++) {		
			$tiles[$j][$i] = $this->generateTile($tiles[$j][$i]);
		}}
		
		$this->map = $tiles;				
		return $tiles;	
	}
	
	function setBorders($map) {
		$y = sizeof($map);
		$x = sizeof($map[0]);  
		for($j = 0; $j <= $y; $j++) {
			for($i = 0; $i <= $x; $i++) {
				$tile = @$map[$j][$i];
				if(@$tile['city']) $map = $this->claimLandByCity($tile['x'], $tile['y'],$tile['city']['gfxsize'], $map);
			}
		}		
		return $map;
	}
}


function yesno($chance = 1) {
	return (bool)($chance == rand(0,$chance));
}