<?php
define('BASECIVDIR', BASE_PATH . 'civ/');
define('BASECIVURL', BASE_URL . 'civ/');


require_once( BASECIVDIR . 'classes/class.game.php');

class game extends  masterclass  {


    private $game;

    function __construct($className = '')
    {
        parent::__construct($className = '');
        $id = (int)$this->id;
        $this->game = new \myciv\game($id);
    }

    function getTables() {
        return [
            'game' => [
                'fields' => [
                    'data' => [ DB_ARRAY, WIDGET_ARRAY]
                ]
            ]
        ];
    }

    public function getGame() {
        return $this->game;
    }

    function extend()
    {
        //$this->ajax = true;
        $this->description = 'Main game class that loads game';
    }

    function menu() { $this->output = tpl('game/menu');}


    
    function minimap() {
        $this->game->getGameClass('map')->minimap($this->get); die();
    }
    
    // Call game api
    function api() {
        echo json_encode($this->game->api($this->request));
        die();
    }

    /*
     * Create game and redirect on save; later here will be select from players, game settings, etc.
     * 4 ways to create game: random map, load map, load images, load scenario. Scenario and map has already ruleset,
     * We can unite load images and random map. No image -> randomize. Images: terrain, river, start location.
     */
    function create() { 
        // process post requests
        if(!empty($this->post['form'])) {
            $data = $this->game->create($this->post['form']); print_r($data); die();
            $this->saveDB(['data' => serialize($data)]);
            $this->cache($data);

            $url = BASE_URL . $this->cl . '/play/' . $this->id;
            $this->output = json_encode(array('redirect' => $url, 'status' => 'ok', 'timeout' => 1));
            return;
        }
        // else show template
        $rulesets = q('rulesets')->qlist('name')->run();
        $options = [];
        foreach($rulesets as $ruleset) {
            $rulesetname = $ruleset['name'];
            $options[$rulesetname] = $rulesetname;
        }
        $this->output = tpl('game/create', ['rulesets' => $options, 'maps' => getMaps()]);
    }

    

    function load() {
        $games = q($this->cl)->qlist('id')->run();
        $this->output = tpl('game/load', ['games' => $games]);
    }

    /*
     * Playing game
     */
    function play() {
        // load id for multiplayer game
       /* $id = $this->id;
        $gamedata = cache('game/game_' . $this->id);
        $map = new map();
        $map->setRuleset($gamedata['ruleset']);
        $map->setMap($gamedata['map']);
        $map->setGame($id);

        $this->output = $map->render();*/
        $this->output = $this->game->play($this->id);
    }

    function cache($data = [], $cl = '') {
        $cachepath = BASE_PATH . 'data/cache/' . $this->className;
        if(!file_exists($cachepath)) mkdir($cachepath, 0777, true);

        $name = $this->className . 's/game_' .$this->id;
        cache($name, $data);
    }

    function parse() {
        return $this->output;
    }
    
}

function getMaps() {
    $ret = [];
    $maps = fm()->dscan(BASE_PATH . 'civ/maps');
    foreach($maps as $map) {
        $name = basename($map['name'], ".php");
        $ret[$name] = $name;
    }
    return $ret;
}




function gtpl($_TPL, $vars=array()){
    $_url = BASECIVDIR . 'gametpl/' . $_TPL . '.tpl.php';
    if($_url){
        foreach ($vars as $k =>$v){
            if(!is_array($v) && !is_object($v))
                $$k=html_entity_decode(stripslashes($v));
            else
                $$k=$v;
        }

        ob_start();
        include($_url);
        $tpl = ob_get_contents();
        ob_end_clean();
    }

    return $tpl;
}