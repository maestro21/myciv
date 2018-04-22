<?php class cultures extends masterclass {

	function gettables() {
		return [
			'cultures' => [
				'fields' => [
					'name' 		=> [ 'string', 'text', ],
					'core'	=> [ 'bool', 'checkbox', ]
				],
            ]
		];	
	}
	

	
	function set($key, $value) {
		$this->id = q($this)->select('id')->where(qEq('name',$key))->run(MySQL::DBCELL);
		$this->saveDB(array('name' => $key, 'value' => $value));
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
	
	function extend() {
		$this->description = 'List of CIV cultures';
	}

	
}