<?php
namespace myciv;
require_once('class.base.php');

class game {


    public $map;


    /*
     * Create game and returns data
     * 4 ways to create game: random map, load map, load images, load scenario. Scenario and map has already ruleset,
     * We can unite load images and random map. No image -> randomize. Images: terrain, river, start location.
     */
    function create($data) {
        $mode = $data['mapmode'];
        if(isset($data['ruleset'])) {
            $ruleset =  $data['ruleset'];
        }
        $createt2 = false;
        $creategoodies = true;
        if($mode == 'loadmap') {
            $createt2  = (bool)(isset($data['loadmap']['createterrain2']));
            $creategoodies = (bool)(isset($data['loadmap']['creategoodies']));
        }
        
        // load scenario if present - gamedata and map
        if($mode == 'scenario' && isset($data['scenario'])) {
        }
        // load map from file
        if($mode == 'openmap' && isset($data['openmap']['map'])) {
            map()->loadMap($data['openmap']['map']);
        }
        
        // set and process ruleset
        B()->setRuleset($ruleset);

        // load map if not present

        if($mode == 'loadmap' && empty(map()->getTerrain()) && null !== f('form-loadmap-map')) {
            map()->createTerrainFromImage(f('form-loadmap-map'));
        }
        if(empty(map()->getTerrain())){
            map()->setMapSize($data['randommap']['mapsize']);
            map()->createRandomTerrain();
        }
        // set forests
        if($createt2) {
            map()->createRandomTerrain2();
        }
        
        // same here
        if($mode == 'loadmap' && empty(map()->getRivers()) && null !== f('form-loadmap-river')) {
            map()->createRiversFromImage(f('form-loadmap-river'));
        }
        if(empty(map()->getRivers())){
            map()->createRandomRivers();
        }

        // set goodies
        if($creategoodies) {
            map()->createRandomGoodies();
        }
        

        
        // load startlocations if present
        if($mode == 'loadmap' &&  empty(map()->getStartLocations()) && null !== f('form-loadmap-startlocations')) {
            map()->createStartLocationsFromImage(f('form-loadmap-startlocations'));
        }
        
        
        $this->putPlayers($data);

        $data = [
            'ruleset' => $ruleset, //change to ruleset id
            'map'   => map()->getMapData(),
            'players' => players()->getPlayers(),
            'cities' => map()->cities,
            //'screenFocus' => $this->map->screenFocus,
        ];
        //print_r($data); die();
        return $data;
    }

    
    function putPlayers($data) {
        //GM('players')->setData($data['players']);
        map()->putPlayers($data['players']);
       // GM('map')->GM('city')->build();
    }

    

    /**
     * Play game
     */
    function play($id) {
        Gload($id);
        $data = [
           'civs' => civ()->getCivs(),
           'ruleset' => B()->getRules(),
           'game' => B()->loadGameData($id),
           'gid' => $id,           
        ]; 
        return map()->render($data);
    }


    /*
     * Main function to handle API requests
     */
    function api($data) {
        $allowedClasses = ['map' ,'atlas','players', 'city', 'civ', 'units'];
        if(!in_array($data['class'], $allowedClasses)) return $this->error('class not allowed');

        $gid = (int)@$data['gid'];
        Gload($gid);
        $cl = GM($data['class']);
        return $cl->processApiRequest($data);
    }


    /*
     *  Main function to handle errors
     */
    public function error($error = '') {
        return ['status' => 'error', 'msg' => $error];
    }
    
    function getBase() {
        return B();
    }
    
    function getGameClass($class) {
        return GM($class);
    }    

}