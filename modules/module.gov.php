<?php
class gov extends masterclass {
    
     function getTables() {
        return [
            'gov' => [
                'fields' => [
                    'name' => [ DB_TEXT, WIDGET_TEXT],
                    'countryname' => [DB_TEXT, WIDGET_TEXT],
                    'title' => [DB_TEXT, WIDGET_TEXT]
                ]
            ]
        ];
    }
    
    function set($key, $value) {
		parent:: set($key, $value);
		$this->cache();	
	}
	
	function save() {
		$ret = parent:: save();
		$this->cache();
		return $ret;		
	}
	
	function delete() {
		parent::delete();
		$this->cache();	
	}
    
    function  cache($data = [], $cl = '') {
        parent::cache();
        $_data = cache($this->className);
        $data = array();
        foreach($_data as $k => $v) {
            $data[$k] = $v['name'];
        }
        cache('govlist', $data);
    }
    
}
