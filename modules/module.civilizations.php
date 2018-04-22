<?php class civilizations extends cachemasterclass {

	function gettables() {
		return [
			'civilizations' => [
                'cache' => true,
				'fields' => [
					'name' 		=> [ DB_STRING, WIDGET_TEXT ],
                    'adjective'	=> [ DB_STRING, WIDGET_TEXT ],
                    'countryname'=> [ DB_STRING, WIDGET_TEXT ],
					'culture'	=> [ DB_STRING, WIDGET_TEXT ], //'select', 'options' => Glist('cultures') ],
                    'flag'  => [DB_TEXT,WIDGET_SELECTFILE, 'src' => 'galleries/flags','thumb' => 1, 'thumbsize' => 60],
                    'description' => [ 'text', 'html', 'table' => FALSE],
                    'civs_friendly' => [ DB_TEXT, WIDGET_TEXT,],
                    'civs_hostile' => [ DB_TEXT, WIDGET_TEXT, ],
                    'civs_collapse'  => [ DB_TEXT, WIDGET_TEXT,],
                    'countries' => [DB_ARRAY, WIDGET_TABLE,
                        'table' => FALSE,
                        'children' => [
                            'government' =>  [DB_INT, WIDGET_SELECT, 'options' => cache('govlist')],
                            'name' => [DB_STRING, WIDGET_TEXT],
                            'flag' => [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/flags','thumb' => 1, 'thumbsize' => 60],
                            'title' => [DB_STRING, WIDGET_TEXT],
                            'rulers' => [DB_STRING, WIDGET_TEXT],
                            'cities' => [DB_TEXT, WIDGET_LIST],                            
                            'nation' => [DB_STRING, WIDGET_TEXT],
                        ]
                    ],
                    'cities'    => [ DB_BLOB, 'textarea','table' => FALSE ]
				],
            ]
		];	
	}


	function cache($data = null, $cl='') {
        if($data != null) {
            $_data = array();
            foreach($data as $k => $v) {
                $_data[$k] = $v['name'];
            }            
            cache('civilizations', $data);            
            cache('civlist', $_data);
            file_get_contents(BASE_URL . 'game/api?class=civ&do=countrylist');
        }
        return parent::cache($data, $cl);
    }

	function set($key, $value) {
		$this->id = q($this)->select('id')->where(qEq('name',$key))->run(MySQL::DBCELL);
		$this->saveDB(array('name' => $key, 'value' => $value));
		$this->cache();	
	}
	
    /*
	function save() {
		$ret = parent:: save();
		$this->cache();
		return $ret;		
	}
	
	function delete() {
		parent::delete();
		$this->cache();	
	} */
	
	function extend() {
		$this->description = 'List of MyCiv Civilizations';
	}

	
}