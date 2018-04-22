<?php
namespace myciv;

define('MAPDIR', BASECIVDIR . 'maps/');
/**
 * Created by PhpStorm.
 * User: adiacom NUC1
 * Date: 7/21/2017
 * Time: 12:18 PM
 */
class map
{


    function processApiRequest($data) {
        $allowedApiMethods = ['setOwner', 'getMapTiles', 'saveMap', 'putTerrain', 'putRiver', 'putRoad', 'putImprovement', 'putGoody', 'changeStartLocation', 'getUnitTiles'];
        if(in_array($data['do'], $allowedApiMethods)) {
            $this->preload();
            return $this->{$data['do']}($data);
        }
        return FALSE;
    }
    /**getMapTiles
     * Variables
     */

    public $spriteFrame = [
        'river' => [
            'top', 'left', 'bottom', 'right', 'center', 'delta_bottom', 'delta_left', 'delta_right', 'delta_top'
        ],
        'roads' => [ 'bottom', 'bottomleft', 'bottomright', 'left', 'right', 'center', 'top', 'topleft', 'topright'],
    ];
    public function getSpriteFrame($image, $map) {
        if(!isset($this->spriteFrame[$image])) return NULL;
        return array_search($map,$this->spriteFrame[$image]);
    }

    /*
     * directions
     */
    public $directions = [
		'left' 			=> [ 'x' => -1, 'y' => 0, 'counterdirection' => 'right' ],
		'right' 		=> [ 'x' => 1, 'y' => 0, 'counterdirection' => 'left' ],
		'top' 			=> [ 'x' => 0, 'y' => -1, 'counterdirection' => 'bottom' ],
		'bottom'		=> [ 'x' => 0, 'y' => 1, 'counterdirection' => 'top' ],
		'topleft' 		=> [ 'x' => -1, 'y' => -1, 'counterdirection' => 'bottomright' ],
		'topright' 		=> [ 'x' => 1, 'y' => -1, 'counterdirection' => 'bottomleft' ],
		'bottomleft' 	=> [ 'x' => -1, 'y' => 1, 'counterdirection' => 'topright'],
		'bottomright' 	=> [ 'x' => 1, 'y' => 1, 'counterdirection' => 'topleft'],
	];
	public $dim4 = ['left', 'right', 'top', 'bottom'];
    public function getDirection($name) {
        return $this->directions[$name];
    }

    public function counterDirection($direction) {
        return $this->directions[$direction]['counterdirection'];
    }

    public function getTerrainTypes() { 
        return B()->getRule('terrain');
    }
    

    private $mapSize;
    public function getMapSize($var = null) {
        if(empty($this->mapSize)) {
            $ter = Gget('map')['terrain'];
            $this->mapSize  = ['x' => strlen($ter[0]), 'y' => sizeof($ter)];
        }
        if($var) return $this->mapSize[$var];
        return $this->mapSize;
    }
    public function setMapSize($mapSize) {
        $this->mapSize = $mapSize;
    }

    public $round = true;

    // Main terrain 2d string array
    private $terrain = NULL;
    public function getTerrain() {
        return $this->terrain;
    }
    public function setTerrain($terrain)
    {
        $this->terrain = $terrain;
    }

    public function setTerrainTile($x,$y, $char) {
        $this->terrain[$y][$x] = $char;
    }
    public function getTerrainTile($x,$y) {
        if(!isset($this->terrain[$y][$x])) return NULL;
        return $this->terrain[$y][$x];
    }

    // rivers
    public $rivers = [];
    public function getRivers() {
        return $this->rivers;
    }
    public function setRivers($rivers)
    {
        $this->rivers = $rivers;
    }
    public function getRiver($x,$y) {
        return (bool)(@$this->rivers[$y][$x] == 'r');
    }
     public function setRiver($x,$y, $r) {
        $this->rivers[$y][$x] = $r;
    }
    
    // roads
    public $roads = [];
    public function getRoads() {
        return $this->roads;
    }
    public function setRoads($roads)
    {
        $this->roads = $roads;
    }
    public function getRoad($x,$y) {
        if(!isset($this->roads[$y])) return false;
        return (int)$this->roads[$y][$x];
    }
     public function setRoad($x,$y, $r) {
        $r++;
        if(!isset($this->roads[$y])) {   
            $mapsize = $this->getMapSize(); 
            $string = str_pad('', $mapsize['x']);
            $this->roads[$y] = $string;
        }
        $this->roads[$y][$x] = $r;
    }
    
    // improvements
    public $improvements = [];
    public function getImprovements() {
        return $this->improvements ;
    }
    public function setImprovements($improvements)
    {
        $this->improvements = $improvements;
    }
    public function getImprovement($x,$y) {
        if(!isset($this->improvements[$y])) return false;
        return $this->improvements[$y][$x];
    }
     public function setImprovement($x,$y, $i) {
        $i++;
        if(!isset($this->improvements[$y])) {            
            $mapsize = $this->getMapSize(); 
            $string = str_pad('', $mapsize['x']);
            $this->improvements[$y] = $string;
        }
        $this->improvements[$y][$x] = $i;
    }
    
        // improvements
    public $zoc = [];
    public function getZoc() {
        return $this->zoc ;
    }
    public function setZoc($zoc)
    {
        $this->zoc = $zoc;
    }
    public function getZocTile($x,$y) {
        if(!isset($this->zoc[$y])) return false;
        if($this->zoc[$y][$x] == ' ') return false;
        return $this->zoc[$y][$x];
    }
     public function setZocTile($x,$y, $i) {
        $i++;
        if(!isset($this->zoc[$y])) {            
            $mapsize = $this->getMapSize(); 
            $string = str_pad('', $mapsize['x']);
            $this->zoc[$y] = $string;
        }
        $this->zoc[$y][$x] = $i;
    }
        
    
    // goodies
    public $goodies = [];
    public function getGoodies() {
        return $this->goodies ;
    }
    public function setGoodies($goodies)
    {
        $this->goodies = $goodies;
    }
    public function getGoody($x,$y) {
        if(!isset($this->goodies[$y])) return false;
        return $this->goodies[$y][$x];
    }
     public function setGoody($x,$y, $i) {
        if(!isset($this->goodies[$y])) {            
            $mapsize = $this->getMapSize(); 
            $string = str_pad('', $mapsize['x']);
            $this->goodies[$y] = $string;
        }
        $this->goodies[$y][$x] = $i;
    }
    
    // startlocations  [x,y] = [nations] - if empty - all allowed
    public $startLocations = [];
    public function getStartLocations() {
        return $this->startLocations;
    }
    public function setStartLocations($startLocations)
    {
        $this->startLocations = $startLocations;
    }
    public function getStartLocation($x,$y) {
        if(isset($this->startLocations[$x . '_' . $y])) {
            return $this->startLocations[$x . '_' . $y];
        }
        return NULL;
    }

    public function setStartLocation($x,$y, $nations = []) {
        $this->startLocations[$x . '_' . $y] = $nations;
    }
    public function delStartLocation($x,$y) {
        unset($this->startLocations[$x . '_' . $y]);
    }
    
  
    public function getUnit($x,$y) {
        return units()->getUnit($x,$y);
    }
    

    public $cities = NULL;
    public function getCity($x,$y) {
        if(!isset($this->cities[$x . '_' . $y])) return NULL;
        return $this->cities[$x . '_' . $y];
    }
    public function setCity($x,$y,$city) {
        $this->cities[$x . '_' . $y] = $city;
    }
    public function getCities() {
        return $this->cities;
    }
    public function setCities($cities) {
        $this->cities = $cities;
    }


    public $screenFocus = [];


    /* functions */

    /*
     * Renders map
     */
    function render($data) {
        return gtpl('map',$data);
    }

    function preload() {
        $this->loadMapData();
        $this->setCities(Gget('cities'));
        $this->setRoads(Gget('roads'));
        $this->setImprovements(Gget('improvements'));
        $this->setZoc(Gget('zoc'));
    }


    /**
     * @param file - image file
     * @return mixed
     */
    function createTerrainFromImage($file) {
		$tiles = array();

		/** loading image **/
		$fpath = $file['tmp_name'];
		$size = getimagesize($fpath); 
		if(!$size) return FALSE;
		$sizex = $size[0] - 1;
		$sizey = $size[1] - 1;
		
		switch($size['mime']) {
			case 'image/png': $img = imagecreatefrompng($fpath); break;
			case 'image/gif': $img = imagecreatefromgif($fpath); break;
			case 'image/jpeg': $img = imagecreatefromjpeg($fpath); break;
		}
		$x = $size[0];
		$y = $size[1]; $i=0;
		$this->setMapSize([ 'x' => $x, 'y' => $y]);
		
		for($j = 0; $j < $y; $j++) {
			$tiles[$j] = '';
			for($i = 0 ; $i < $x; $i++) {
				$tilex = $i;	
                $rgb = imagecolorat($img, $i, $j); 
                $cols = imagecolorsforindex($img, $rgb);
                $r = $cols['red'];
                $g = $cols['green'];
                $b = $cols['blue'];
                $rgb = array($r,$g,$b);
                $_tile = $this->findClosestTerrain($rgb);
				$tiles[$j] .= $_tile;
			}
		}	
		return $this->setTerrain($tiles);
    }

    /*
     * Generates random terrain grid
     */
    function createRandomTerrain() {
        $data = [
            'x' => $this->getMapSize()['x'],
            'y' => $this->getMapSize()['y'],
            'terrainTypes' => array_keys($this->getTerrainTypes())
         ];

        $terrainGrid = $this->randomGen($data);

        return $this->setTerrain($terrainGrid);
    }
    
    function createRandomTerrain2() {
        $x = $this->getMapSize('x');
        $y = $this->getMapSize('y');
        $types = $this->getTerrainTypes();
        for($j = 0; $j < $y; $j++) {
            for($i = 0; $i < $x; $i++) {
                $t = $this->getTerrainTile($i, $j);  
                if(isset($types[$t])) {
                    $st = $types[$t]['subterrains'];
                    if(!empty($st)) {
                        $rnd = rand(0, strlen($st) - 1);
                        $t2 = $st[$rnd];
                        if(isset($types[$t2])) {
                            $this->setTerrainTile($i,$j,$t2);
                        }
                    }
                }
            }            
        }        
    }
    
    function createRandomGoodies() {
        $x = $this->getMapSize('x');
        $y = $this->getMapSize('y');
        $types = $this->getTerrainTypes();
        $goodies = $this->getGoodyTypes();
        for($j = 0; $j < $y; $j++) {
            for($i = 0; $i < $x; $i++) {
                $g = rand(1,10);
                if($g === 1) {                  
                    $t = $this->getTerrainTile($i, $j);  
                    if(isset($types[$t])) {                        
                        $gs = $types[$t]['goodies'];
                        if(!empty($gs)) {
                            $rnd = rand(0, strlen($gs) - 1);
                            $g = $gs[$rnd];
                            if(isset($goodies[$g])) {
                                $this->setGoody($i, $j, $g);
                            }
                        }  
                    }
                } 
            }            
        }        
    }

    function randomGen($data) {
        $terrainGrid = [];
        for($j = 0; $j < $data['y']; $j++) {
            $row = str_repeat(' ', $data['x']);
            for($i = 0; $i< $data['x']; $i++) {
                $water = rand(0,2);
                if(!$water) {
                    $row[$i] = $this->randomTile($data['terrainTypes']);
                }
            }
            $terrainGrid[$j] = $row;
        } 
        return $terrainGrid;
    }

    function randomTile($terrainTypes) {
        return $terrainTypes[array_rand($terrainTypes)];
    }

    function seedGen($data) {
        //$tg =
        for($j = 0; $j < $data['y']; $j++) {

        }

        $seeds = rand(2,7);
        for($i = 0; $i< $seeds; $i++) {
            $x = rand(0, $data['x']);
            $y = rand(0, $data['y']);
            $size = round(($data['x'] + $data['y']) / 4);
            $this->seed($x,$y,$size,$data);
        }
    }

    function seed($x,$y,$size, $data) {
        $land = (bool)(rand(100) < $size );
        if($land) {
            $tt = 'stgpd';
            $t = $tt[round(abs($y / $data['y']) * strlen($tt))];
            $subterrain = $this->getTerrainTypes()[$t]['subterrain'];
            if($subterrain && ( 2 < rand(0,3))) {
                $t = $subterrain[round(0,strlen($subterrain) - 1)];
            }
            $this->setTerrainTile($x,$y,$t);
           /* foreach($this->directions) {
                // TO FINISH
            } */
        }
    }

    function createRiversFromImage($file) {
        $fpath = $file['tmp_name'];
        if(file_exists($fpath)) {
            $size = getimagesize($fpath);
            if(!$size) return false;

            switch($size['mime']) {
                case 'image/png': $img = imagecreatefrompng($fpath); break;
                case 'image/gif': $img = imagecreatefromgif($fpath); break;
                case 'image/jpeg': $img = imagecreatefromjpeg($fpath); break;
            }
            $x = $size[0] - 1;
            $y = $size[1] -1; $i=0;
            $tiles = [];
            for($j = 0; $j < $y; $j++) {
                $tiles[$j] = '';
                for($i = 0 ; $i < $x; $i++) {
                    $rgb = @imagecolorat($img, $i, $j); 
                    $cols = imagecolorsforindex($img, $rgb);
                    $alpha = $cols['alpha'];
                    $tiles[$j].= ($alpha < 50 ? 'r' : ' ');
                }
            }
            $this->setRivers($tiles);
        }	
    }


    function createRandomRivers() {
        return false;
    }
    
    function findTerrain($terrain) { 
        if(empty($terrain)) return 'water';
        foreach($this->getRules()['terrain'] as $ter) {
            if($ter['name'] == $terrain) {
                return $ter['name'];
            }
        }
        return 'water';
    }

    public function __construct()
    {
        $this->loadMapData();
    }

    function loadMapData(){
        $map = GGet('map');
        if(isset($map['terrain'])) $this->setTerrain($map['terrain']);
        if(isset($map['rivers'])) $this->setRivers($map['rivers']);
        if(isset($map['goodies'])) $this->setGoodies($map['goodies']);
        if(isset($map['startlocations'])) $this->setStartLocations($map['startlocations']);
    }
    
    function getMapData() {
        return [
            'terrain' => $this->getTerrain(),
            'rivers'  => $this->getRivers(),
            'goodies'  => $this->getGoodies(),
            'size'    => $this->getMapSize(),
            'startlocations'  => $this->getStartLocations(),
        ];
    }

    function loadMap($data) {
        $filename = MAPDIR . $data . '.php';
        if(!file_exists($filename)) return FALSE;
        include($filename);
        if(isset($data['terrain'])) {
            $terrain = $data['terrain'];
            if(is_array($terrain)) {
                $mapsize = ['x' => strlen($terrain[0]), 'y' => sizeof($terrain)];
                $this->setMapSize($mapsize);
                $this->setTerrain($terrain);
            }
        }
        if(isset($data['rivers'])) {
            $this->setRivers($data['rivers']);
        }
        if(isset($data['startlocations'])) {
            $this->setStartLocations($data['startlocations']);
        }
    }
    
    function createStartLocationsFromImage($file) {
        $locations = [];
        $fpath = $file['tmp_name'];
        if(file_exists($fpath)) {
            $size = getimagesize($fpath);
            if(!$size) return false;

            switch($size['mime']) {
                case 'image/png': $img = imagecreatefrompng($fpath); break;
                case 'image/gif': $img = imagecreatefromgif($fpath); break;
                case 'image/jpeg': $img = imagecreatefromjpeg($fpath); break;
            }
            $x = $size[0] - 1;
            $y = $size[1] -1; $i=0;
            for($j = 0; $j < $y; $j++) {
                for($i = 0 ; $i < $x; $i++) {
                    $rgb = @imagecolorat($img, $i, $j); 
                    $cols = imagecolorsforindex($img, $rgb);
                    $alpha = $cols['alpha'];
                    if($alpha < 50) $locations[$i . '_' . $j] = [];
                }
            }
            $this->setStartLocations($locations);
        }	
    }


    function saveMap($post) {
        if (!is_dir(BASE_PATH . 'civ/maps')) {
          mkdir(BASE_PATH . 'civ/maps');
        }
        file_put_contents(BASE_PATH . 'civ/maps/' . $post['name'] . '.php', '<?php $data = ' . var_export($this->getMapData(), TRUE) . ";");
    }

    /**
     * Gets units on tiles
     * @param $post
     * @return array
     */

    function getUnitTiles($post) {
        for($j = -1; $j <= $post['screenTilesY'] + 1; $j++) {
            for($i = -1; $i <= $post['screenTilesX'] + 1; $i++) {
                $tile = [];
                $tileX = $i + $post['offsetX'];// - 1;
                $tileY = $j + $post['offsetY'];
                if($tileX >= $this->getMapSize('x')) $tileX = $tileX - $this->getMapSize('x');
                if($tileX < 0) $tileX = $tileX + $this->getMapSize('x');// - 1;
                if($tileY >= $this->getMapSize('y') || $tileY < 0) continue;

                // get proxy tile with map info
                $_tile = $this->getTile($tileX, $tileY);
                if($_tile == NULL) continue;

                // add units
                if(isset($_tile['unit'])) {
                    $unit = $_tile['unit'];
                    $player = players()->getPlayer($unit['owner']);
                    $unit['color'] = $player['color'];
                    $unit['flag'] = $player['flag'];
                    $unit['direction'] = 1;

                    // check;
                    if($tileX == ($post['cursorX'] - 1) && $tileY == $post['cursorY'])  {
                        $unit['animate'] = true;
                        $unit['direction'] = $post['animation']['row'];
                        $unit['animation'] = 'attack';
                    }
                    if($tileX ==  ($post['cursorX'] + $post['animation']['x'] - 1) && $tileY == ($post['cursorY'] + $post['animation']['y'])) {
                        $unit['animate'] = true;
                        $unit['direction'] = units()->getUnitAnimationRowByDirection($post['animation']['counterdirection']);
                        $unit['animation'] = 'attack';
                    }

                    // set unit
                    if(!isset($return[$j])) $return[$j] = [];
                    $return[$j][$i] = $unit;
                }
            }
        }
        return $return;
    }


    /**
     * Main function to get map tile by cursor
     * @param $post
     * @return array
     */
    function getMapTiles($post) {
        $return = [];
        for($j = -1; $j <= $post['screenTilesY'] + 1; $j++) {
            $return[$j] = [];
			for($i = -1; $i <= $post['screenTilesX'] + 1; $i++) {
                $tile = [];
                $tileX = $i + $post['offsetX'];// - 1;                
                $tileY = $j + $post['offsetY'];                    
                if($tileX >= $this->getMapSize('x')) $tileX = $tileX - $this->getMapSize('x');
                if($tileX < 0) $tileX = $tileX + $this->getMapSize('x');// - 1;
                if($tileY >= $this->getMapSize('y') || $tileY < 0) continue;

                // get proxy tile with map info
                $_tile = $this->getTile($tileX, $tileY);
                if($_tile == NULL) continue;

                // check for cursor
                if($tileX == $post['cursorX'] && $tileY == $post['cursorY']) $tile['cursor'] = true;

                // set terrain
                $tile['terrain'] = $this->getTileTerrain($_tile['terrain']);
                // add rivers
                if(isset($_tile['river'])) {
                    $tile['rivers'] = $this->getTileRivers($tileX,$tileY);
                }

                // add city
                if(isset($_tile['city'])) {
                    $city = $_tile['city'];
                    $_tile['road'] = 1;
                    unset($_tile['improvement']);
                    $player = players()->getPlayer($city['owner']);
                    $city['color'] = $player['color']; 
                    $city['flag'] = $player['flag']; 
                    $city['style'] = $player['age'] . '_' . $player['culture'];
                    $city['img'] = B()->getRule('cities')[$player['culture']][$player['age']];
                    $tile['city'] = $city;
                }
                
               // add roads
                if(isset($_tile['road'])) {
                    $tile['road'] = $_tile['road'];
                    $tile['roads'] = $this->getRoadTiles($tileX,$tileY);
                }
                
                // add improvements
                if(isset($_tile['improvement'])) {
                    $tile['improvement'] = $_tile['improvement'];
                }
                
                 // add goody
                if(isset($_tile['goody'])) {
                    $tile['goody'] = $_tile['goody'];
                }

                
                // add startlocation
                if(isset($_tile['startlocation'])) {
                    $tile['startlocation'] = $_tile['startlocation'];
                }
                
                // add units
                /*if(isset($_tile['unit'])) {
                    $tile['unit'] = $_tile['unit'];
                    $player = players()->getPlayer($tile['unit']['owner']);
                    $tile['unit']['color'] = $player['color']; 
                    $tile['unit']['flag'] = $player['flag'];
                } */

                if(isset($_tile['unit'])) {
                    $unit = $_tile['unit'];
                    $player = players()->getPlayer($unit['owner']);
                    $unit['color'] = $player['color'];
                    $unit['flag'] = $player['flag'];
                    $unit['direction'] = 1;

                    // check;
                    if(isset($post['animation'])) {
                        if ($tileX == ($post['cursorX']) && $tileY == $post['cursorY']) {
                            $unit['animate'] = true;
                            $unit['direction'] = $post['animation']['row'];
                            $unit['animation'] = 'attack';
                            $unit['role'] = 'attacker';
                            $unit['animpos'] = $post['animation'];
                        }
                        if ($tileX == ($post['cursorX'] + $post['animation']['x']) && $tileY == ($post['cursorY'] + $post['animation']['y'])) {
                            $unit['animate'] = true;
                            $unit['direction'] = units()->getUnitAnimationRowByDirection($post['animation']['counterdirection']);
                            $unit['animation'] = 'attack';
                            $unit['animpos'] = [ 'x' => -$post['animation']['x'], 'y' => -$post['animation']['y']];
                            $unit['role'] = 'defender';
                        }
                    }
                    $tile['unit'] = $unit;
                }
                
                if($_tile['owner']) {
                    $tile['owner'] = $_tile['owner'];
                    $tile['borders'] = $this->getBorders($tileX,$tileY, $_tile['owner']);
                    $tile['bordercolor'] = players()->getPlayer($_tile['owner'], 'color');
                }

                // return tile
				$return[$j][$i] = $tile;
			} 
		} 
		return $return;
    }


    function getRoadTiles($x, $y) {
		$ret = array($this->getSpriteFrame('roads', 'center' ));
		foreach($this->directions as $direction => $v) {
			$tile = $this->getNeightbourTile($x, $y, $direction, false); 
			if(isset($tile['road'])) {
                $ret[] =  $this->getSpriteFrame('roads', $direction);
            }
		}
		return $ret;
	}
    
    function getBorders($x, $y, $owner) {
		$ret = array();
		foreach($this->dim4 as $direction) {
			$_tile = $this->getNeightbourTile($x, $y, $direction);
			if(@$_tile['owner'] != $owner) $ret[] = $direction;
		}
		return $ret;
	}
    
    /**
     * Get map data for specific tile
     * @param $x
     * @param $y
     * @return array - raw tile data
     */
    function getTile($x,$y) {
        $tile = [];
        $tile['x'] = $x;
        $tile['y'] = $y;
        $tile['terrain'] = $this->getTerrainTile($x,$y);
        if($this->getRiver($x,$y)) $tile['river'] = true;
        
        if($this->getStartLocation($x,$y) !== NULL) $tile['startlocation'] = $this->getStartLocation($x,$y);
        
        if($this->getRoad($x, $y) > 0) { 
            $tile['road'] = $this->getRoad($x, $y);           
        }
        if($this->getCity($x,$y)) {
            $tile['city'] = $this->getCity($x,$y);
            $tile['road'] = 1; // to be replaced
        }
        if($this->getImprovement($x,$y) > 0) $tile['improvement'] = $this->getImprovement($x, $y);
        
        if($this->getGoody($x,$y)) $tile['goody'] = $this->getGoodyImageByChar($this->getGoody($x,$y));
        
        $tile['owner'] = $this->getZocTile($x, $y);
        
        $tile['unit'] = $this->getUnit($x, $y);
        
        /* here also getunits, getzcc, getroad, getimprovement, etc*/
        return $tile;
    }

    /**
     * Get neighbour tile
     *
     * @param $x
     * @param $y
     * @param $direction
     * @return array | false - raw tile data
     */
    function getNeightbourTile($x,$y, $direction) {
        $xy = $this->directions[$direction];

        $y = $y + $xy['y'];
        $x = $x + $xy['x'];

        $xy = $this->fixXY($x, $y);
        $x = $xy['x'];
        $y = $xy['y'];
        if($xy && $this->getTerrainTile($x,$y) != null) { 
            $tile = $this->getTile($x,$y); 
            return $tile;
        }
        return false;
    }


    function getTileRivers($x,$y) {
        $ret = array($this->getSpriteFrame('river', 'center' ));
        foreach($this->dim4 as $direction) {
            $tile = $this->getNeightbourTile($x, $y, $direction);
            if($tile) {
                if ($tile['terrain'] == ' ') $ret[] = $this->getSpriteFrame('river', 'delta_' . $direction);
                if (isset($tile['river'])) $ret[] = $this->getSpriteFrame('river', $direction);
            }
        }
        return $ret;
    }



   function getTileTerrain($char) {
       $types = $this->getTerrainTypes();
       if(isset($types[$char])) return $types[$char]['name'];
       return 'water';
   }


   function hasWater($x, $y) {
		foreach($this->dim4 as $direction) {
			$tile = $this->getNeightbourTile($x, $y, $direction);
			if($tile['terrain'] == 'water') return true;
		}
		return FALSE;
	}
    
    function setZoneControl($x, $y, $override = true) {
        
    }
    

	
	function fixXY($x,$y) {		
		if($y > $this->getMapSize('y') || $y < 0) return FALSE;
		if($x > $this->getMapSize('x') || $x < 0) {
			if(!$this->round) return FALSE;
			if($x < 0) $x = $this->getMapSize('x') - $x;
			if($x >= $this->getMapSize('x')) $x = $x - $this->getMapSize('x');
		}
		return ['x' => $x, 'y' => $y];
	}

   function putPlayers($players) {
        players()->setPlayers($players);
        // startlocation logic
        $i = 0; $total = count($players);
        if(!empty($this->getStartLocations())) {
            $locs = $this->getStartLocations();
            for($i = 0; $i < $total; $i++){
                if(empty($locs)) break;
                foreach($locs as $k => $civs) {
                    $civ = $players[$i]['civ'];
                    $civlist = civ()->getCivs();
                    // if there are special civs in start location
                    if(!empty($civs)) {
                        // if random -> select from them
                        if($civ == -1) {
                            $civ = array_rand($civs);
                            $civ = civ()->getCivByName($civ, true);
                        }
                        // else check if selected civ is in array
                        else {
                            $_civ = $civlist[$civ]['name'];
                            if(!in_array($_civ,$civs)) {
                                continue;
                            }
                        }
                    }
                    // else if there are no predefined civs and auto mode
                    elseif($civ == -1) {
                        $civ = array_rand($civlist);
                    }
                    // if we randomized player civ -> save player
                    if($civ != $players[$i]['civ']) {
                        $players[$i]['civ'] = $civ;
                        players()->setPlayers($players);
                    }
                    // saving
                    list($x, $y) = explode('_', $k);
                    if ($this->putPlayer($x, $y, $i)) {
                        unset($locs[$k]);
                        break;
                    }
                }
            }
        }
        $max = 0;
        for($i = $i; $i < $total; $i++){
            if(!empty($locs)) {
                $loc = array_pop($locs);

                continue;
            }

            $found = false;
            while(!$found) {
                $x = rand(0, $this->getMapSize()['x'] - 1);
                $y = rand(0, $this->getMapSize()['y'] - 1);
                $max++; if($max > 1000) return;
                $found = $this->putPlayer($x, $y, $i);
            }
        }
       // print_r($this->getCities());
      // die();
    }
    
    function putPlayer($x,$y, $i) {
        if($this->canBuildCity($x,$y, $i)) {
            $this->cities[$x . '_' . $y] = cities()->build($x,$y,$i);
            $this->setZoc9($x,$y, $i);
            return true;
        }  
        return false;
    }
    
    function canBuildCity($x,$y, $pid){
        if($this->getTerrainTile($x, $y) == ' ') return FALSE;
        if($this->getCity($x,$y)) return FALSE;
        if($this->getZocTile($x, $y) && $this->getZocTile($x, $y) != $pid) return FALSE;
        foreach($this->directions as $dim) {
            $_x = $x + $dim['x']; if($_x < 1) $_x = 1; if($_x > $this->getMapSize()['x']) $_x = $this->getMapSize()['x'];
            $_y = $y + $dim['y']; if($_y < 1) $_y = 1; if($_y > $this->getMapSize()['y']) $_x = $this->getMapSize()['y'];
            if($this->getCity($_x,$_y)) return FALSE;
        } 
        return TRUE;
    }


    
    function setZoc9($x,$y,$i) {
        foreach($this->directions as $dim) {
            $_x = $x + $dim['x']; if($_x < 1) $_x = 1; if($_x > $this->getMapSize()['x']) $_x = $this->getMapSize()['x'];
            $_y = $y + $dim['y']; if($_y < 1) $_y = 1; if($_y > $this->getMapSize()['y']) $_x = $this->getMapSize()['y'];
            $this->setZocTile($x, $y, $i);
        }
        B()->set('zoc', $this->getZoc());
        B()->save();        
    }
    
   
    
    function findClosestTerrain($rgb) {
		$diff = 255 * 3;
		$terrain = ' ';		
		$terr = $this->getTerrainTypes(); 
        $terr[] = ['color' => '0066bb', 'char' => ' '];
		foreach($terr as  $t) {
			$trgb = list($r, $g, $b) = sscanf($t['color'], "%02x%02x%02x");
			$r = abs($rgb[0] - $trgb[0]);
			$g = abs($rgb[1] - $trgb[1]);
			$b = abs($rgb[2] - $trgb[2]);
			$_diff = $r + $g + $b;
			if($_diff < $diff) {
				$diff = $_diff;
				$terrain = $t['char'];
			}
		} 
		return $terrain;
	}
    
    public function putRiver($data) {
        $this->setRiver($data['x'], $data['y'], $data['data']);
        $this->saveData();
    }
    
    public function putTerrain($data) {
        $this->setTerrainTile($data['x'], $data['y'], $data['data']['terrain']);
        $this->saveData();
    }
    public function putImprovement($data) {
        $this->setImprovement($data['x'], $data['y'], $data['data']['improvement']);
        B()->set('improvements', $this->getImprovements());
        B()->save();
    }
    public function putRoad($data) {
        $this->setRoad($data['x'], $data['y'], $data['data']['road']);
        B()->set('roads', $this->getRoads());
        B()->save();
    }
    public function putGoody($data) { 
        $this->setGoody($data['x'], $data['y'], $data['data']['goody']);
        $this->saveData();
    }
    
    public function setOwner($data) {
        $this->setZocTile($data['x'], $data['y'], $data['data']['zoc']);
        B()->set('zoc', $this->getZoc());
        B()->save();
    }

    function changeStartLocation($data){
        switch($data['data']) {
            case 'del':  $this->delStartLocation($data['x'], $data['y']); break;

            case 'put': $this->setStartLocation($data['x'], $data['y']); break;

            default: $this->setStartLocation($data['x'], $data['y'], explode(',', $data['data']));break;
        }
        $this->saveData();
    }


    function saveData() {
        B()->set('map',$this->getMapData());
        B()->save();
    }
    
    public function getGoodyTypes() { 
        return B()->getRule('goodies');
    }
    
    function getGoodyImageByChar($char) {
        $goodyTypes = $this->getGoodyTypes();
        foreach($goodyTypes as $goody) {
            if($goody['char'] == $char) {
                return $goody['img'];
            }
        }
        return FALSE;
    }

    function minimap($get) {
        $mode = 'game';
        if(isset($get['gid'])) {
            Gload($get['gid']);
            $mode = 'game';
        } else {
            return false;
        }
        
        $this->preload();
        $ttypes = $this->getTerrainTypes();
        $mapsize = $this->getMapSize();
        $im = imagecreatetruecolor($mapsize['x'] * 2, $mapsize['y'] *2);
        $black = imagecolorallocate($im, 0, 0, 0);
        for($x = 0; $x < $mapsize['x']; $x++) {
            for($y = 0; $y < $mapsize['y']; $y++) {
                $tile = $this->getTile($x,$y);
                
                $t = $this->getTerrainTile($x, $y); 
                $color = (isset($ttypes[$t]) ? $ttypes[$t]['color'] : '000088');
                $rgb = sscanf($color, "%02x%02x%02x");                
                $color = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]); 
                
                if(isset($tile['river'])) {
                    $_rgb = sscanf('000088', "%02x%02x%02x"); 
                    $color = imagecolorallocate($im, ($rgb[0] + $_rgb[0] * 2) / 2, ($rgb[1] + $_rgb[1] * 2) / 2, ($rgb[2] + $_rgb[2] * 2) / 2); 
                }
                
                imagesetpixel($im, $x * 2, $y * 2, $color); 
                imagesetpixel($im, $x * 2 + 1, $y * 2, $color); 
                imagesetpixel($im, $x * 2, $y * 2 + 1, $color); 
                imagesetpixel($im, $x * 2 + 1, $y * 2 + 1, $color); 
            }
        } 
        
        if($mode == 'game') {
            foreach($this->getCities() as $coords => $city) {
                list($x,$y) = explode('_', $coords);
                $color =  @players()->getPlayer($city['owner'], 'color');
                if(empty($color)) $color = '000000';
                $rgb = sscanf($color, "%02x%02x%02x");                
                $color = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]); 
                imagerectangle($im, $x * 2 -1, $y * 2 -1, $x * 2 +2, $y * 2 + 2, $black);
                imagesetpixel($im, $x * 2, $y * 2, $color); 
                imagesetpixel($im, $x * 2 + 1, $y * 2, $color); 
                imagesetpixel($im, $x * 2, $y * 2 + 1, $color); 
                imagesetpixel($im, $x * 2 + 1, $y * 2 + 1, $color); 
            }
        } else {            
            $color = imagecolorallocate($im, 255, 255, 255); 
        }
        header('Content-Type: image/png');
        imagepng($im);
        imagedestroy($im);
        die();
    }
}


