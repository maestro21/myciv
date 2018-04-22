<?php
namespace myciv;

class atlas {
    function processApiRequest($data) {
        $allowedApiMethods = ['getAtlas'];
        if(in_array($data['do'], $allowedApiMethods)) {
            return $this->{$data['do']}($data);
        }
        return FALSE;
    }
    
    
    function getAtlas($data,$cachepath = NULL) {
        $data['id'] = explode('_',$data['name']);
        $what = $data['id'][0];
        $atlas = []; 
        switch($what) {
            case 'city':
                $atlas = $this->getAtlasCity($data);
            break;
            
        }
        if($cachepath) { 
            cache($cachepath,$atlas, true); 
            return $atlas;
        }
        return json_encode($atlas);
    }
    
    function getAtlasCity($data) {
        $tileSize = 150;
        $frames = [];
        $name = $data['name'];
        for($i = 0; $i < 5; $i++) {
            $frames[$data['name'] . '_' . $i] = $this->addFrameInfo($i,0, $tileSize);
            $frames[$data['name'] . '_walled_' . $i] = $this->addFrameInfo($i,1, $tileSize);
        }        
        $meta = $this->addMetaImg($data['img'], $tileSize, $tileSize);
        return [ 'frames' => $frames, 'meta' => $meta ];
    }
    
    function addMetaImg($img) {
        list($width, $height) = getimagesize($img);
        $img = str_replace(BASE_URL, '', $img);
        return [
            "app" => "http://www.codeandweb.com/texturepacker",
            "version" => "1.0",
            "image" => $img,
            "format"=> "RGBA8888",
            "size" => ["w" => $width,"h" => $height],
            "scale" => "1",
            "smartupdate" => '$TexturePacker:SmartUpdate:cd0d17d3f8965456a92be15158a0ed9e:d14942d54a3d3385fdb15258e1ae1a8f:cbce6b53f0f49e0bf15173c25c41f876$'
        ];
    }
    
    function addFrameInfo($x,$y, $tileSize) {
        $x = $x * $tileSize;
        $y = $y * $tileSize;
        return [
            "frame" =>  ["x" => $x, "y" => $y,"w" => $tileSize, "h" => $tileSize ],
			"rotated" => false,
			"trimmed" => false,
			"spriteSourceSize" => [ "x" => 0,"y" => 0,"w" => $tileSize,"h" => $tileSize],
			"sourceSize" => ["w" => $tileSize,"h" => $tileSize],
			"pivot" => ["x" => 0.5,"y" =>0.5]
        ];
    }

}