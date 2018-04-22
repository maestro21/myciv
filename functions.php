<?php 

function saveAtlas($data, $path) {
    M('game')->getGame()->getGameClass('atlas')->getAtlas($data, $path);
}



function createCSSAnimation($key, $data) {
    // add to animation list
    $animations = cache('cssanimation');
    if(NULL === $animations) $animations = [];
    $animations[$key] = $data;
    cache('cssanimation', $animations);
    // create css file
    $css = '';
    foreach($animations as $key => $data){
        $rows = (int)$data['rows']; if($rows < 1) $rows = 1;
        $framesize = ceil($data['height'] / $rows);
        $steps = ceil($data['width'] / $framesize);
        for($i = 1; $i <= $rows; $i++) {
            $posy = ($i - 1) * $framesize;
            $_key = $key . '_' . $i;
            $css .= '@keyframes ' . $_key . ' {' . PHP_EOL;
            $css .= '   from { background-position: 0px -' . $posy . 'px;  }' . PHP_EOL;
            $css .= '   to { background-position: -' . $data['width'] . 'px -' . $posy . 'px; }' . PHP_EOL;
            $css .= '}' . PHP_EOL . PHP_EOL;
            $css .= '.anim-' . $_key . ' {' . PHP_EOL;
            $css .= '   background: url(' . $data['fname'] . ') no-repeat;' . PHP_EOL;
            $css .= '   width: ' . $framesize . 'px;' . PHP_EOL;
            $css .= '   height: ' . $framesize . 'px;' . PHP_EOL;
            $css .= '   animation: ' . $_key . ' .8s steps(' . $steps . ') infinite;' . PHP_EOL;
            $css .= '}' . PHP_EOL . PHP_EOL . PHP_EOL;
        }
    }
    file_put_contents(BASE_PATH . 'front/animation.css', $css);
}
