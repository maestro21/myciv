<div id="playerdata" class="gamebg">
    <div class="year">4000 BC</div>
    <img id="playerflag">
    <div class="info"></div>
    <img id="playergov">
    <img id="playerreligion">
</div>
<div id="gamecontrol" class="gamebg">
    <div id="coords"> </div>
    <div id="minimap"><div class="selection"></div></div>
</div>
<div id="animation"></div>
<script src="<?php echo BASECIVURL . 'gametpl/js/pixi.js';?>"></script>
<script src="<?php echo BASECIVURL . 'gametpl/js/units.js';?>"></script>
<script src="<?php echo BASECIVURL . 'gametpl/js/orders.js';?>"></script>
<script>

    var fps = 20;
    var v = Math.random();
    var baseurl = '<?php echo BASE_URL;?>';
    var gameurl = baseurl + 'game/api';
    var upurl = '<?php echo BASEFMURL;?>';
    var gid = <?php echo $gid;?>;
    var conf = <?php echo json_encode($ruleset);?>;
    conf.name = '<?php echo $game['ruleset'];?>';
    var game = <?php echo json_encode($game);?>;
    var images = <?php echo json_encode(cache('galleries_images'));?>;
    var thumbs = <?php echo json_encode(cache('galleries_thumbs'));?>;
    var civs = <?php echo json_encode(cache('civilizations'));?>;
    var gov = <?php echo json_encode(cache('gov'));?>;
    var countries = <?php echo json_encode(cache('countries'));?>;

    var unitgallery = <?php echo json_encode(cache('units'));?>;
    unitgallery = unitgallery;


    var cursorX = 0; var cursorY = 0;
    var screenX = parseInt(screen.width);
    var screenY = parseInt(screen.height) - 50;

    var tileSize = parseInt(conf.tile.size.x);
    var tileImgSize = tileSize * 1.5;
    var offset = parseInt(conf.tile.offset.x);
    var rand  = <?php echo rand();?>;
    var tilesX = Math.floor( screenX / conf.tile.size.x);
    var tilesY = Math.floor( screenY / conf.tile.size.y);
    var centerTileX = Math.floor(tilesX / 2 );
    var centerTileY = Math.floor(tilesY / 2);

    var mapsizeX = parseInt(game.map.size.x);
    var mapsizeY = parseInt(game.map.size.y);
    var mapoffsetX = Math.floor((mapsizeX - tilesX) / 2);
    var mapoffsetY = Math.floor((mapsizeY - tilesY) / 2);
    var cursorX = mapoffsetX + centerTileX;
    var cursorY = mapoffsetY + centerTileY;

    var renderer = new PIXI.autoDetectRenderer(screenX, screenY, {transparent: true});

    $('.content').append(renderer.view);
    $('.content canvas').css('background-image','url(' + images[conf.water] + ')');

    var loader = new PIXI.loaders.Loader();
    var stage, tilemap;

    var _click = false;
    var res;
    var animations = [];
    var cursoranimation = null;  
    
    
    var editclass = null;
    var editfunction = null;
    var editdata = null;
    var editmode = false;


    var currentTile = 0;
    var player = 0;
    var city;
    var unit;

    /** preload **/

    for(var i in images) {
        loader.add(i, images[i] + '?v=' + v);
    }

    // terrain
    addImg('coast', conf.coast);
    addImg('river', conf.river);
    addImg('cursor', conf.cursor);
    addImg('startlocation', conf.startlocation);
    for (var i in conf.terrain) {
       var ter = conf.terrain[i];
       addImg('terrain_' + ter['name'], ter['img']);
    }
    // flags
    //loader.add('flag_roman','http://localhost/myciv/data/uploads/gfx/galleries/flags/20170902215250_59ab0c12321c4.png');

    //cities
    for (var i in conf.cities) {
        var style = conf.cities[i];
        for(var j in style) {
           addImg('city_' + j + '_' + i, style[j]);
        }
    }
    // units
    for (var u in unitgallery) {
        var unit = unitgallery[u];
        loader.add('u' + u, upurl + unit.img.name + '?v=' + v);
    }
    
    updatePlayerInfo();
    loader.load(function(loader,resources) {
        res = resources;
        minimap();
        
            
        $('#minimap').click(function(e) {
            if(_click) return; _click = true;
            var offset = $(this).offset();
            cursorX = Math.ceil((e.pageX - offset.left) /2);
            cursorY = Math.ceil((e.pageY - offset.top) / 2);
            moveMap();
        });
        
        
        render();
    });
 
    
    function addImg(name, src) {
        if(src && images[src]) {
            loader.add(name, images[src] + '?v=' + v);
        }
    }
    
    function addAnimation(src, x,y, cssclass) {
        img = new Image();
        img.onload = function() {
            var anim = {
                'x': x,
                'y': y,
                'size': this.height,
                'src': img.src,
                'frame': 0
            }
           // animations.push(anim);
            var addthing = '';
            if(cssclass.indexOf('cursor') > -1) addthing = ' oncontextmenu="rightClickCursor();return false;" onclick=clickCursor()';
            $('.wrap-game').append('' +
                '<div class="animation ' + cssclass + '"' +
                    ' style="background-image:url(\\'' + src + '\\');' +
                    ' width:' + this.height + 'px;' +
                    ' height:' + this.height + 'px;' +
                    ' top:' + y + 'px;' +
                    ' left:' + x + 'px;"' + addthing +
                    '></div>');
        }
        img.src = src;
    }
    
    function getImg(name) {
        return res[name].texture.baseTexture.imageUrl;
    }
    
    function setCursorAnimation() {
        $('.cursor').addClass('blink').css('background-image', 'url("' + cursoranimation + '")');
    }
    function delCursorAnimation() {
        cursoranimation = null;
        $('.cursor').removeClass('blink').css('background-image', 'url("' + getImg('cursor') + '")');
    }
    
    function gameloop() {
        setTimeout(function(){
            requestAnimationFrame(gameloop);
            // GAMELOOP LOGIC START
            for (var i in animations) {
                var anim = animations[i];
                anim.frame++;
                if(anim.frame > anim.length) anim.frame = 0; 
                $('.' + anim.group).css('background-position-x', (anim.frame * (anim.size + 0.5)) + 'px');
            }        
            // GAMELOOP LOGIC END
        }, 1000/fps);
    }
    //gameloop();

    var layers = {
        _layers: {},
        add:function(name) {
            this._layers[name] = new PIXI.Container();
            stage.addChild(this._layers[name]);
        },
        addTile(layer,texture,x,y,rect, tint) {
            if(!res[texture]) return;
            if(texture > 0 ) {
                //console.log(texture);
            }    
            var _texture = new PIXI.Texture(res[texture].texture);
            if(rect){
                _texture.frame = rect;
            }
            var _sprite = new PIXI.Sprite(_texture);
            _sprite.x = x;
            _sprite.y = y;
            if(tint) {
                _sprite.tint = '0x' + tint;
            }            
            this._layers[layer].addChild(_sprite);
        },
        clearAll() {
            for (var i in this._layers) {
                this.clear(i);
            }
        },
        clear(layer) {
            var _layer = this._layers[layer];
            while(_layer.children[0]) { _layer.removeChild(_layer.children[0]); }
        },
        addChild(layer,obj) {
            this._layers[layer].addChild(obj);
        }
    };

    function getRect(x,y,sizex,sizey) {
        if(!x) x = 0;
        if(!y) y = 0;
        if(!sizex) sizex = tileImgSize;
        if(!sizey) sizey = sizex;
        x = x * sizex;
        y = y * sizey;
        return new PIXI.Rectangle(x,y,sizex,sizey);
    }

    function render() {
        //first parameter means z-layer, which is not used yet
        //second parameter is list of textures for layers
        //third parameter means that all our tiles are squares or at least 2x1 dominoes
        //   and we can optimize it with gl.POINTS
        stage = new PIXI.Container();
        layers.add('coast');
        layers.add('terrain'); // farms here
        layers.add('river');        
        layers.add('roads');
        layers.add('mapobjects');        
        layers.add('borders');
        layers.add('cities');
        layers.add('units');
       
        loadTilemap();
    }

    function minimap() {
        $('#minimap').css('background-image', 'url("' +  baseurl + 'game/minimap?gid=' + gid + '")');
        $('#minimap').width(mapsizeX * 2);
        $('#minimap').height(mapsizeY * 2);
        $('#minimap .selection').width(tilesX * 2);
        $('#minimap .selection').height(tilesY * 2);
    }

    
    function changeMiniMap() {
        $('#minimap .selection').css('margin-left', mapoffsetX * 2 - 1);
        $('#minimap .selection').css('margin-top', mapoffsetY * 2 - 1);
    }




    function loadTilemap(args) {

        var params = {
            'class': 'map',
            'do': 'getMapTiles',
            'gid': gid,
            'offsetX': mapoffsetX,
            'offsetY': mapoffsetY,
            'screenTilesX': tilesX,
            'screenTilesY': tilesY,
            'cursorX': cursorX,
            'cursorY': cursorY
        }
        if(args) params = $.extend({}, params, args);


        $.post(gameurl, params,
            function( data ) {
                layers.clearAll();
                city = null;
                unit = null;
                $('.animation').remove();
                data = $.parseJSON(data);
                for (var j in data) {
                    for (var i in data[j]) {
                        var tile = data[j][i];
                        if (!tile) continue;
                        var _x = (i) * tileSize - offset;
                        var _y = (j) * tileSize - offset;
                        if(tile['terrain'] != 'water') {
                            layers.addTile('coast', 'coast', _x, _y);
                        }
                        if(tile['terrain'] && tile['terrain'] !== 'water' && tile['terrain'] != undefined && tile['terrain'] != '' ) {
                           layers.addTile('terrain', 'terrain_' + tile['terrain'], _x, _y);
                        }
                        
                        
                       
                        if(tile['startlocation']) {
                            layers.addTile('cities', 'startlocation', _x, _y);
                        }
                        
                        if(tile['city']) {
                           // tile['city'].pop = Math.floor(Math.random() * 20);
                            layers.addTile('cities', 'city_' + tile.city.style, _x, _y, getCityFrame(tile['city']));
                            drawCityInfo(_x - 9, _y - 6, tile['city']);
                            drawFlag(_x + 50,_y,tile['city'].flag, tile['city'].owner);
                            city = tile['city'];
                        }

                        if(tile['rivers']) {
                            for (var i in tile['rivers']) {
                                var frame = parseInt(tile['rivers'][i]);// if(frame === false) frame = 0;
                                layers.addTile('river', 'river', _x, _y, getRect(frame));
                            }
                        }

                        
                        
                        if(tile['improvement']) {
                            var imp = parseInt(tile['improvement']) - 1;                            
                            var layer = conf.improvements[imp].layer;
                            imp = conf.improvements[imp].img;
                            layers.addTile(layer, imp, _x, _y);                            
                        }
                        
                        if(tile['goody']) {
                            layers.addTile('mapobjects', tile['goody'], _x + 50, _y + 50);                            
                        }
                        
                        if(tile['road']) {  
                            var img = parseInt(tile['road']) - 1;
                            img = conf.roads[img].img;
                            for(var r in tile['roads']) {
                                var dim = parseInt(tile['roads'][r]); 
                                layers.addTile('roads', img, _x, _y, getRect(dim));
                            }/**/
                        }
                        


                        if(tile['unit']) {
                            unit = tile['unit'];
                            var animate = false;
                            if(tile['cursor']) animate = 'select';
                            if(unit['animation']) animate = unit['animation'];

                            drawUnit(tile['unit'],
                                {
                                    x: _x,
                                    y: _y,
                                    animation: animate
                                });
                            /*
                            unit = tile['unit']; 
                            var pos = getUnitPos({
                               'amount': unit.amount,
                               'tWidth':tileSize,
                               'uWidth': unit.gfx.width,
                            });
                            if(!unit.gfx.flagfirst) drawFlag(_x + 50, _y, unit.flag, parseInt(unit.owner), 'cities');
                            for(var p in pos) {
                                var ps = pos[p];

                                if(tile['cursor']) {
                                    animate({
                                        'x': _x + ps.x + 25,
                                        'y': _y + ps.y + 75,
                                        'animation': 'form-animation-select_' + unit.uid + '_1'
                                    });
                                } else {
                                    layers.addTile('units', 'u' + unit.uid, _x + ps.x + 25, _y + ps.y + 25);
                                }
                            }
                            if(unit.gfx.flagfirst) drawFlag(_x + 50, _y, unit.flag, parseInt(unit.owner), 'cities');   */
                        }
                        
                        if(tile['borders']) {      
                            for(var b in tile['borders']) {
                                layers.addTile('borders', conf.borders[tile['borders'][b]], _x, _y, false, tile['bordercolor']);
                            }
                        }

                        if(tile['cursor']) {
                            drawCursor(_x,_y + 50);
                            showCoords(tile);
                            currentTile = tile;
                        }
                    }
                }
                renderer.render(stage);
                _click = false;
            });
    }


    function drawUnit(unit, args) {
        var pos = getUnitPos({
            'amount': unit.amount,
            'tWidth':tileSize,
            'uWidth': unit.gfx.width,
        });
        if(!unit.gfx.flagfirst) drawFlag(args.x + 50, args.y, unit.flag, parseInt(unit.owner), 'cities');
        console.log(unit);
        console.log(args);
        for(var p in pos) {
            var ps = pos[p];
            if(args.animation) {
                var anim = 'select'; if(args.animation) anim = args.animation;
                var direction = '1'; if(unit.direction) direction = unit.direction;
                var x = args.x + ps.x + 25; if(unit.animpos) x = x + unit.animpos.x * 33;
                var y = args.y + ps.y + 75; if(unit.animpos) y = y + unit.animpos.y * 33;
                animate({
                    'x': x,
                    'y': y,
                    'animation': 'form-animation-' + anim + '_' + unit.uid + '_' + direction
                });
            } else {
                layers.addTile('units', 'u' + unit.uid, args.x + ps.x + 25, args.y + ps.y + 25);
            }
        }
        if(unit.gfx.flagfirst) drawFlag(args.x + 50, args.y, unit.flag, parseInt(unit.owner), 'cities');
        drawHP(100,args.x + 50, args.y);
    }
    
    function drawCursor(x,y) {
        cursoranimation = images[conf.startlocation];
        if(cursoranimation) { setCursorAnimation();
            addAnimation(cursoranimation, x,y, 'cursor blink'); 
        } else {
            addAnimation(getImg('cursor'), x,y, 'cursor');
        }
        return;
    }

    function drawHP(perc,x,y) {
        var gfx = new PIXI.Graphics();
        gfx.lineStyle(3, '0x000000')
            .moveTo(x + 15, y + 10)
            .lineTo(x + 46, y + 10);
        var px = Math.round(perc / 100 * 30);
        var color = '00ff00';
        if(px < 20) color = 'ffff00';
        if(px < 10) color = 'ff0000';
        gfx.lineStyle(3, '0x' + color)
            .moveTo(x + 15, y + 10)
            .lineTo(x + px + 15, y + 10);
        layers.addChild('cities',gfx);
    }

    function drawStartLocation(x,y) {
        var gfx = new PIXI.Graphics();
        gfx.lineStyle(5, 0x000000);
        gfx.drawRect(0, 0, 100, 100);
        gfx.lineStyle(3, 0xffffff);
        gfx.drawRect(0, 0, 100, 100);
        gfx.position.set(x, y);
        stage.addChild(gfx);
    }

    
    function drawFlag(x,y, flag, owner, layer) {
        if(owner == null) return;
        if(layer == null) layer = 'cities'
        var civ = game.players[owner].civ;
        //var flag = civs[civ].flag;
        layers.addTile(layer, flag, x, y);
        
        var color = game.players[owner].color;
        if(!color) color = conf.players[owner];        
        var gfx = new PIXI.Graphics();
        gfx.lineStyle(1, '0x' + color)
            .moveTo(x + 15, y + 10)
            .lineTo(x + 15, y + 56)
            .lineTo(x + 46, y + 56)
            .lineTo(x + 46, y + 10);
        layers.addChild(layer,gfx);
    }

    function getCityFrame(city) { 
        var frame = Math.floor(city.pop / 4); if(frame > 4) frame = 4;
        var x = frame * tileImgSize;
        var y = 0; if(city.walled) y = tileImgSize;
        return  new PIXI.Rectangle(x,y,tileImgSize,tileImgSize);
    }

    function drawCityInfo(_x,_y, city) {

        color1 = '0x' + city.color;
        color2 = 0xffffff;

        var txt = new PIXI.Text(city.pop, {
            fontSize : 20,
            fontFamily: 'Arial',
            fill : color2 //0xe79a39
        });
        txt.anchor.set(0.5, 0.5);
        txt.position.set(13,13);

        var gfx = new PIXI.Graphics();
        gfx.lineStyle(2, color1);
        gfx.beginFill(color1);
        gfx.drawRect(0,0,26,26);
        gfx.endFill();
        gfx.addChild(txt);
        gfx.position.set(_x + 10, _y + 130);


        var name = city.name;
        if(name.length > 11) {
            name = name.substring(0, 10) + "..";
        }
        var txt2 = new PIXI.Text(name, {
            fontSize : 20,
            fontFamily: 'Arial',
            fill : color2,
        });
        txt2.anchor.set(0, 0.5);
        txt2.position.set(10,13);
        var bounds = txt2.getBounds();


        var gfx2 = new PIXI.Graphics();
        gfx2.alpha = 0.6;
        gfx2.lineStyle(2, color1);
        gfx2.beginFill(0x000000);
        gfx2.drawRect(0,0,124,26);
        gfx2.endFill();
        gfx2.addChild(txt2);
        gfx2.position.set(_x + 36, _y + 130);



        stage.addChild(gfx2);
        stage.addChild(gfx);

    }

   
    function showCoords(tile) {
        var text = '[' + cursorX + ',' + cursorY + ']' + tile['terrain'];
        if(tile['city']) text = text + ', City of ' + tile['city'].name;
        $('#coords').html(text);
    }


    function moveMap() {
        if(cursorX < 0) cursorX = mapsizeX + cursorX; 
        if(cursorX >= mapsizeX) cursorX = cursorX - mapsizeX;
        if(cursorY < 0) cursorY = 0;
        if(cursorY > mapsizeY) cursorY = mapsizeY;

        mapoffsetX = cursorX - centerTileX;
        mapoffsetY = cursorY - centerTileY;

        if(mapoffsetX < 0) mapoffsetX = mapsizeX + mapoffsetX; ;
        if(mapoffsetY < 0) mapoffsetY = 0;
        if((mapoffsetY + tilesY) > mapsizeY) mapoffsetY = mapsizeY - tilesY;

        render();        
        changeMiniMap();
    }

    $(function() {
        $('canvas').click(function(e){
            if(_click) return; _click = true;
            var offset = $(this).offset();
            var dx = e.pageX - offset.left;
            var dy = e.pageY - offset.top;
            var diffX = Math.ceil( dx / tileSize );
            var diffY = Math.ceil( dy / tileSize );
            cursorX = mapoffsetX + diffX - 1;
            cursorY = mapoffsetY + diffY - 1;
            moveMap();    
        });
        
        
        $('.savemap').click(function(){
           var mapname = prompt('Filename');
           $.post(gameurl, {
                'class': 'map',
                'do': 'saveMap',
                'gid': gid,
                'name': mapname
            },function( data ) {       
            });
        });
    });

function updatePlayerInfo(id) {
    if(id == null) id = player;
    var pl = game.players[id];  

    var country = 0;
    if(pl.country) country = countries[pl.civ][pl.country];
    if(typeof(pl.name) === 'undefined' || pl.name == '') pl.name = country.ruler;

    var govt = 0 ;
    if(country && country.gov) govt = gov[country.gov];

    var civ = civs[pl.civ];

    var rel = conf.religion[0];//pl.religion];

    var color = pl.color;
    if(!color) color = conf.players[id];

    var text = country.title + ' ' + pl.name + ' of the ' + country.name + ' (' + civ.name + '),' + govt.name + ',' + rel.name;
    $('#playerdata .info').html(text);   
    $('#playerflag').attr('src', images[country.flag]);
    $('#playerflag').css('background-color', '#' + color);
}

// players
function playerDropdown(select) {
   $(select).html('');
    for (var i in game.players) {
        var pl = game.players[i];
        var country = countries[pl.civ][pl.country];     
        pl.name = country.ruler;
        var title =  country.title + ' ' + pl.name + ' of the ' + country.name;
        $(select).append('<option value="' + i + '">' + title + '</option>');
    }
} 

</script>


<?php include('editor.tpl.php') ;?>
