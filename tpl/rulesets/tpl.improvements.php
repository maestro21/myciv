<?php echo
drawForm([
    'fields' => [
        'roads' => [DB_ARRAY, WIDGET_TABLE,
            'children' => [
                'name' => [DB_STRING, WIDGET_TEXT],
                'img' => [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/roads','thumb' => 1, 'thumbsize' => 150],
            ]
        ],
        'improvements' => [DB_ARRAY, WIDGET_TABLE,
            'children' => [
                'name' => [DB_STRING, WIDGET_TEXT],
                'img' => [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/improvements','thumb' => 1],
                'layer' => [DB_TEXT, WIDGET_SELECT, 'options' => [
                    'terrain' => 'terrain',
                    'mapobjects' =>  'mapobjects'
                ]]
            ]
        ],
    ],
    'data' => $data,
    'prefix' => 'form[data]'
]); ?>