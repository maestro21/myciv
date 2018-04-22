<h2><?php echo T('Cities');?></h2>
<?php
$ageCityCulture = array();
$cultures = explode(',', $data['cultures']);//glist('cultures');
foreach($cultures as $culture) {
    $row = array();
    unset($data['ages']['{key}']);
    foreach ($data['ages'] as $age) {
        $row[$age['name']] = [DB_FILE, WIDGET_SELECTFILE, 'src' => 'galleries/cities', 'thumb' => 1, 'thumbsize' => 150];
    }
    $ageCityCulture[$culture] = [ DB_TEXT, WIDGET_ARRAY,
        'children' => $row,
        'plain' => true,
    ];
}
echo
drawForm([
    'fields' => [
        'cities' => [DB_ARRAY, WIDGET_ARRAY,
            'children' => $ageCityCulture
        ],
    ],
    'data' => $data,
    'table' => true,
    'prefix' => 'form[data]'
]); ?>