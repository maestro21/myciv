<?php
/**
 * Ruleset is set of rules including units, tech, cities, graphics, governments, countries,
 * etc, that can be later used in games. Full list of rules:
 *  units - gfx + params
 *  tech
 *  government
 *  civs
 *  countries
 *  cities
 *  icons
 *  terrain
 */
class rulesets extends masterclass  {

    function getTables() {
        return
            [
                'rulesets' => [
                    'fields' => [
                        'name' 			=> 	[ 'string', 'slug', 'search' => TRUE ],
                        'data'			=>	[ 'blob',	'array', 'table' => FALSE ]
                    ],
                ],
            ];
    }

    function extend()
    {
        $this->description = 'Ruleset is set of rules including units, tech, cities, graphics, governments, countries,
         etc, that can be later used in games';

        $this->fileNamePolicy = array(
            '/^(form-data-resources.*)/' => [
                $this->cl . '/{id}/res_{time}{uid}.{ext}',
                'thumb' => FALSE,
                'imgsize' => [32,32],
            ]
        );
    }

    function save() {
        //print_r($this->post['form']);
        $ret = parent::save();
        $this->cache();
        return $ret;
    }

    function  cache($data = [], $cl = '') {
        // Data processing
        $name = $this->post['form']['name'];
        $data = $this->post['form']['data'];
        //

        // processing terrain
        $tmp = [];
        foreach($data['terrain'] as $row) {
            $tmp[$row['char']] = $row;
        }
        $data['terrain'] = $tmp;
        
        // processing goodies
        $tmp = [];
        foreach($data['goodies'] as $row) {
            $tmp[$row['char']] = $row;
        }
        $data['goodies'] = $tmp;

        // processing ages
        $tmp = [];
        foreach($data['ages'] as $row) {
            $tmp[] = $row['name'];
        }
        $data['ages'] = $tmp;

        // processing terrain
        $tmp = [];
        foreach($data['players'] as $row) {
            $tmp[] = $row['color'];
        }
        $data['players'] = $tmp;

        // processing resources
        if(isset($data['resources'])) {
            $tmp = [];
            foreach($data['resources'] as $row) {
                $tmp[$row['name']] = $row['img'];
            }
            $data['resources'] = $tmp;
        }
        // processing cities
        /*foreach($data['cities'] as $culture => $ages) {
            foreach($ages as $age => $img) {
                if(!empty($img)) {
                    $_name = 'city_' . $age . '_' . $culture;
                    $_data = [
                        'name' => $_name, 
                        'img' => $img
                    ];
                    saveAtlas($_data, 'rulesets/' . $name . '/' . $_name);
                }
            }
        }*/

        //
        // preparing file path
        $cachepath = BASE_PATH . 'data/cache/' . $this->className;
        if(!file_exists($cachepath)) mkdir($cachepath, 0777, true);
        $name = $this->className . '/' . $this->post['form']['name'];

        // save
        cache($name, $data);
    }
}