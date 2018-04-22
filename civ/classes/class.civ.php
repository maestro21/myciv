<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace myciv;

/**
 * Description of class
 *
 * @author MAECTPO
 */
class civ {
    
    
    // civilizations
    private $civs = array();
    public function getCivs(){
        if(empty($this->civs)) {
            $this->civs = cache('civilizations');
        }
        return $this->civs;
    }
    public function getCiv($key) {
        if(empty($this->civs)) {
            $this->civs = cache('civilizations');
        }
        if(isset($this->civs[$key])) {
            return $this->civs[$key];
        }
        return NULL;
    }
    
    private $gov = NULL;
    public function getGov($id = NULL) {
        if($this->gov == null) {
            $this->gov = cache('gov');
        }
        if($id != null) return $this->gov[$id];
        return $this->gov;
    }
    
    public function getCountry($player, $prop = null) {
        $civ = $this->getCiv($player['civ']);
        $rel = B()->getReligion($player['religion']);
        $country_id = $player['country'];
        $country = $civ['countries'][$country_id]; 
        $country['name'] = $this->getCountryName($country, $civ, $rel);
        $country['title'] = $this->getCountryTitle($country, $rel);
        if($prop != null) return $country[$prop];
        return $country;        
    }
    
    function getCountryName($country, $civ, $rel = ['gov' =>'{rel}']) {
        if(empty($country['name'])) $country['name'] = $this->getGov($country['government'])['countryname'];
        $search = [ '{adj}', '{name}', '{rel}', '{countryname}'];
        $replace = [ $civ['adjective'], $civ['name'], $rel['gov'], $civ['countryname']];
        $country['name'] = str_replace($search, $replace, $country['name']);
        return $country['name'];
    }
    
    function getCountryTitle($country, $rel = false) {
        if(empty($country['title'])) $country['title'] = $this->getGov($country['government'])['title'];
        if($rel) $country['title'] = str_replace('{rel}',  $rel['title'], $country['name']);
        return $country['title'];
    }
    
     function processApiRequest($data) {
        $allowedApiMethods = [ 'countrylist' ];
        if(in_array($data['do'], $allowedApiMethods)) {
            return $this->{$data['do']}($data);
        }
        return FALSE;
    }
    
    function countrylist($data) {
        $civs = $this->getCivs();
        $_countries = [];
        foreach($civs as $k => $civ) {
            $_countries[$k] = [];
            foreach($civ['countries'] as $kk => $country) {
                $_countries[$k][$kk] = [
                    'gov'   => $country['government'],
                    'name'  => $this->getCountryName($country, $civ),
                    'title' => $this->getCountryTitle($country), 
                    'flag'  => $country['flag'],
                    'ruler' => $country['rulers'],
                ];
            }
        }
        cache('countries', $_countries);
    }    
    
    public function getCivByPlayerId($id) {
        return $this->getCiv(players()->getPlayer($id,'civ'));
    }

    public function getCivByName($name, $key = false) {
        foreach($this->civs as $k => $civ) {
            if($civ['name'] == $name) {
                if($key) {
                    return $k;
                }
                return $civ;
            }
        }
        return -1;
    }
}
