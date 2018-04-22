<?php echo
drawForm([
    'fields' => [                    
        'religion' => [DB_ARRAY, WIDGET_TABLE,
            'children' => [                                
                'img' => [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/misc', 'thumb' =>1 , 'thumbsize' => 50],
                'name' => [DB_STRING, WIDGET_TEXT],
                'gov' => [DB_STRING, WIDGET_TEXT],   
                'title' => [DB_STRING, WIDGET_TEXT],
                'templename' => [DB_STRING, WIDGET_TEXT],                
                'templepic' => [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/misc', 'thumb' =>1 , 'thumbsize' => 50],
            ]
        ],        
    ],
    'plain' => false,
    'table' => true,
    'data' => $data,
    'prefix' => 'form[data]'
]); ?>