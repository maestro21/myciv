<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class
 *
 * @author MAECTPO
 */
abstract class cachemasterclass extends masterclass {


    /**
     * Disabling table install-uninstall
     */
    public function install(){}
    public function uninstall(){}

    function __construct($className = '')
    {
        parent::__construct($className);
    }

    /*
     * Autoincrement
     * @var int
     */
    public $ai = 0;

    /**
     * Define if we want to cache data as json
     * @var bool
     */
    public $json = false;

    /**
     * Cache path
     */
    public $cachepath = 'data/cache/';


    /**
		Default method for class data listing
		@return array() or FALSE;
	**/
  	public function items() {
		return $this->cache();
  	}
    
    /** Save element **/
    public function save() {
		$this->parse = FALSE;
        $data = $this->cache();
        if($this->id < 1) {
            $this->ai++;
            $this->id = $this->ai;
        }
        $this->saveFiles();
        $data[$this->id] = $this->post['form'];
        $this->cache($data);
        $ret = array('redirect' => BASE_URL . $this->cl . '/edit/' . $this->id, 'id' => $this->id, 'status' => 'ok', 'message' => 'saved');
		return json_encode($ret);
	}
    
   /** Retrieves data of a single element for edit **/
    public function edit($id = NULL) { 		
		return $this->add($this->view($id));
    }	
	
	/** Retrieves data of a single element for view **/
    public function view($id = NULL) {
		if(NULL == $id) $id = $this->id;
		$data = $this->cache();
        return $data[$id];
    }  
    
    /* Opens form for adding new element **/
	public function add($data = NULL) {
		$this->tpl = 'addedit';
		return array('data' => $data, 'fields' =>$this->fields, 'options'=> $this->options);
	}
    
    /** Delete element **/
    public function del($id = NULL) {
		if(NULL == $id) $id = $this->id;
		$data = $this->cache();
        unset($data[$id]); 
        $this->cache($data);
		$this->parse = FALSE; 
		return json_encode(array('redirect' => 'self', 'status' => 'ok', 'timeout' => 1));
    }

    
    public function clear($cl = '') {
        if(empty($cl)) $cl = $this->cl;
        $cp = @$this->get['cp'];
        $json = @$this->get['json'];
        cacherm($cl, $json, $cp); 
        $this->parse = FALSE; 
        redirect(BASE_URL . $cl .'/admin');
    }
    
    public function cache($data = array(), $cl = '') {
        if(empty($cl)) $cl = $this->cl;
        // save
		if(!empty($data)) {
            $data = [
                'ai' => $this->ai,
                'data' => $data,
            ];
            cache($cl, $data, $this->json, $this->cachepath);
        }
        // load
        $data =  cache($cl, null, $this->json, $this->cachepath);
        if(!isset($data['ai'])) {
            $data = [
                'ai' => max(array_keys($data)),
                'data' => $data,
            ];
            cache($cl, $data, $this->json, $this->cachepath);
        }
        $this->ai = (int)@$data['ai'];
        return @$data['data'];
	}   
}


// Main cache class that stores cached data
class cache {
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
    
    
    public $json = false;
    
    private $cache = [];
   
    public function get($key) {
        if(!isset($this->cache[$key])) {
            $name = pathinfo($key)['filename'];
            $filename = BASE_PATH . $key;
            if(!file_exists($filename)) return [];
            if($this->json($key)) {
                $data = json_decode(file_get_contents($filename), true);                
            } else {
                include($filename);
                $data = $$name;
            }
            //if(isset($data['data'])) $data = $data['data'];
            $this->cache[$key] = $data;
        }
        return $this->cache[$key];
    }
    
    public function set($key, $data) {
        $this->cache[$key] = $data;
        $filename = BASE_PATH . $key;
        $name = pathinfo($key)['filename'];
        $dir = dirname($filename); 
        if(!file_exists($dir)) mkdir($dir, 0777,true);
        if($this->json($key)) {            
            file_put_contents($filename, json_encode($data));
        } else {
            file_put_contents($filename, '<?php $' . $name .' = ' . var_export($data, TRUE) . ";" ) ;
        }
    }
    
    public function json($key) {
        return (strpos($key, '.json') !== false);
    }
    
    public function del($key) {
        unset($this->cache[$key]);
        $filename = BASE_PATH . $key; echo $filename;
        if(file_exists($filename)) {
            unlink($filename);
        }
    }
    
}



/** Cache getter\setter **/
function cache($name, $data = NULL, $json = false, $cachepath = 'data/cache/', $returndata = true) {
	$key =  $cachepath . $name . ($json ? '.json' : '.php');
    $cache = cache::getInstance();
	if(NULL !== $data) {
        $cache->set($key, $data);
	}
    $data = $cache->get($key);
    if(isset($data['data']) && $returndata) $data= $data['data'];
    return $data;
}


/** Clears cache **/
function cacherm($name, $json = false, $cachepath = 'data/cache/') {
    $key =  $cachepath . $name . ($json ? '.json' : '.php');
	cache::getInstance()->del($key);
}
