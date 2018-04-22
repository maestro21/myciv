<?php
/**
 * Created by PhpStorm.
 * User: adiacom NUC1
 * Date: 10/18/2017
 * Time: 4:36 PM
 */

namespace myciv;


class units
{
  
    
    
    function __construct()
    {
        $this->getUnitGallery();        
        $this->getRulesetUnits();
        $this->getUnits();
    }
    
    public $unitGallery = null;
    /* unit gallery */
    function getUnitGallery()
    {
        if($this->unitGallery == NULL) {
            $this->unitGallery = cache('units');
            if(isset($this->unitGallery['data'])) $this->unitGallery = $this->unitGallery['data'];
        }
        return $this->unitGallery;
    }
    
    function getUnitFromGallery($id,$param = null) {
        if(!isset($this->unitGallery[$id])) return FALSE;
        if($param != null) return @$this->unitGallery[$id][$param];
        return $this->unitGallery[$id];
    }
    
    /* ruleset units */
    
    public $rulesetUnits = NULL;

    function getRulesetUnits()
    {
        if($this->rulesetUnits == NULL) {
            $this->rulesetUnits = B()->getRule('units');
        }
        return $this->rulesetUnits;
    }
    function getRulesetUnit($id,$param = null) {
        if(!isset($this->rulesetUnits[$id])) return NULL;
        if($param != null) return @$this->rulesetUnits[$id][$param];
        return $this->rulesetUnits[$id];
    }

    function addRulesetUnit($data) {
        $id = $data['id'];
        $units = cache('units');
        $this->rulesetUnits[] = $units[$id];
        $this->saveRulesetUnits();
    }

    function saveRulesetUnits() {
        B()->setRule('units', $this->rulesetUnits);
        B()->save();
    }


    /* game units */
    
    public $units = NULL;
    
    public function getUnit($x,$y) {
        if(!isset($this->units[$x . '_' . $y])) return NULL;
        $unit = $this->units[$x . '_' . $y];
        $unit = $this->addUnitData($unit);
        return $unit;
    }
    public function setUnit($x,$y,$unit) {
        $this->units[$x . '_' . $y] = $unit;
        $this->units[$x . '_' . $y] = $this->getUnit($x,$y);
        $this->setUnits();
    }
    public function getUnits() {
        $this->units = B()->get('units');
        return $this->units;
    }
    public function setUnits($units = null) {
        if($units) $this->units = $units;
        B()->set('units', $this->units);
        B()->save();
    }
    public function unsetUnit($x,$y) {
        unset($this->units[$x . '_' . $y]);
        $this->setUnits();
    }
    
    public function addUnitData($unit){        
        if(!isset($unit['owner'])) $unit['owner'] = 0;
        if(!isset($unit['id'])) $unit['id'] = 0;
        $unit['uid'] = $this->getRulesetUnit($unit['id']);
        $unit['gfx'] = $this->getUnitFromGallery($unit['uid'], 'img');
        $unit['amount'] = $this->getUnitFromGallery($unit['uid'], 'amount');
        $unit['hp'] = 10;  
        return $unit;
    }
    
    public function putUnit($data){
        if($data['data'] == 'del') return $this->unsetUnit($data['x'],$data['y']);
        $this->setUnit($data['x'],$data['y'],$data['data']);
    }

    public function moveUnit($params) {
        $data = $params['data'];
        $x = $params['x'];
        $y = $params['y'];
        $direction =  $data['direction'];
        $tile = map()->getNeightbourTile($params['x'],$params['y'], $direction);
        $animation = map()->getDirection($direction);
        $animation['row'] = $this->getUnitAnimationRowByDirection($direction);
        $move = true;
        // here we do checks
        if($tile['unit']) {
            $fight = $this->fight();
        } 
        if($move) {
            $unit = $this->getUnit($x,$y);
          //  $this->setUnit($tile['x'],$tile['y'], $unit);
           // $this->unsetUnit($x,$y);

            $ret = [
                'status' => 'ok',
                'movedto' => [
                    'x' => $tile['x'],
                    'y' => $tile['y']
                ],
                'animation' => $animation
            ];
            $ret['attacker'] = $unit;
            $ret['attacker']['direction'] = $direction;
            $ret['defender'] = $tile['unit'];
            $ret['defender']['direction'] = map()->counterDirection($direction);
            if(isset($fight)) {
                $ret['fight'] = $fight;
            }
            return stripslashes(json_encode($ret));
        }
    }

    
    public function fight() {
        $hp1 = 10;
        $hp2 = 10;
        $hist = [];
        $ret = [];
        while($hp1 > 0 and $hp2 > 0) {
            if(rand(0,1)) {
                $hp1--;
                $hist[] = ['u' => 1, 'hp' => $hp1];
            } else {
                $hp2--;
                $hist[] = ['u' => 2, 'hp' => $hp2];
            }
        }   
        $ret['hist'] = $hist;
        if($hp1 == 0) {
            $ret['won'] = 'defender';
        } else {
            $ret['won'] = 'attacker';
        }
        return $hist;
    }

    public $directions = [NULL, 'bottomleft','bottom', 'bottomright', 'right', 'topright', 'top', 'topleft', 'left' ];

    public function getUnitAnimationRowByDirection($direction) {
        return array_search($direction, $this->directions);
    }

    function processApiRequest($data) {
        $allowedApiMethods = ['putUnit', 'moveUnit'];
        if(in_array($data['do'], $allowedApiMethods)) {
            return $this->{$data['do']}($data);
        }
        return FALSE;
    }
}