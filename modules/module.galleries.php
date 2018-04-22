<?php
class galleries extends masterclass  {



    function gettables(){
        return
            [
                'galleries' => [
                    'fields' => [
                        'name'	=> 	[ DB_STRING,    WIDGET_TEXT, 'search' => TRUE, 'required' => TRUE ],
                        'slug'  =>  [ DB_STRING,    WIDGET_SLUG, 'search' => TRUE, 'required' => TRUE ],
                        'settings' => [ DB_ARRAY,    WIDGET_ARRAY,
                            'children' => [
                                'filename'  => [ DB_STRING, WIDGET_TEXT, 'default' => 'gfx/{class}/{slug}/{datetime}_{uid}.{ext}' ],
                                'thumb'     => [ DB_STRING, WIDGET_TEXT, 'default' => 'gfx/{class}/{slug}/thumb_{datetime}_{uid}.{ext}' ],
                                'imgsize'   => [ DB_ARRAY, WIDGET_SIZE ],
                                'thumbsize' => [ DB_ARRAY, WIDGET_SIZE ],
                            ],
                        ],
                        'cover' =>  [ DB_INT,       WIDGET_HIDDEN ],
                        'crdate' => [ DB_DATE ,     WIDGET_HIDDEN ],

                    ],
                ],
                'galleries_images' => [
                    'fields' => [
                        'gal_id'    => [ DB_INT,    WIDGET_HIDDEN, 'index' => TRUE ],
                        'name'      => [ DB_STRING, WIDGET_ARRAY ],
                        'fname'     => [ DB_STRING, WIDGET_FILE ],
                        'crdate'    => [ DB_DATE ,  WIDGET_HIDDEN ],

                    ],
                    'fk' => [
                        'gal_id' => 'galleries(id)'
                    ],
                ],
            ];
    }

    function view($id = NULL) {
        $gal = q($this->cl)->qget($this->id)->run();
        $images = q('galleries_images')->qlist('*', 0, 100)->where(qeq('gal_id', $this->id))->run();
        return [
            'name' => $gal['name'],
            'slug' => $gal['slug'],
            'img' => $images
        ];
    }

    function admin($id = NULL) {
        if(!empty($this->path[1]) && $this->path[1] != 'admin') {
            $this->tpl = 'view';
            $slug = $this->path[1];
            $this->id = q()
                ->select('id')
                ->from($this->className)
                ->where("slug='$slug'")
                ->run(DBCELL);

            return $this->view();
        }

        return parent::admin();
    }

    function extend() {
        $this->perpage = 1000;
        $this->defmethod = 'admin';
    }

    function cache($data = [], $cl = '')  {
        parent::cache();
        $gals = cache('galleries');
        $data = $thumbs = [];
        $_data = q('galleries_images')->qlist()->run();
        foreach($_data as $row) {
            $data[$row['id']] = getImg($row['fname'],$gals[$row['gal_id']]['slug']);
            $thumbs[$row['id']] = getThumb($row['fname'],$gals[$row['gal_id']]['slug'], false);
        }        
		cache('galleries_images', $data);
        cache('galleries_thumbs', $thumbs);
    }
    
    function save() {
        $ret = parent:: save();
        $this->cache();
        return $ret;
    }

    function upimg() {
        $gid = $this->post['id'];
        $slug = $this->post['slug'];


        // gfx/{class}/{slug}/{datetime}_{uid}.{ext}
       $pol = [
           '{class}' => $this->cl,
           '{slug}' => $slug
       ];
		// gfx/{class}/{slug}/{datetime}_{uid}.{ext}
        $gal = q($this->cl)->qget($gid)->run(DBROW);
        $fp = unserialize($gal['settings']);
        $fp[0] = $fp['filename'];
        $this->fileNamePolicy =  [ '/galnewfile/' => $fp ];

        $this->saveFiles($pol);
        //print_r($this->post);
        q('galleries_images')->qadd([
            'name' => pathinfo($this->files['galnewfile']['name'], PATHINFO_FILENAME),
            'gal_id' => $gid,
            'fname' => basename($this->post['galnewfile']['name'])
        ])->run();
        //$this->cache_gal($gid);
        $this->cache();
        return json_encode(array('redirect' => 'self', 'status' => 'ok', 'timeout' => 1));
    }

    function setmainpicture() {
        $gid = $this->path[2];
        $iid = $this->path[3];
        q($this->cl)->qedit(['cover' => $iid],qEq('id',$gid))->run();
    }

    function cache_gal($gid = null) {
        $_res = q('galleries_images')
                    ->qlist('id, fname')
                    ->where(qeq('gal_id', $gid))
                ->run();
        $data = [];
        foreach($_res as $row) {
            $data[$row['id']] = $row['fname'];
        }
		cache('gal_' . $gid, $data);
    }

    /** Delete element **/
    public function delimg($id = NULL) {
        if(NULL == $id) $id = $this->id;
        q('galleries_images')->qdel($id)->run();
        $this->parse = FALSE;
        return json_encode(array('redirect' => 'self', 'status' => 'ok', 'timeout' => 1));
    }
}