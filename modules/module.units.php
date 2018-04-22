<?php
class units extends cachemasterclass
{

    function gettables()
    {
        return [
            'units' => [
                'cache' => true,
                'fields' => [
                    'name' 	    => [ DB_STRING, WIDGET_TEXT ],
                    'amount'    => [ DB_INT, WIDGET_SELECT, 'options' => [ 1=>1,2=>2,3=>3,4=>4,6=>6]],
                    'flagfirst' => [ DB_BOOL, WIDGET_CHECKBOX],
                    'img'       => [ DB_STRING, WIDGET_FILE ],
                    'animation' => [DB_STRING, WIDGET_ARRAY, 'children' => [
                        'select'    => [ DB_STRING, WIDGET_FILE, 'animate' => true ],
                        'move'      => [ DB_STRING, WIDGET_FILE, 'animate' => true ],
                        'attack'    => [ DB_STRING, WIDGET_FILE, 'animate' => true  ],
                        'build'     => [ DB_STRING, WIDGET_FILE, 'animate' => true ],
                        'die'       => [ DB_STRING, WIDGET_FILE, 'animate' => true ],
                    ]],
                    'sound' => [DB_ARRAY, WIDGET_ARRAY, 'children' => [
                        'select'    => [ DB_STRING, WIDGET_FILE ],
                        'order'     => [ DB_STRING, WIDGET_FILE ],
                        'attack'    => [ DB_STRING, WIDGET_FILE ],
                        'die'       => [ DB_STRING, WIDGET_FILE ],
                    ]],
                    // sound and animation come later
                ],
            ]
        ];
    }

    function extend()
    {
        $this->description = 'Unit graphics and sound';

        $this->fileNamePolicy = array(
            '/^(form-img)/' => [
                $this->cl . '/{id}/default.{ext}',
                'thumb' => FALSE,
            ],
            '/^(form-animation-select)/' => [
                $this->cl . '/{id}/select.{ext}',
                'thumb' => FALSE,
                'animate' => TRUE,
                'rows' => 1
            ],
            '/^(form-animation-move)/' => [
                $this->cl . '/{id}/move.{ext}',
                'thumb' => FALSE,
                'animate' => TRUE,
                'rows' => 8
            ],
            '/^(form-animation-attack)/' => [
                $this->cl . '/{id}/attack.{ext}',
                'thumb' => FALSE,
                'animate' => TRUE,
                'rows' => 8
            ],
            '/^(form-animation-build)/' => [
                $this->cl . '/{id}/build.{ext}',
                'thumb' => FALSE,
                'animate' => TRUE,
                'rows' => 1
            ],
            
            '/^(form-animation-die)/' => [
                $this->cl . '/{id}/die.{ext}',
                'thumb' => FALSE,
                'animate' => TRUE,
                'rows' => 1
            ],
        );
    }
    
    function items() {
        $ret = parent::items();
        $this->tpl = 'list';
        return $ret;
    }
    

}