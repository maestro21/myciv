<?php
class cachetest extends cachemasterclass
{

    function gettables()
    {
        return [
            'cachetest' => [
                'cache' => true,
                'fields' => [
                    'data' 	    => [ DB_STRING, WIDGET_TEXT ],
                ],
            ]
        ];
    }

    function extend()
    {

        $this->description = 'Cachetest';
        $this->cachepath = 'data/cachetest/';
        $this->json = true;
        
        $this->buttons['admin'] = [
            'add' => 'fa-plus',
            'clear?json=true&cp=' . $this->cachepath => 'fa-trash-o',
        ];
    }


}