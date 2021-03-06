<?php


$cities = [
	[
		'name' => 'Rome',
		'size' => 15,
		'x' => 11,
		'y' => 2,	
	],
	[
		'name' => 'Naples',
		'size' => 8,
		'x' => 13,
		'y' => 3,	
	],
	[
		'name' => 'Tarentum',
		'size' => 8,
		'x' => 15,
		'y' => 4,	
	],
	[
		'name' => 'Syracusae',
		'size' => 8,
		'x' => 12,
		'y' => 5,	
	],
	[
		'name' => 'Auilea',
		'size' => 4,
		'x' => 12,
		'y' => 0,	
	],


	[
		'name' => 'Carthago',
		'size' => 10,
		'x' => 9,
		'y' => 6,	
	],
	[
		'name' => 'Leptis Magna',
		'size' => 6,
		'x' => 12,
		'y' => 8,	
	],
	[
		'name' => 'Cyrene',
		'size' => 6,
		'x' => 16,
		'y' => 8,	
	],
	[
		'name' => 'Alexandria',
		'size' => 10,
		'x' => 22,
		'y' => 9,	
	],
	
	
	[
		'name' => 'Salamis',
		'size' => 3,
		'x' => 21,
		'y' => 7,	
	],
	[
		'name' => 'Athenes',
		'size' => 8,
		'x' => 19,
		'y' => 6,	
	],
	[
		'name' => 'Sparta',
		'size' => 6,
		'x' => 17,
		'y' => 5,	
	],
	[
		'name' => 'Jerusalem',
		'size' => 8,
		'x' => 25,
		'y' => 8,	
	],
	
	
	[
		'name' => 'Miletus',
		'size' => 3,
		'x' => 23,
		'y' => 5,	
	],
	[
		'name' => 'Byzantium',
		'size' => 12,
		'x' => 21,
		'y' => 2,	
	],
	[
		'name' => 'Trapezus',
		'size' => 6,
		'x' => 24,
		'y' => 3,	
	],
	[
		'name' => 'Hersones',
		'size' => 8,
		'x' => 25,
		'y' => 0,	
	],

	
	[
		'name' => 'Durostorum',
		'size' => 3,
		'x' => 21,
		'y' => 0,	
	],
	[
		'name' => 'Naisus',
		'size' => 3,
		'x' => 18,
		'y' => 0,	
	],
	[
		'name' => 'Salonae',
		'size' => 6,
		'x' => 15,
		'y' => 0,	
	],
	[
		'name' => 'Malta',
		'size' => 3,
		'x' => 14,
		'y' => 7,	
	],
	
	
	[
		'name' => 'Caesarea',
		'size' => 6,
		'x' => 5,
		'y' => 6,	
	],
	[
		'name' => 'Gades',
		'size' => 4,
		'x' => 1,
		'y' => 6,	
	],
	[
		'name' => 'Carthago Nova',
		'size' => 8,
		'x' => 4,
		'y' => 4,	
	],
	[
		'name' => 'Tarraco',
		'size' => 6,
		'x' => 5,
		'y' => 2,	
	],
	

	[
		'name' => 'Emerita Augusta',
		'size' => 3,
		'x' => 0,
		'y' => 3,	
	],
	[
		'name' => 'Caesaragusta',
		'size' => 3,
		'x' => 2,
		'y' => 1,	
	],
	[
		'name' => 'Burdigala',
		'size' => 3,
		'x' => 5,
		'y' => 0,	
	],
	[
		'name' => 'Massilia',
		'size' => 8,
		'x' => 8,
		'y' => 0,	
	],
	
	
	[
		'name' => 'Butthrottum',
		'size' => 3,
		'x' => 17,
		'y' => 3,	
	],
	
];






file_put_contents('demomap_cities.json', json_encode($cities));