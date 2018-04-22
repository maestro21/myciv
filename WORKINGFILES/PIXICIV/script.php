
var screenX = window.innerWidth;
var screenY = window.innerHeight;
var tileSize = 100;
var offset = 25;
var rand  = 11111;
var tilesX = Math.ceil( screenX / tileSize );
var tilesY = Math.ceil( screenY / tileSize );

var mapoffsetX = 0;
var mapoffsetY = 0;
var mapsizeX = 210;
var mapsizeY = 90;


var renderer = PIXI.autoDetectRenderer(screenX, screenY, {transparent: true});
document.body.appendChild(renderer.view);

var stage, tilemap;

var loader = new PIXI.loaders.Loader();


//console.log(conf.img);

for (var i in conf.img) {
	//console.log(i + ' ' + conf.img[i]);
	loader.add(i, conf.img[i] + '?' + rand);
}


$(function() {
    $('canvas').click(function(e){
		var offset = $(this).offset();
		var dx = e.pageX - offset.left;
		var dy = e.pageY - offset.top;
		var diffX = Math.ceil( dx / tileSize ) - conf.screen.centerTileX - 1;
		var diffY = Math.ceil( dy / tileSize ) - conf.screen.centerTileY - 1;
		mapoffsetX = mapoffsetX + diffX;			
		mapoffsetY = mapoffsetY + diffY;
		console.log(diffX + ' ' + diffY);
		console.log(mapoffsetX);
		if(mapoffsetX < 0) mapoffsetX = mapsizeX + mapoffsetX; console.log(mapoffsetX);
		if(mapoffsetX > mapsizeX) mapoffsetX = mapoffsetX - mapsizeX;
		if(mapoffsetY < 0) mapoffsetY = 0;
		if(mapoffsetY > mapsizeY) mapoffsetX = mapsizeY - conf.screen.tilesY;
		
		render();	
	});
});

loader.add('coast', 'img/terrain/coast.png?' + screen.rand);

loader.load(function(loader, resources) { render();


});


function render() {
	//first parameter means z-layer, which is not used yet
    //second parameter is list of textures for layers
    //third parameter means that all our tiles are squares or at least 2x1 dominoes
    //   and we can optimize it with gl.POINTS
    stage = new PIXI.Container();
	coastlayer = new PIXI.tilemap.CompositeRectTileLayer(0, [], true);	
	terrainlayer = new PIXI.tilemap.CompositeRectTileLayer(1, [], true);
	terrain2layer = new PIXI.tilemap.CompositeRectTileLayer(2, [], true);
	riverLayer = new PIXI.tilemap.CompositeRectTileLayer(4, [], true);
	improvementLayer = new PIXI.tilemap.CompositeRectTileLayer(4, [], true);
	
	citylayer = new PIXI.tilemap.CompositeRectTileLayer(5, [], true);
	toplayer = new PIXI.tilemap.CompositeRectTileLayer(6, [], true);
		
	
	stage.addChild(coastlayer);
	stage.addChild(terrainlayer);
	stage.addChild(terrain2layer);
	stage.addChild(riverLayer);
	stage.addChild(improvementLayer);
	stage.addChild(citylayer);
	stage.addChild(toplayer);

    loadTilemap();
}


function loadTilemap() {
    $.get( "apigame.php?do=loadmap&x=" + mapoffsetX + "&y=" + mapoffsetY, function( data ) {
		data = $.parseJSON(data); //console.log(data);
		for (var j in data) {
			for (var i in data[j]) {
				var tile = data[j][i];
				if (!tile) continue;
				var _x = (i - 1) * tileSize - offset;
				var _y = (j - 1) * tileSize - offset;
				if (tile['terrain2']) { //console.log(tile['terrain2']);
					terrain2layer.addFrame('img-terrain-' + tile['terrain2'], _x, _y);
				} else if(tile['terrain'] && tile['terrain'] !== 'water') {
					terrainlayer.addFrame('img-terrain-' + tile['terrain'], _x, _y);
				}
				
				if(typeof tile['coast'] !== 'undefined') {
					coastlayer.addFrame('img-terrain-coast', _x, _y);
				}
				
				if(tile['terrain'] != 'water') {

					if(tile['river']) {
						riverLayer.addFrame('img-terrain-river-river', _x, _y)
						for(var r in tile['rivers']) {
							var dim = tile['rivers'][r];
							riverLayer.addFrame('img-terrain-river-' + dim, _x, _y);
						}
					}					
					
					if(tile['road']) { //console.log(tile['roads']);
						//improvementLayer.addFrame('img-terrain-roads-roads_2', _x, _y); /*
						improvementLayer.addFrame('img-terrain-roads-2roads', _x, _y)
						for(var r in tile['roads']) {
							var dim = tile['roads'][r];
							improvementLayer.addFrame('img-terrain-roads-2' + dim, _x, _y);
						}/**/
					}
					
					
					if(tile['improvement']) {
						if (tile['terrain2']) {
							improvementLayer.addFrame('img-improvements-' + tile['improvement'] , _x, _y);
						} else {
							terrainlayer.addFrame('img-improvements-' + tile['improvement'] , _x, _y);
						}
					}					
					
					if(tile['city']) {
						
						
						if(tile['city']['gfxsize'] == 4) {
							if(tile['dock1']) {
								for (var d in tile['dock1']) {
									var _d  = tile['dock1'][d];
									var _dx = (_d.x + 1) * 75 - 35;
									var _dy = (_d.y + 1) * 70 - 10;
									citylayer.addFrame('img-cities-roman_dock', _x + _dx, _y + _dy);
								}
							}
							
							citylayer.addFrame('img-cities-roman_4', _x - 10, _y - 15);
							
							if(tile['dock2']) {
								for (var d in tile['dock2']) {
									var _d  = tile['dock2'][d];
									var _dx = (_d.x + 1) * 75 - 35;
									var _dy = (_d.y + 1) * 70 - 10;
									citylayer.addFrame('img-cities-roman_dock', _x + _dx, _y + _dy);
								}
							}
						} else {	
							if(tile['dock1']) {
								for (var d in tile['dock1']) {
									var _d  = tile['dock1'][d];
									var _dx = (_d.x + 1) * 70 - 25;
									var _dy = (_d.y + 1) * 60 - 10;
									citylayer.addFrame('img-cities-roman_dock', _x + _dx, _y + _dy);
								}
							}
							
							citylayer.addFrame('img-cities-roman_' + tile['city']['gfxsize'], _x, _y);
							
							if(tile['dock2']) {
								for (var d in tile['dock2']) {
									var _d  = tile['dock2'][d];
									var _dx = (_d.x + 1) * 70 - 25;
									var _dy = (_d.y + 1) * 60 - 10;
									citylayer.addFrame('img-cities-roman_dock', _x + _dx, _y + _dy);
								}
							}
						}
						
						
						drawCityInfo(_x, _y, tile.city);
					}	
				}

				if(tile['unit2'] == 'legio') {
					toplayer.addFrame('img-units-' + tile['unit2'], _x, _y);
				}
			
				if(tile['nation'] == 'roman') {
					toplayer.addFrame('img-flags-rome2', _x + 45, _y + 10);
				}	
				
				if(tile['unit'] == 'trireme') {
					toplayer.addFrame('img-units-' + tile['unit'], _x, _y);
				}					
				
				
				if(tile['borders']) {
					for(var b in tile['borders']) {
						toplayer.addFrame('img-misc-border2_' + tile['borders'][b], _x, _y);
					}
				}	
				
			}	
		}
		drawCursor();
		console.log(data[conf.screen.centerTileY][conf.screen.centerTileX]);
		renderer.render(stage);
	});
}

function drawCursor() {
	var gfx = new PIXI.Graphics();
	gfx.lineStyle(2, 0x00FF00);
    gfx.drawRect(0,0,100,100);
    gfx.endFill();
	var x = (conf.screen.centerTileX) * tileSize;
	var y = (conf.screen.centerTileY) * tileSize;
	gfx.position.set(x, y);
	stage.addChild(gfx);
}

function drawCityInfo(_x,_y, city) {
	
	var color1 = 0xe79a39;
	var color2 = 0x8B0000;
	
	color1 = 0x000000;
	color2 = 0xffffff;
	
	var txt = new PIXI.Text(city.size, {
		fontSize : 20, 
		fontFamily: 'Arial',
		fill : color1 //0xe79a39
	});
	txt.anchor.set(0.5, 0.5);
    txt.position.set(13,13);
	
	var gfx = new PIXI.Graphics();
	gfx.lineStyle(2, color1);
	gfx.beginFill(color2);
    gfx.drawRect(0,0,26,26);
    gfx.endFill();
	gfx.addChild(txt);
	gfx.position.set(_x + 10, _y + 130);
	

	
	var txt2 = new PIXI.Text(city.name, {
		fontSize : 20, 
		fontFamily: 'Arial',
		fill : 0xffffff,
	});
	txt2.anchor.set(0, 0.5);
    txt2.position.set(10,13);
	var bounds = txt2.getBounds();
	
	
	var gfx2 = new PIXI.Graphics();
	gfx2.alpha = 0.6;
	gfx2.lineStyle(2, 0x000000);
	gfx2.beginFill(0x000000);
    gfx2.drawRect(0,0,bounds.width + 20,26);
    gfx2.endFill();
	gfx2.addChild(txt2);
	
	console.log(gfx2.calculateBounds());
	gfx2.position.set(_x + 36, _y + 130);
	
	
	
	stage.addChild(gfx2);
	stage.addChild(gfx);
	
}
