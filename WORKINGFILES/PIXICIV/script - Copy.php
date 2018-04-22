var screenX = window.innerWidth;
var screenY = window.innerHeight;
var tileSize = 100;
var offset = 25;

var tilesX = Math.ceil( screenX / tileSize );
var tilesY = Math.ceil( screenY / tileSize );


var renderer = PIXI.autoDetectRenderer(screenX, screenY, {transparent: true});
document.body.appendChild(renderer.view);

var stage, tilemap;

var loader = new PIXI.loaders.Loader();
loader.add('atlas', 'basic/atlas.json');

var terr = [];
<?php 

$terrain = array(
	'grassland',
	'plains',
	'snow',
	'taiga',
	'desert',
	'floodplains',
	'jungle',	
	'swamp',
	'mountains',
	'hills',
	'forrest',
);
$to = sizeof($terrain) * 2;

foreach($terrain as $ter) { ?>
	var terrain = '<?php echo $ter;?>';
	terr.push(terrain);
	loader.add(terrain, 'img/terrain/' + terrain + '.png?' + screen.rand +43535);
<? } ?>

loader.add('coast', 'img/terrain/coast.png?' + screen.rand);

loader.load(function(loader, resources) {
    //first parameter means z-layer, which is not used yet
    //second parameter is list of textures for layers
    //third parameter means that all our tiles are squares or at least 2x1 dominoes
    //   and we can optimize it with gl.POINTS
    stage = new PIXI.Container();
	tilemap = new PIXI.tilemap.CompositeRectTileLayer(0, [], true);
	coastlayer = new PIXI.tilemap.CompositeRectTileLayer(1, [], true);	
	toplayer = new PIXI.tilemap.CompositeRectTileLayer(1, [], true);	
	
	stage.addChild(coastlayer);
	stage.addChild(tilemap);
	stage.addChild(toplayer);

    buildTilemap();

    renderer.render(stage);
});

function rnd(min, max) {
  return Math.floor(Math.random() * (max - min)) + min;
}

function buildTilemap() {
    //Clear everything, like a PIXI.Graphics
    tilemap.clear();
    var resources = loader.resources;

    var size = tileSize;
    // if you are too lazy, just specify filename and pixi will find it in cache
    for (var i=0;i<tilesX;i++) {
        for (var j=0;j<tilesY;j++) {
			var _rnd = rnd(0, terr.length * 2);
			if(_rnd < terr.length) {
				var txtr = terr[_rnd];
				if(_rnd > 7) {
					toplayer.addFrame(resources[txtr].texture, i*size - offset, j*size - offset );
				} else {
					tilemap.addFrame(resources[txtr].texture, i*size - offset, j*size - offset );
				}
				coastlayer.addFrame('coast', i*size - offset, j*size - offset );
			}
		}
	}
}

