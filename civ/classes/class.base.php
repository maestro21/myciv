<?php namespace myciv;
class base {
       
    /* Singleton pattern */
    private static $_instance = null;
    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

    static public function getInstance() {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /* thats it */
    
       
    /**
     * CLASSES
     */
    private $classes = array();
    public function getClass($class) {
        if(!isset($this->classes[$class])) {
            if(file_exists(BASECIVDIR . 'classes/class.'.$class.'.php')) {
                require_once(BASECIVDIR . 'classes/class.'.$class.'.php');
                $_class = '\\myciv\\' . $class;
                $this->classes[$class] = new $_class();
            }
        }
        if(isset($this->classes[$class])) {
            return $this->classes[$class];
        }
        return NULL;
    }
    
        
    /**
     * Main function to load game
     * @param $id -game id
     */
    function loadGameData($id = NULL) {
        $id = (int)$id;
        if($id == 0) return FALSE;
        $gameData = cache('games/game_' . $id);
        if(!$gameData) return FALSE;

        $this->setGid($id);
        $this->setGameData($gameData);
        $this->setRuleset($gameData['ruleset']);
        return $gameData;
    }

    function saveGameData() {
        cache('games/game_' . $this->getGid(),$this->getGameData());
    }
    // alias for saveGameData()
    function save() {
        $this->saveGameData();
    }
       
    /**
     * GAME DATA
     */
    private $gamedata = array();
    public function set($key, $value) {
        $this->gamedata[$key] = $value;
    }
    public function get($key) {
        if(isset($this->gamedata[$key])) {
            return $this->gamedata[$key];
        }
        return NULL;
    }
    public function getGameData() {
        return $this->gamedata;
    }
    public function setGameData($data) {
        $this->gamedata = $data;
    }

    private $gid = 0;
    public function getGid(){
        return $this->gid;
    }
    public function setGid($gid){
        $this->gid = $gid;
    }
    
        
    /**
     * RULES
     */
    private $rules = array();
    public function getRules(){
        return $this->rules;
    }
    public function setRules($rules){
        $this->rules = $rules;
    }
    
    public function getRule($key) {
        if(isset($this->rules[$key])) {
            return $this->rules[$key];
        }
        return NULL;
    }
    public function setRule($key, $value) {
        $this->rules[$key] = $value;
    }
    private $ruleset = NULL;
    public function setRuleset($name) {
        $this->ruleset = $name;
        $this->setRules(cache('rulesets/' . $name));
    }
    public function getRuleset() {
        return $this->ruleset;
    }
    
    public function getAges(){
        return $this->getRule('ages');
    }
    
    public function getAge($age){
        return $this->getRule('ages')[$age];
    }
    
    public function getPlayerColor($id) {
        return $this->getRule('players')[$id];
    }
    
    public function getReligion($id){
        return $this->getRule('religion')[$id];
    }

    
    /**
     * SETTINGS
     */
    private $settings = array();
    public function getSettings(){
        return $this->settings;
    }
    public function setSettings($settings){
        $this->settings = $settings;
    }
    public function getSetting($key) {
        if(isset($this->settings[$key])) {
            return $this->settings[$key];
        }
        return NULL;
    }
    public function setSetting($key, $value) {
        $this->settings[$key] = $value;
    }
    
}


function B() {
    return base::getInstance();
}

function GM($class) {
    return B()->getClass($class);
}
function GSet($key, $value) {
    B()->set($key, $value);
}
function GGet($key) {
    return B()->get($key);
}

function Gload($id = 0){
    B()->loadGameData($id);
}

function map() { return GM('map'); }
function units() { return GM('units'); }
function cities() { return GM('city'); }
function civ() { return GM('civ'); }
function players() { return GM('players'); }