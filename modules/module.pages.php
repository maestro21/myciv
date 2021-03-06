<?php class pages extends masterclass {

	function gettables() {
		return 
		[
			'pages' => [
				'fields' => [					
					'pid'			=>	[ 'int', 'select', 'default' => 0, 'null' => false],					
					//'lang'			=>  [ NULL, 'select' ],
					'name' 			=> 	[ 'string', 'text', 'search' => TRUE ],
					'url'			=>	[ 'string',	'text' ],
					'fullurl'		=>  [ 'string', 'info' ],
					'type'			=>	[ 'int', 'select' ],					
					'content' 		=> 	[ 'blob', 'html', 'search' => TRUE ],
					'status'		=>	[ 'int', 'select' ],						
				],
			],
		];		
	}
	
	function extend() {
		$this->description = 'Core module for creating website pages';
		$this->defmethod = 'view';
		
		$this->options = [
			'pid' => $this->getPidOptions(),
			'status' => [
				0 => 'hidden',
				1 => 'visible',
				2 => 'in_menu',
			],
			'type' => [
				1 => 'page',
				2 => 'redirect',
                3 => 'replace',
			],
		];
		
	}
	
	function install() { 
		parent :: install();		
		include('data/default.pages.php'); 
		foreach($pages as $page) {
			q($this)->qadd($page)->run();
		}
	}
	
	function validate() {
		
		
	}
	
	
	function del($id = NULL) {
		$ret = parent::del($id = NULL);
		$this->cache();
		return $ret;
	}
	
	function save() {
		$this->parse = FALSE; 
		$form = $this->post['form'];
		$form['fullurl'] = $this->getFullUrl($form['pid'], $form['url']);		
		$ret = parent :: saveDB($form);
		$this->cache();
		return json_encode($ret);
	}
	
	function getPageTree($options = null) {	
		$q = q()	->select('id, pid, name, url, fullurl')
					->from($this->className)
					->order('pid ASC, id ASC');
		if(@$options['id'] > 0) {
			$q->where('id != ' . $options['id']);	
		}
		if(@$options['status']) {
			$q->where('status >= ' . $options['status']);	
		}	
		$tree = $q->run(); 
		$T = new tree($tree);
		return $T;
	}
		
	function  cache($data = [], $cl = '') {
		
		$T = $this->getPageTree([ 'status' => 1]);
		cache($this->className, $T->treeList);
		
		$T = $this->getPageTree([ 'status' => 2]);
		cache('menu', $T->treeList);
		
		$T = $this->getPageTree();
		cache($this->className . 'options', $T->options);
	}	
	
	function getPidOptions() {
		if($this->method == 'edit') {
			$T = $this->getPageTree([ 'id' => (int)$this->id ]);
			return $T->options;		
		}
		return cache($this->className . 'options');
	}
	
	function getFullUrl($id, $url) {
		if($id > 0) {
			$T = $this->getPageTree();
			$ret = array_reverse($T->getFullUrl($id));
			$ret[] = $url;
			$ret = implode('/', $ret);
		} else {
			$ret = $url;
		}
		return $ret;
	}
	
	function admin() {
		$T = $this->getPageTree();
		$ret = $T->drawTree($this->className . '/adm');
		return $ret;
	}
	
				
	function menu($tpl = 'menu'){
		$this->parse = false;
		$tree = cache('menu');
		foreach($tree as $lang => $topmenu) {
			if($topmenu['url'] == getLang()) {
				$homeButton = [
					'fullurl' => $topmenu['url'],
					'name' => '',
					'class' => 'fa fa-home',
				];
				$leafs = array_merge([$homeButton], $topmenu['children']);
				$T = new tree();
				$ret = $T->drawTree($this->className . '/' . $tpl, $leafs);
				return $ret;
			}
		}
		return FALSE;
	}	
	
	function getSubMenu($id = 0) {
		$submenu = q()	->select('id, pid, name, url, fullurl')
						->from($this->className)
						->where(qeq('pid',$id))
						->where('status > 0 ')
					->run();
		return $submenu;			
	}
	
	function view($id = NULL) {
		$path = $this->path;
		$url  = implode('/', $this->path);
		$page = q()	->select()
					->from($this->className)
					->where("fullurl='$url'")
					->run();
					
		/* if empty url then get top page of default language */			
		if(empty($page)) {
			$page = q()	
				->select()
				->from($this->className)
				->where(qEq('fullurl',getLang()))
				->run();
		}
		// error page
		if(!isset($page[0])) {
			return $this->notFound();
		}

		$page = $page[0];
		$this->title = $page['name'];
		
		// strahovki specific
		if(count($path) > 2) { 
			$page['subpages'] = $this->getSubMenu($page['pid']); //print_r($subpages);
			$pname = q()	
						->select('name')
						->from($this->className)
						->where(qeq('id',$page['pid']))
					->run();
			$page['name'] = $pname[0][0];
		}		
		
		if($page['type'] == 2) redirect(strip_tags($page['content']), 0, true);
        if($page['type'] == 3) { $page['content'] = file_get_contents(strip_tags($page['content']));}
		return $page;	
	}
	
	function notFound() {
		return array(
			'name' => T('404 page not found'),
			'content' => '',
		);		
	}
	
}