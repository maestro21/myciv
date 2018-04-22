<h2><?php echo T('General');?></h2>
<?php echo
    drawForm([
        'fields' => [
            'description' => [DB_TEXT,WIDGET_TEXTAREA],

            'mode' => [ DB_TEXT, WIDGET_SELECT ],
            'tile' => [ DB_ARRAY, WIDGET_ARRAY,
                'children' => [
                    'size' => [ DB_ARRAY, WIDGET_COORDS ],
                    'shadowOffset' => [DB_ARRAY, WIDGET_COORDS],
                    'offset' => [DB_ARRAY, WIDGET_COORDS],
                ]
            ],
            'cultures' => [ DB_TEXT, WIDGET_TEXT],
            'ages'     => [ DB_ARRAY, WIDGET_TABLE,
                'children' => [
                    'name' => [DB_STRING, WIDGET_TEXT],
                    'tech' => [DB_TEXT,WIDGET_SELECT],
                ]
            ],
            'players'     => [ DB_ARRAY, WIDGET_TABLE,
                'children' => [
                    'color' => [DB_STRING, WIDGET_COLOR],
                ]
            ],
        ],
        'data' => $data,
        'prefix' => 'form[data]',
        'options' => [
            'mode' => [ '2d' => '2d', 'iso' => 'isometric', 'isostag' => 'staggered' ],
            'tech' => [ 0 => 'none']
        ],
    ]);
?>