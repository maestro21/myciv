<?php echo
drawForm([
    'fields' => [                    
        'goodies' => [DB_ARRAY, WIDGET_TABLE,
            'children' => [
                'name' => [DB_STRING, WIDGET_TEXT],
                'img' => [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/goodies', 'thumb' =>1 , 'thumbsize' => 50],
                'char' => [DB_CHAR, WIDGET_CHAR],
                'terrain' => [DB_TEXT, WIDGET_TEXT, 'class' => 'small'],
            ]
        ],        
    ],
    'plain' => false,
    'table' => true,
    'data' => $data,
    'prefix' => 'form[data]'
]); ?>