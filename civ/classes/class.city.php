<?php
namespace myciv;

class city {



    public $cities = NULL;


    function __construct()
    {
        $this->getCities();
    }

    public function addCityData($city) {
        $player = players()->getPlayer($city['owner']);
        $city['style'] = $player['age'] . '_' . $player['culture'];
        if(empty($city['name'])) $city['name'] = 'Roma'; //TODO: replace with nation specific
        return $city;
    }

    public function getCity($x,$y) {
        if(!isset($this->cities[$x . '_' . $y])) return NULL;
        $city = $this->cities[$x . '_' . $y];
        $city = $this->addCityData($city);
        return $city;
    }
    public function setCity($x,$y,$city) {
        $this->cities[$x . '_' . $y] = $city;
        $this->cities[$x . '_' . $y] = $this->getCity($x,$y);
        $this->setCities();
    }
    public function getCities() {
        $this->cities = B()->get('cities');
        return $this->cities;
    }
    public function setCities($cities = null) {
        if($cities) $this->cities = $cities;
        B()->set('cities', $this->cities);
        B()->save();
    }
    public function unsetCity($x,$y) {
        unset($this->cities[$x . '_' . $y]);
        $this->setCities();
    }

    public function build($x, $y, $player_id) {
        $city = [
            'owner' => $player_id,
            'pop' => 1,
        ];
        $city = $this->addCityData($city);
        $this->setCity($x,$y,$city);
        return $city;
    }

    public function getCityStyle($ownerid) {

    }

    function processApiRequest($data) {
        $allowedApiMethods = ['postCity'];
        if(in_array($data['do'], $allowedApiMethods)) {
            return $this->{$data['do']}($data);
        }
        return FALSE;
    }

    function postCity($data){
        switch($data['data']['action']) {
            case 'del':  $this->unsetCity($data['x'], $data['y']); break;

            case 'put': $this->build($data['x'], $data['y'], $data['data']['player']); break;

            default: $this->setCity($data['x'], $data['y'], $data['form']);break;
        }
    }
}