<?php echo
drawForm([
    'fields' => [
        'resources' => [DB_ARRAY, WIDGET_TABLE,
            'children' => [
                'name' => [DB_STRING, WIDGET_TEXT],
                'img' => [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/res','thumb' => 1, 'thumbsize' => 32],
            ]
        ],
        'food' =>  [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/res','thumb' => 1, 'thumbsize' => 32],
        'prod' =>  [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/res','thumb' => 1, 'thumbsize' => 32],
        'gold' =>  [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/res','thumb' => 1, 'thumbsize' => 32],
        'science' => [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/res','thumb' => 1, 'thumbsize' => 32],
    ],
    'data' => $data,
    'table' => true,
    'prefix' => 'form[data]'
]); ?>