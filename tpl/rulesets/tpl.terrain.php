<?php echo
drawForm([
    'fields' => [        
        'cursor' =>  [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/misc','thumb' => 1, 'thumbsize' => 150],
        'startlocation' =>  [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/misc','thumb' => 1, 'thumbsize' => 150],
        'water' =>  [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/terrain','thumb' => 1, 'thumbsize' => 150],
        'coast' =>  [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/terrain','thumb' => 1, 'thumbsize' => 150],
        'river' =>  [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/roads','thumb' => 1, 'thumbsize' => 150],
        'terrain' => [DB_ARRAY, WIDGET_TABLE,
            'children' => [
                'name' => [DB_STRING, WIDGET_TEXT],
                'img' => [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/terrain','thumb' => 1, 'thumbsize' => 150],
                'char' => [DB_CHAR, WIDGET_CHAR],
                'goodies'   => [DB_TEXT, WIDGET_TEXT, 'class' => 'small'],
                'subterrains' => [DB_TEXT, WIDGET_TEXT, 'class' => 'small'],
                'needwater' => [DB_INT, WIDGET_CHECKBOX],
                'color' => [DB_COLOR, WIDGET_COLOR, 'class' => 'small'],
            ]
        ],
        'borders' => [DB_ARRAY, WIDGET_ARRAY,
            'children' => [
                'left' => [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/misc','thumb' => 1, 'thumbsize' => 150],
                'right' => [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/misc','thumb' => 1, 'thumbsize' => 150],
                'top' => [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/misc','thumb' => 1, 'thumbsize' => 150],
                'bottom' => [DB_FILE,WIDGET_SELECTFILE, 'src' => 'galleries/misc','thumb' => 1, 'thumbsize' => 150],
            ],
        ],
        'oceangoodies' => [DB_STRING, WIDGET_TEXT],
    ],
    'plain' => false,
    'table' => true,
    'data' => $data,
    'prefix' => 'form[data]'
]); ?>