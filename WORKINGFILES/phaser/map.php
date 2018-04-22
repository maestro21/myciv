<?php 
include('config.php');
$action = @$_POST['action'];
$M = new Map();
if(method_exists($M, $action)) {
	define("DEBUG", false);
	$M->$action($_POST);
} 
/**/
else {
	// debug	
	define("DEBUG", true);
	$data = array(
		'offsetX' => 75,
		'offsetY' => 35,
		'map' => 'world150x150',
	);
	$M->getMap($data);	
}
/**/


class Map {

	private $tiles = array();	
	private $map = array();
	private $mapname;
	
	private $mapSizeX = 0;	
	private $mapSizeY = 0;
	
	private $offsetX = 0;	
	private $offsetY = 0;
	
	private $coastFrames;
	private $coastDirections;	
	
	private $terrain;
	private $terrain2;
	
	private $rivers = array();
	private $riverFrames;
	
	private $dir1;
	private $dir2;
	private $directions;

	function __construct() {
		$this->dir1 = array('left', 'right', 'top', 'bottom');
		$this->dir2 = array('topleft', 'topright', 'bottomleft', 'bottomright');
		$this->directions = array_merge($this->dir1, $this->dir2);	
	
		$this->terrain =  array(
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
		$this->terrain2 = array(
			'jungle' => 'floodplains',
			'forrest' => 'taiga',
			'mountains' => 'plains',
			'hills' => 'plains'
		);
		$this->coastFrames = array_flip(array(
			'corner_bottom',
			'corner_bottom_in',
			'corner_left',
			'corner_left_in',
			'corner_right',
			'corner_right_in',		
			'corner_top',
			'corner_top_in',
			'line_bottomleft',
			'line_bottomright',
			'line_topleft',
			'line_topright',
		));	
		
		$this->coastDirections  = array(
			'topright' 		=> array(
				'op' => 'bottomleft', 
				'45' => 'right', 	
				'90' => 'bottomright', 	
				'90op' => 'topleft', 	
				'corner' => 'bottom',
			),
			'bottomright' 	=> array(
				'op' => 'topleft', 
				'45' => 'bottom', 	
				'90' => 'bottomleft',	
				'90op' => 'topright', 	
				'corner' => 'left',
			),
			'bottomleft' 	=> array( 
				'op' => 'topright', 
				'45' => 'left', 	
				'90' => 'topleft',		
				'90op' => 'bottomright',
				'corner' => 'top',
			),
			'topleft' 		=> array(
				'op' => 'bottomright', 
				'45' => 'top', 	
				'90' => 'topright',		
				'90op' => 'bottomleft',	
				'corner' => 'right',
			),
		);
		
		$this->riverFrames = array_flip(array(
			'delta_bottomleft',
			'delta_bottomright',
			'delta_topleft',
			'delta_topright',
			'river_bottomleft',
			'river_bottomright',
			'river_topleft',
			'river_topright',
		));	
	}
	
	/* sets changes to terrain */
	public function setTerrain($data) {
		$this->mapname = $data['map'];
		$this->map = file('maps/' . $this->mapname . '/map.txt');
		$this->map[$data['data']['y']][$data['data']['x']] = $data['data']['val'];
		file_put_contents('maps/' . $this->mapname . '/map.txt', implode("", $this->map));	
		
		$this->getMap($data);
	}
	
	/* sets river on a tile */
	public function setRiver($data) {
		$this->mapname = $data['map'];
		$this->river = file('maps/' . $this->mapname . '/river.txt');
		$this->river[$data['data']['y']][$data['data']['x']] = $data['data']['val'];
		file_put_contents('maps/' . $this->mapname . '/river.txt', implode("", $this->river));	
		
		$this->getMap($data);
	}
	
	
	/** returns piece of map **/
	public function getMap($data) {
		/** reading variables */
		$this->offsetX = $data['offsetX'];
		$this->offsetY = $data['offsetY'];
		$this->mapname = $data['map'];	
		/** setting variables **/
		$this->map = file('maps/' . $this->mapname . '/map.txt');		
		$this->mapSizeX = strlen($this->map[0]);
		$this->mapSizeY = count($this->map);
		if(file_exists('maps/' . $this->mapname . '/river.txt')) {
			$this->rivers = file('maps/' . $this->mapname . '/river.txt');
		}
		//print_r($map[1][1]);
		
		/**	SCREEN WALKTRHOUGH
			x,y - screen coords 
			dx, dy - map coords **/
			
		/* foreach screen tile row */
		for($y = - 1; $y <= conf('screenTilesY'); $y++) {
		
			/* map y = screen y + offset y */
			$dy = $y + $this->offsetY;
			/* if map y out of boundaries - this means snow */
			if($dy < 0 || $dy == $this->mapSizeY) {
				for($x = -1; $x <= conf('screenTilesX'); $x++) {
					$this->tiles[$y][$x] = array( 'terrain' => 'snow');
				}
			} 			
			else 			
			{	
				$row = $this->map[$dy];
				if(!isset($this->tiles[$y])) { $this->tiles[$y] = array(); }
				/* foreach screen tile cell */
				for($x =  - 1; $x <= conf('screenTilesX'); $x++) {
				
					/* map x = screen x + offset x */
					$dx = $x + $this->offsetX;
					/* if map x out of boundaries - pick up tile from another side of map 
						TODO - if map flat - fill with water instead */
					if($dx < 0) $dx = $this->mapSizeX + $dx;
					if($dx >= $this->mapSizeX) $dx = $this->mapSizeX - $dx;
					
					if(!isset($this->tiles[$y][$x])) $this->tiles[$y][$x] = array();
					/* setting up terrain */				
					$_terrain = $this->terrain[$row[$dx]];
					if(empty($_terrain)) $_terrain = 'water';
					/* if its upon surface (hills, mountains, forrest) - put in terrain2 layer */
					if(isset($this->terrain2[$_terrain])) {
						$this->tiles[$y][$x]['terrain2'] = $_terrain;
						$_terrain = $this->terrain2[$_terrain];
					}			
					$this->tiles[$y][$x]['terrain'] = $_terrain;
					/** adding coast **/
					if($_terrain == 'water') {
						$this->getCoast($dx, $dy);
					}
					/** adding river **/
					if($this->rivers[$dy][$dx] == 'r') {
						unset($this->tiles[$y][$x]['terrain2']);
						$this->tiles[$y][$x]['river'] = $this->getRiver($dx,$dy);
					}
				}
			}
		}	
		
		/** parsing output **/
		echo json_encode($this->tiles);
	}



	/** COAST **/
	/* add coast to list */
	function addCoast($xy, $img) {
		//print_r($coastFrames);
		$x = $xy['x'] - $this->offsetX;
		$y = $xy['y'] - $this->offsetY; //echo $y . ' ' . $x;
		if(!isset($this->tiles[$y])) { $this->tiles[$y] = array(); }
		if(!isset($this->tiles[$y][$x])) { $this->tiles[$y][$x] = array(); }
		if(!isset($this->tiles[$y][$x]['coast'])) {
			$this->tiles[$y][$x]['coast'] = array();
		} 
		if(DEBUG) echo "drawing @ [$x,$y]: $img<br>";
		$this->tiles[$y][$x]['coast'][] = $this->coastFrames[$img];	
	}
	/* gets coast pictures for nearby tiles */
	function getCoast($x, $y) { 
		if(DEBUG) echo "there is a water on [$x $y] so we add coast to nearby tiles<br>";
		foreach($this->coastDirections as $direction => $p) {			
			//checking if we have water in neighbour tile. if no, then draw shore.
			$n = $this->getNeighbourXY($x, $y, $direction);
			$t = array('x' => $x, 'y' => $y); //var_dump($n);
			//if($tiles[$n['y']][$n['x']]['terrain'] == 'swamp') return;
			if($this->isSurface($n)) {
				if(DEBUG) echo "adding coast to [$x $y] from the $direction [{$n['x']} {$n['y']}]<br>";
				//checking if we have water on a 90* tile. if no, then draw corner.
				$c = $this->getNeighbourXY($x, $y, $p['90']);				
				if($this->isSurface($c)) {
					if(DEBUG) echo "there is surface on {$p['90']}[{$c['x']} {$c['y']}] so we draw 'corner_{$p['45']}_in'<br>";
					$this->addCoast($t, 'corner_' . $p['45'] . '_in');
				} else {
					if(DEBUG) echo "there is no surface on {$p['90']}[{$c['x']} {$c['y']}] so we draw line or outer corner <br>";
					//checking if we have water on a 90* tile. if no, then draw corner. else - draw a line
					$cc = $this->getNeighbourXY($x, $y, $p['45']);	
					if($this->isSurface($cc)) {
						if(DEBUG) echo "there is surface on [{$cc['x']} {$cc['y']}] so we draw line<br>";
						//fix for horisontal lines
						if($p['op'] == 'topleft' || $p['op'] == 'bottomright') {
							$this->addCoast($cc,'line_'. $p['op']);
						} else {
							$this->addCoast($n, 'line_'. $p['op']);
						}
					} else {
						if(DEBUG) echo "there is no surface on [{$cc['x']} {$cc['y']}] so we draw 'corner_{$p['corner']}'<br>";
						$this->addCoast($n,'corner_'. $p['corner']);
					}
				}
			}			
		}	
	}

	function isSurface($xy) {
		$tile = @$this->map[$xy['y']][$xy['x']]; 
		if(empty($tile)) return false;
		return ($tile != 'w');
	}
	
	function getNeighbourXY($x, $y, $direction) {
		$even  = $y % 2; 
		$op = '';
		switch($direction) {
			case 'left': 	$x--; $op = 'right';  break;
			case 'right': 	$x++; $op = 'left'; break;
			case 'top':  	$y = $y - 2; $op = 'bottom'; break;
			case 'bottom': 	$y = $y + 2; $op = 'top'; break;
			
			case 'topleft': 	$x = $x + $even - 1; $y--;
			break;
			case 'topright':	$x = $x + $even; $y--;
			break;
			case 'bottomleft': 	$x = $x + $even - 1; $y++;
			break;
			case 'bottomright': $x = $x + $even; $y++;
			break;
		}		
		if($y < 0) return false;
		if($y >= $this->mapSizeY) return false;
		if($x < 0) $x = $this->mapSizeX + $x;
		if($x >= $this->mapSizeX) $x = $x - $this->mapSizeX;
		return array('x' => $x, 'y' => $y);
	}
	
	/** add river **/
	function getRiver($x, $y) {	
		$river = array();
		$n = array('x' => $x, 'y' => $y);
		foreach($this->dir2 as $direction) {
			$xy = $this->getNeighbourXY($x,$y,$direction);
			if($this->rivers[$xy['y']][$xy['x']] == 'r') {
				$river[] = $this->riverFrames['river_' . $direction];
			}
			if($this->map[$xy['y']][$xy['x']] == 'w') {
				$river[] = $this->riverFrames['delta_' . $direction];
			}
		}
		return $river;
	}
}