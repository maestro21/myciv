<?php
namespace myciv;

class players {

    var $id = 0;
    var $players = null;
    var $values = [
            'country' => 0,
            'civ' => 0,
            'culture' => 'default',
            'age' => 0,
            'money' => 0,
            'color' => NULL,
            'religion' => 0,
        ];

    function __construct()
    {
        $this->getPlayers();
    }
    
    function processApiRequest($data) {
        $allowedApiMethods = ['savePlayers',];
        if(in_array($data['do'], $allowedApiMethods)) {
            return $this->{$data['do']}($data);
        }
        return FALSE;
    }

    function getPlayers($id = null){
        if(empty($this->players)) {
           $this->players = B()->get('players');    
        }
        if($id !== null) { 
            $id = (int)$id;
            $this->setPlayer($id, $this->players[$id]); 
            return $this->players[$id];            
        }
        return $this->players;
    }
    
    function setPlayers($players = null, $save = true) {
        $this->players = B()->get('players');
        if($players != null) {
            foreach($players as $key => $player) {                
                $this->setPlayer($key, $player);
            }            
            $this->players = $players;
        }
        if($save) {
            B()->set('players', $this->players);
            B()->save();
        }
    }
    
    function savePlayers($post) {
        $data  = $post['form']['players'];
        $this->setPlayers($data);
    }

    function getPlayer($id, $prop = null) {
        $this->id = (int)$id;
        $player = $this->getPlayers($id);         
        $country = civ()->getCountry($player);
        $player['culture'] = $this->getPlayerCivData('culture'); 
        $player['age'] = B()->getAge($player['age']);
        $player['flag'] = $country['flag'];
        $player['title'] = $country['title'];
        if(empty($player['color'])) $player['color'] = B()->getPlayerColor($id); 
        if($prop != null) return $player[$prop];
        return $player;
    }
    
    function setPlayer($id, $player) {
        $_player = [];
        if(isset($this->players[$id])) $_player = $this->players[$id];
        $values = $this->values;
        foreach($values  as $k => $v) {
            if(isset($player[$k])) $values[$k] = $player[$k]; 
            elseif(isset($_player[$k])) $values[$k] = $_player[$k];
            $player['culture'] = $this->getPlayerCivData('culture');
        }
        $this->players[$id] = $values;        
    }

    function getPlayerCivData($val) {
        $civ = civ()->getCiv($this->players[$this->id]['civ']);
        return $civ[$val];
    }

    function delPlayer($id) {
        if(isset($this->players[$id])) {
            unset($this->players[$id]);
        }
        $this->setPlayers();
    }   

}