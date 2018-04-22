<?php $classic = array (
  'description' => 'Classic ruleset based on Civ2-3',
  'mode' => '2d',
  'tile' => 
  array (
    'size' => 
    array (
      'x' => '100',
      'y' => '100',
    ),
    'shadowOffset' => 
    array (
      'x' => '25',
      'y' => '25',
    ),
    'offset' => 
    array (
      'x' => '25',
      'y' => '25',
    ),
  ),
  'cultures' => 'default,roman,egyptian,german,greek,russian',
  'ages' => 
  array (
    0 => 'ancient',
    1 => 'medieval',
    2 => 'renaissance',
    3 => 'industrual',
    4 => ' modern',
  ),
  'players' => 
  array (
    0 => 'FF0000',
    1 => '0000FF',
    2 => '00FF00',
    3 => 'FFFF00',
    4 => 'FF00FF',
    5 => '00FFFF',
    6 => '888888',
    7 => 'FFFFFF',
    8 => '000000',
    9 => '880000',
    10 => '008800',
    11 => '000088',
    12 => 'FF8800',
    13 => 'FF0088',
    14 => '88FF00',
    15 => '8800FF',
    16 => '00FF88',
    17 => '0088FF',
    18 => 'FF8888',
    19 => '88FF88',
    20 => '8888FF',
  ),
  'religion' => 
  array (
    0 => 
    array (
      'img' => '',
      'name' => 'Paganism',
      'gov' => 'Cult',
      'title' => 'Highest Priest',
      'templename' => 'Temple',
      'templepic' => '',
    ),
    1 => 
    array (
      'img' => '',
      'name' => 'Catholicism',
      'gov' => 'Order',
      'title' => 'Pope',
      'templename' => 'Cathedral',
      'templepic' => '',
    ),
    2 => 
    array (
      'img' => '',
      'name' => 'Orthodoxy',
      'gov' => 'Patriarchy',
      'title' => 'Patriarch',
      'templename' => 'Church',
      'templepic' => '',
    ),
    3 => 
    array (
      'img' => '',
      'name' => 'Islam',
      'gov' => 'Caliphate',
      'title' => 'Caliph',
      'templename' => 'Mosque',
      'templepic' => '',
    ),
    4 => 
    array (
      'img' => '',
      'name' => 'Budhism',
      'gov' => 'Lamaism',
      'title' => 'Lama',
      'templename' => 'Temple',
      'templepic' => '',
    ),
  ),
  'food' => '35',
  'prod' => '40',
  'gold' => '39',
  'science' => '38',
  'cursor' => '68',
  'startlocation' => '70',
  'water' => '69',
  'coast' => '13',
  'river' => '26',
  'terrain' => 
  array (
    'd' => 
    array (
      'name' => 'desert',
      'img' => '14',
      'char' => 'd',
      'goodies' => '9478c',
      'subterrains' => '',
      'color' => 'FFFF00',
    ),
    'l' => 
    array (
      'name' => 'floodplains',
      'img' => '84',
      'char' => 'l',
      'goodies' => '96',
      'subterrains' => 'j##',
      'color' => 'FB00FF',
    ),
    'f' => 
    array (
      'name' => 'forrest',
      'img' => '107',
      'char' => 'f',
      'goodies' => '',
      'subterrains' => '',
      'color' => '572002',
    ),
    'g' => 
    array (
      'name' => 'grassland',
      'img' => '17',
      'char' => 'g',
      'goodies' => '92ci',
      'subterrains' => 'f##',
      'color' => '008D02',
    ),
    'h' => 
    array (
      'name' => 'hills',
      'img' => '110',
      'char' => 'h',
      'goodies' => 'id12ab',
      'subterrains' => '',
      'color' => '888888',
    ),
    'j' => 
    array (
      'name' => 'jungle',
      'img' => '19',
      'char' => 'j',
      'goodies' => '64',
      'subterrains' => '',
      'color' => '00FF00',
    ),
    'm' => 
    array (
      'name' => 'mountains',
      'img' => '20',
      'char' => 'm',
      'goodies' => '1abde',
      'subterrains' => '',
      'color' => '343434',
    ),
    'p' => 
    array (
      'name' => 'plains',
      'img' => '21',
      'char' => 'p',
      'goodies' => 'c39',
      'subterrains' => 'f#########',
      'color' => 'FFAE00',
    ),
    'w' => 
    array (
      'name' => 'swamp',
      'img' => '22',
      'char' => 'w',
      'goodies' => '',
      'subterrains' => '',
      'color' => '000000',
    ),
    't' => 
    array (
      'name' => 'taiga',
      'img' => '23',
      'char' => 't',
      'goodies' => '',
      'subterrains' => 'f#',
      'color' => '60C55E',
    ),
    's' => 
    array (
      'name' => 'snow',
      'img' => '27',
      'char' => 's',
      'goodies' => 'f',
      'subterrains' => '',
      'color' => 'FFFFFF',
    ),
  ),
  'borders' => 
  array (
    'left' => '130',
    'right' => '131',
    'top' => '132',
    'bottom' => '129',
  ),
  'oceangoodies' => 'g95',
  'goodies' => 
  array (
    1 => 
    array (
      'name' => 'coal',
      'img' => '85',
      'char' => '1',
      'terrain' => 'mh',
    ),
    2 => 
    array (
      'name' => 'cow',
      'img' => '87',
      'char' => '2',
      'terrain' => 'gh',
    ),
    3 => 
    array (
      'name' => 'wheat',
      'img' => '102',
      'char' => '3',
      'terrain' => 'p',
    ),
    4 => 
    array (
      'name' => 'ivory',
      'img' => '89',
      'char' => '4',
      'terrain' => 'jd',
    ),
    5 => 
    array (
      'name' => 'fish',
      'img' => '90',
      'char' => '5',
      'terrain' => ' ',
    ),
    6 => 
    array (
      'name' => 'fruits',
      'img' => '91',
      'char' => '6',
      'terrain' => 'lj',
    ),
    7 => 
    array (
      'name' => 'oasis',
      'img' => '97',
      'char' => '7',
      'terrain' => 'd',
    ),
    8 => 
    array (
      'name' => 'marble',
      'img' => '96',
      'char' => '8',
      'terrain' => 'd',
    ),
    9 => 
    array (
      'name' => 'oil',
      'img' => '98',
      'char' => '9',
      'terrain' => '',
    ),
    'a' => 
    array (
      'name' => 'gems',
      'img' => '92',
      'char' => 'a',
      'terrain' => 'm',
    ),
    'b' => 
    array (
      'name' => 'gold',
      'img' => '93',
      'char' => 'b',
      'terrain' => 'm',
    ),
    'c' => 
    array (
      'name' => 'horse',
      'img' => '133',
      'char' => 'c',
      'terrain' => 'dgp',
    ),
    'd' => 
    array (
      'name' => 'iron',
      'img' => '95',
      'char' => 'd',
      'terrain' => 'mh',
    ),
    'e' => 
    array (
      'name' => 'uranium',
      'img' => '99',
      'char' => 'e',
      'terrain' => 'm',
    ),
    'f' => 
    array (
      'name' => 'walrus',
      'img' => '100',
      'char' => 'f',
      'terrain' => 's',
    ),
    'g' => 
    array (
      'name' => 'wale',
      'img' => '101',
      'char' => 'g',
      'terrain' => ' ',
    ),
    'h' => 
    array (
      'name' => 'wheat',
      'img' => '102',
      'char' => 'h',
      'terrain' => 'p',
    ),
    'i' => 
    array (
      'name' => 'wine',
      'img' => '103',
      'char' => 'i',
      'terrain' => 'gh',
    ),
  ),
  'roads' => 
  array (
    0 => 
    array (
      'name' => 'romanroads',
      'img' => '116',
    ),
  ),
  'improvements' => 
  array (
    0 => 
    array (
      'name' => 'irrigation',
      'img' => '113',
      'layer' => 'terrain',
    ),
    1 => 
    array (
      'name' => 'mine',
      'img' => '82',
      'layer' => 'mapobjects',
    ),
    2 => 
    array (
      'name' => 'lumbermill',
      'img' => '81',
      'layer' => 'mapobjects',
    ),
  ),
  'cities' => 
  array (
    'default' => 
    array (
      'ancient' => '64',
      'medieval' => '',
      'renaissance' => '',
      'industrual' => '',
      ' modern' => '',
    ),
    'roman' => 
    array (
      'ancient' => '1',
      'medieval' => '120',
      'renaissance' => '',
      'industrual' => '',
      ' modern' => '',
    ),
    'egyptian' => 
    array (
      'ancient' => '119',
      'medieval' => '',
      'renaissance' => '',
      'industrual' => '',
      ' modern' => '',
    ),
    'german' => 
    array (
      'ancient' => '',
      'medieval' => '122',
      'renaissance' => '',
      'industrual' => '',
      ' modern' => '',
    ),
    'greek' => 
    array (
      'ancient' => '',
      'medieval' => '123',
      'renaissance' => '',
      'industrual' => '',
      ' modern' => '',
    ),
    'russian' => 
    array (
      'ancient' => '',
      'medieval' => '',
      'renaissance' => '134',
      'industrual' => '',
      ' modern' => '',
    ),
  ),
  'units' => 
  array (
    0 => '1',
    1 => '2',
    2 => '3',
    3 => '4',
    4 => '5',
    5 => '6',
    6 => '7',
    7 => '8',
    8 => '9',
  ),
);