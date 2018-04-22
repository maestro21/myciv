<?php
class galleries2 extends cachemasterclass  {


    
    function __construct($className = '')
    {
        parent::__construct($className);
        $this->cache();
    }
    
    function gettables(){
        return
            [
                'galleries2' => [
                    'fields' => [
                        'name'	=> 	[ DB_STRING,    WIDGET_TEXT, 'search' => TRUE, 'required' => TRUE ],
                        'slug'  =>  [ DB_STRING,    WIDGET_SLUG, 'search' => TRUE, 'required' => TRUE ],
                        'settings' => [ DB_ARRAY,    WIDGET_ARRAY,
                            'children' => [
                                'filename'  => [ DB_STRING, WIDGET_TEXT, 'default' => '{slug}/{uid}.{ext}' ],
                                'thumb'     => [ DB_STRING, WIDGET_TEXT, 'default' => '{slug}/thumb_{uid}.{ext}' ],
                                'imgsize'   => [ DB_ARRAY, WIDGET_SIZE ],
                                'thumbsize' => [ DB_ARRAY, WIDGET_SIZE ],
                            ],
                        ],
                        'cover' =>  [ DB_INT,       WIDGET_HIDDEN ],

                    ],
                ],
                'galleries2_images' => [
                    'fields' => [
                        'gid'    => [ DB_INT,    WIDGET_HIDDEN ],
                        'name'   => [ DB_STRING, WIDGET_ARRAY ],
                        'img'    => [ DB_STRING, WIDGET_FILE ],
                    ],
                ],
            ];
    }

    function extend() {
        $this->defmethod = 'admin';
        $this->cachepath = 'data/gfx/';
        $this->description = '2nd Gallery solution without database';
    }

    function admin($id = NULL) {
        if(!empty($this->path[1]) && $this->path[1] != 'admin') {
            return $this->view();
        }
        return parent::admin();
    }
       
    
    function upimg() {
        $gid = $this->post['id'];
        $slug = $this->post['slug'];
        $pol = [
           '{class}' => $this->cl,
           '{slug}' => $slug
       ];
        
        $gals = $this->cache('galleries2');
        $fp[0] = $gals[$gid]['filename'];      print_r($fp);  
        $this->fileNamePolicy = [ '/galnewfile/' => $fp ];
        $this->saveFiles($pol);
           
        $this->cache();
        return json_encode(array('redirect' => 'self', 'status' => 'ok', 'timeout' => 1));
    }
    
}



function img2($gid) { return;
    $gals = cache('galleries2');
    $slug = $gals[$gid]['slug'];
    $img = $imgs[$iid];
    $url = BASE_URL . 'data/gfx/' . $slug . '/' . $img;
    if($echo)
        return " style=\"background-image:url('$url');\"";
    else
        return $url;
}