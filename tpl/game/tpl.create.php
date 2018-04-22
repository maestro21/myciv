<h2><?php echo T('Create game');?></h2>
<form method="POST" id="form" class="content" action="<?php echo BASE_URL . $class;?>/create?ajax=1" enctype='multipart/form-data'>
<?php echo
    drawForm([
        'fields' => [
            'ruleset' => [ DB_INT, WIDGET_SELECT, 'options' => $rulesets],
            'mapmode'  => [ DB_INT, WIDGET_TAB,
				'options' => [
            		//'scenario',
					'openmap',
					'loadmap',
					'randommap'
				],
				'default' => 'randommap',
			],
			'loadmap' => [
				DB_ARRAY, WIDGET_ARRAY,
				'children' => [
					'map' 	=> [ DB_STRING, WIDGET_FILE ],
					'river' => [ DB_STRING, WIDGET_FILE ],
					'startlocations' 	=> [ DB_STRING, WIDGET_FILE ],
                    'createterrain2' 	=> [ DB_INT, WIDGET_CHECKBOX,  'default' => 1 ],
                    'creategoodies' 	=> [ DB_INT, WIDGET_CHECKBOX,  'default' => 1 ],
				],
			],
			'randommap' => [
				DB_ARRAY, WIDGET_ARRAY,
				'children' => [
					'mapsize' 	=> [ DB_ARRAY, WIDGET_COORDS, 'default' => ['x' => 100, 'y' => 50] ],
					'round' 	=> [ DB_INT, WIDGET_CHECKBOX,  'default' => 1 ],
				],
			],
            'openmap' => [
				DB_ARRAY, WIDGET_ARRAY,
				'children' => [
					'map' => [DB_TEXT, WIDGET_SELECT, 'options' => $maps]
				],
			],
			'players' => [
				DB_ARRAY, WIDGET_TABLE,
				'children' => [
					'control' => [
						DB_INT, WIDGET_SELECT, 'options' => ['player', 'ai' ],
					],
					'civ' => [
						DB_INT, WIDGET_SELECT, 'options' => cache('civlist'),
					],
					//'color' => [DB_STRING, WIDGET_COLOR]
				],
			]
        ]
    ]);
?>
<tr>
			<td colspan="2" align="center">
				<div class="btn submit"><?php echo T('create');?></div>
				<div class="messages"></div>
			</td>
		</tr>
	</table>	
</form>