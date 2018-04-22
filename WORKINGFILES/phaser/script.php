console.log(conf);

var game = new Phaser.Game(conf.screenX, conf.screenY, Phaser.AUTO, '', { preload: preload, create: getMapXY, update:update });

var cursorX = cursorXabs = cursorPrevX = 4, 
	cursorY = cursorYabs = cursorPrevY = 4, 
	offsetX = 75, 
	offsetY = 35,
	
	bgLayer,
	terrainLayer,
	coastLayer,
	globalOffsetX = -40;
	globalOffsetY = -20,
	tileEvenYoffsetX = 0,
	closest = [],
	
	rnd = '?=4352';//'?=' + conf.rand;
	;
	
function preload() {

	game.cache.destroy();  //return;
	//game.load.spritesheet('water', 'img/misc/water.png', 100, 50);
	for (var key in conf.images) {
		var img = conf.images[key];
		game.load.image(key, conf.imgdir + img + rnd);
	}
	for (var key in conf.spritesheets) {
		var spritesheet = conf.spritesheets[key];
		//console.log(key + ' ' + conf.imgdir + spritesheet[0] + ' ' + spritesheet[1] + ' ' + spritesheet[2]);
		game.load.spritesheet(key, conf.imgdir + spritesheet[0] + rnd, spritesheet[1], spritesheet[2] );
	}
	
	bgLayer = game.add.group();
	terrainLayer = game.add.group();
	coastLayer = game.add.group();
	landLayer = game.add.group();
	topLayer = game.add.group();
}

function destroy() {
	terrainLayer.destroy();
	coastLayer.destroy();
	landLayer.destroy();
	topLayer.destroy();
	
	terrainLayer = game.add.group();
	coastLayer = game.add.group();
	landLayer = game.add.group();
	topLayer = game.add.group();
}


function getMapXY() {
	var action = 'getMap', data = '';
	if(editCursor) {
		action = editCursor;
		data = { x : offsetX + cursorX, y: offsetY + cursorY, val: editCursorVal};
	}
	$.post( "map.php", { 
		action: action, 
		offsetX: offsetX, 
		offsetY: offsetY, 
		data: data,
		map: 'world150x150'
	})
	.done(function( data ) {
		map = $.parseJSON(data);
		destroy();
		render();
	});	
}

function render() { //return;

	/** creating water bg **/
	water = new Phaser.TileSprite(game,0, 0, conf.screenX, conf.screenY, 'water');
	water.animations.add('float');
	water.animations.play('float', 8, true);
	bgLayer.add(water);
	/** creating cursor **/
	
	
	
	var dx, dy, mtn;
	/** drawing map **/
	for(var y = -1; y < conf.screenTilesY; y++) {
		dy = (offsetY + y);	
		tileEvenYoffsetX = (dy % 2) * conf.offset;		
		//console.log(tileEvenYoffsetX);
		//console.log(y);
		for(var x = -1; x < conf.screenTilesX; x++) {
			
			dx = (offsetX + x);	
			mtn = 0;
			//game.add.text(x * conf.tileX + 85 + offset + globalOffsetX, y * conf.tileY+ 40 + globalOffsetY, "x" + x + ',y' + y);
			if(dy == -1) {
				drawTile('terrain-snow', x,y, terrainLayer );
				if(x == conf.screenTilesX - 1) drawTile('terrain-snow', x+1,y, terrainLayer );
				continue;
			} 
			if(dx == -1) {
				continue;
			}
						
			/*dx = x;
			if (x < 0) dx = conf.screenTilesX + x;
			if (x > conf.screenTilesX) dx = x - conf.screenTilesX;*/

			var tile = getTile(x,y);//map[offsetY + y][offsetX + dx];
			tile = findCenter(tile, x,y);
			
			
			//console.log(tile);
			/** terrain **/
			if(tile.terrain != 'water') {
				drawTile('terrain-' + tile.terrain, x,y, terrainLayer, 0, 5  );
			}
			/** coast **/
			if(tile.coast) { //console.log(x + ' ' + y); //console.log(tile.coast);
				for (var z in tile.coast) {
					drawFrame('coast', x,y, tile.coast[z], coastLayer);
				}
			}
			/** irrigation **/
			if(tile.land) {
				drawTile('land-' + tile.land, x,y, landLayer);
			}
			/** river **/
			if(tile.river) {
				for (var z in tile.river) {
					drawFrame('river', x,y,  tile.river[z], landLayer);
				}
			}
			/** roads **/
			if(tile.roads) {
				for (var z in tile.roads) {
					drawFrame('roads', x,y, tile.roads[z], landLayer);
				}
			}
			/** terrain2 **/
			if(tile.terrain2) {
				if(tile.terrain2 == 'mountains' || tile.terrain2 == 'hills')  mtn = -15;
				drawTile('terrain-' + tile.terrain2, x,y, landLayer);
			}
			/** mine **/
			if(tile.mine) {
				drawTile('mine', x,y, landLayer);
			}
			
			/** city **/
			if(tile.city) {
				var player = conf.players[tile.city.player]; //console.log(player);
				var citytype = player.city;
				var city = conf.cities[citytype][3];
				drawTile('city-' + citytype, x,y,  landLayer, 0, mtn);
				player.flag = 'rome';
				for(var f in city.flags) {
					var ox = city.flags[f].left;
					var oy = city.flags[f].top + mtn;
					drawAnimation('flag-' + player.flag + '-anim' , x,y, landLayer, ox, oy);
				}
			}
			
			/** cursor **/
			if(x == cursorX && y == cursorY) {
				drawAnimation('cursor', x,y, landLayer,50,25);
			}
			
			/** units **
			if(tile.unit) {
				//console.log(tile.unit);
				var player = conf.players[tile.unit.player]; 
				var unit = conf.units[tile.unit.name]; //console.log(unit.unitflag.left);
				// draw flag
				var ox = unit.unitflag.left;
				var oy = unit.unitflag.top + mtn;
				//drawTile('flag-' + player.flag, x,y,  landLayer, ox, oy - 60);
				// draw units
				for(var u in unit.units) {
					ox = unit.units[u].left;
					oy = unit.units[u].top + mtn;
					drawAnimation('unit-' + tile.unit.name + '-stand' , x,y, landLayer, ox, oy - 60);
				}
			}
			
			/** test **/
			//draw('star', tile.centerX, tile.centerY, topLayer);
			//game.add.text(tile.centerX - 20, tile.centerY - 20, x + ',' + (y-1));
			
			/*** TODO - unit & city info, cursor ***/
			
			/*** NEXT - cursor & map moving; then - map loading, beautiful terrain **/
		}	
	}
}

function update() {

}


function findpxXY(x,y, offX, offY) {
	var offX = (offX || 0) + globalOffsetX + tileEvenYoffsetX,
		offY = (offY || 0) + globalOffsetY,
		pxX =	x * conf.tileX + offX,
		pxY =	y * conf.tileY + offY,
		coords =  { 'x' : pxX, 'y' : pxY };

	return coords;
}

function getTile(x,y) {
	if(typeof map[y] === 'undefined' || typeof map[y][x] === 'undefined'){
	x = Math.ceil(x);
	y = Math.ceil(y);
	/**/console.log(x);
	console.log(y);
	console.log(map);
	console.log(map[y]);
	//console.log(map[y][x]);/**/
	}
	return map[y][x];
}

function draw(img, x,y, layer) {
	var sprite = new Phaser.Sprite(game, x, y, img);
	layer.add(sprite);
	return sprite;
}

function findCenter(tile,tilex, tiley) {
	var coords = findpxXY(tilex,tiley, 40, 20);
	if(coords && tile) {
		tile["centerX"] = coords.x;
		tile["centerY"] = coords.y;
	} else {
		console.log('error: x' + tilex + ' y' + tiley); 
		console.log(tile);
	}
	
	return tile;
}

function drawAnimation(img, tilex, tiley,  layer, offX, offY) {
	var coords = findpxXY(tilex, tiley, offX, offY);
	var anim = draw(img, coords.x, coords.y, layer);
	anim.animations.add('anim');
	anim.animations.play('anim',15, true);
}

function drawFrame(img, tilex, tiley,  frame, layer, offX, offY) {
	var coords = findpxXY(tilex, tiley, offX, offY);
	var sprite = draw(img, coords.x, coords.y, layer);
	sprite.frame = frame;
}

function drawTile(img, tilex, tiley, layer, offX, offY) {
	var coords = findpxXY(tilex, tiley, offX, offY);
	draw(img, coords.x, coords.y, layer);
}


var editCursor = false;
var editCursorVal = '';


function clearEditCursor() {
	editCursor = false;
	editCursorVal = '';
	$('#editor_cursor').html('Cursor');
}

function setEditCursor(cursor,val, text) {
	$('#editor_cursor').html(text);
	editCursor = cursor;
	editCursorVal = val;
}

 $( document ).ready(function() {
 
 

	/** MAIN **/
	$(document).click(function(e){	
		findCoords(e);
		getMapXY();
		//render();
	});	
	$('a').on('click', function(e) {
		e.stopPropagation();
	});
	$('.dropdown').toggle();
	
	
	
	
	/*****/
	
	
	

	function countOffset() {
		cursorXabs = cursorX + offsetX;
		cursorYabs = cursorY + offsetY;
		//отступ это текущ отступ + курсор - полэкрана
		offsetX = offsetX + cursorX - conf.halfScreenX;
		offsetY = offsetY + cursorY - conf.halfScreenY;
		$('#debug').html('Xabs:' + cursorXabs + ' Yabs:' + cursorYabs + '<br>'
		+ 'X:' + cursorX + ' Y:' + cursorY +  '<br>'
		+ 'OffX:' + offsetX + ' OffY:' + offsetY +  '<br>'
		);
		 // отступ не может быть меньше нуля
		if(offsetX < 0) offsetX = 0;
		// отступ не может быть больше ширины карты. неактуально для круглой карты
		if(offsetX > conf.mapwidth - conf.screenTilesX) offsetX = conf.mapwidth - conf.screenTilesX;
		//та же проверка для отступа по высоте
		if(offsetY < 0) offsetY = 0;
		if(offsetY > conf.mapheight - conf.screenTilesY) offsetY = conf.mapheight - conf.screenTilesY;
		//console.log(this.offsetX + ' ' + this.offsetY);		
		//
		offsetX = Math.ceil(offsetX);
		offsetY = Math.ceil(offsetY);
		
		//устанавливаем курсор
		cursorX = cursorXabs - offsetX;
		cursorY = cursorYabs - offsetY;	
		$('#debug').html($('#debug').html() //+ 'Xabs:' + cursorXabs + ' Yabs:' + cursorYabs + '<br>'
		+ 'X:' + cursorX + ' Y:' + cursorY +  '<br>'
		+ 'OffX:' + offsetX + ' OffY:' + offsetY
		);
	}

	function isInCell(x, y, cell) {  //console.log(cell);
		var ddx = Math.ceil(x - cell.centerX),
			ddy = Math.ceil(y - cell.centerY)
			res = ddx / (conf.tileX * 0.5) + ddy / (conf.tileY * 0.5);
			//console.log(res + ' ' + closest['num']);
			if(res < closest['num']) { closest['num'] = res; closest['x'] = cell.x; closest['y'] = cell.y }
		return (res <= 1);
	};

	
	function checkClosest(x,y, clx,cly) {
		var cell = findpxXY(x,y, 80, 20),
			ddx = Math.abs(clx - cell.x),
			ddy = Math.abs(cly - cell.y)
			res = ddx / (conf.tileX * 0.5) + ddy / (conf.tileY * 0.5);
			//console.log(cell); console.log(ddx); console.log(ddy);
		return res;
	}
	
	function findCoords(e) { 
		var clx = e.clientX,
			cly = e.clientY,
			i = 0, tile;
			
		
		cursorPrevX = cursorX;
		cursorPrevY = cursorY;				
		closest['num'] = 9999999;
		for(var y = 0; y < conf.screenTilesY; y++) {
			for(var x = 0; x < conf.screenTilesX; x++) { 
				//var tile = map[offsetY + y][offsetX + x];
				//isInCell(clx, cly, tile);
				var res = checkClosest(x,y, clx,cly);
				if(res < closest['num']) { closest['num'] = res; closest['x'] = x; closest['y'] = y }
			}
		}
		if(y <= conf.screenTilesY && x <= y < conf.screenTilesX) {
			cursorX = closest['x'];
			cursorY = closest['y'];
		}
		cursorY--;
		//if(cursorY % 2) cursorX--
		/** **/
		cursorY = Math.abs(cursorY);
		cursorX = Math.abs(cursorX);
			
		countOffset();	
		
		console.log('Gx:' + (offsetX + cursorX) + ' Gy:' + (offsetY + cursorY));
		console.log('x:' + cursorX + ' y:' + cursorY);
		console.log(getTile(cursorX,cursorY));
	}
});