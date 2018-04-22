
function getUnitPos(args) {    
    if(!args.amount)  args.amount = 1;
    if(!args.tWidth)  args.tWidth = 150;
    if(!args.tHeight) args.tHeight =  args.tWidth;
    if(!args.uWidth)  args.uWidth = 120;
    if(!args.uHeight) args.uHeight = args.uWidth;
    
    if(args.amount < 1) args.amount = 1;
    if(args.amount > 6) args.amount = 6;
    if(args.amount == 5) args.amount = 6;
    
    args.uWidth = Math.round(args.uWidth / 2);
    args.uHeight = Math.round(args.uHeight / 2);
    
/*    var ret = [];
    
    if(args.amount < 4) {
        dy = Math.round((args.tHeight - args.uHeight) / 2);
    }
    if(args.amount == 1) {
        dx = Math.round((args.tHeight - args.uHeight) / 2);
    } */
    
    ret = [];

    dy = Math.ceil(args.amount / 3);
    dx = args.amount / dy;
    
    console.log(args.amount  + ' ' + dx + ' ' + dy);


    for(j = 1; j <= dy; j++) {
        py = args.tHeight / (dy * 2);
        if(j > 1) py *= 3;
        py = py - args.uHeight;
        for(i = 1; i <= dx; i++) {
           px = args.tWidth / (dx * 2);
           if(i > 1) px *= 1 + ((i-1) * 2);
           px = px - args.uWidth;
           ret.push({'x':px, 'y':py});
        }
    }

    
    return ret;
    //console.log(args.amount + ' x:' + dx + ' y:' + dy);
}


function animate(data) {
    $('<div/>')
        .addClass('animation anim-' + data.animation)
        .css('top', data.y + 'px')
        .css('left', data.x + 'px')
        .appendTo('.page-wrapper');
}


function unit_move(direction){ console.log(unit); console.log(direction);
    $.post(gameurl, {
        'class': 'units',
        'do': 'moveUnit',
        'gid': gid,
        'data': {'unit':unit, 'direction':direction},
        'x': cursorX,
        'y': cursorY
    }).done(function(res) {
        res = parseJSON(res);
        if(res.fight) {
            res.direction = direction;
            animateFight(res);
        } else if(res.status == 'ok' && res.animation) {
            cursorX = res.movedto.x;
            cursorY = res.movedto.y;
            var selector = 'animation move' + direction + ' anim-form-animation-move_' + unit.uid + '_' + res.animation.row;
            $('.animation').removeClass().addClass(selector);
            res.direction = direction;

        }
    });
}

/*
    TODO:
        1. drawTiles instead of animateFight
        2. do not move but start figting
 */

function animateFight(res){
    loadTilemap({
        'animation' : res.animation,
        'direction': res.direction,
    });
    console.log(res);
    loopFight(res)
    /*
  //  var targetTile = { 'x' : cursorX + res.animation.x, 'y' : cursorY + res.animation.y;
    $.post(gameurl, {
            'class': 'map',
            'do': 'getUnitTiles',
            'gid': gid,
            'offsetX': mapoffsetX,
            'offsetY': mapoffsetY,
            'screenTilesX': tilesX,
            'screenTilesY': tilesY,
            'cursorX': cursorX,
            'cursorY': cursorY,
            'animation' : res.animation,
            'direction': res.direction,
        },
        function( data ) {
            data = $.parseJSON(data);
            console.log(data);
            layers.clear('units');
            for (var j in data) {
                var _y = (j) * tileSize - offset;
                for (var i in data[j]) {
                    var _x = (i) * tileSize - offset;
                    var unit = data[j][i];
                    drawUnit(unit, {
                        'x': _x,
                        'y': _y,
                        'animate': unit.animate,
                        'animation': 'attack',
                        'direction': unit.direction
                    });
                }
            }
            renderer.render(stage);
            // hitpoint + death animation
        });
    */
    //var selector = 'animation attack' + res.attacker.direction + ' anim-form-animation-attack_' + res.attacker.uid + '_' + res.animation.row;
    //$('.animation').removeClass().addClass(selector);
}

function loopFight(res) {
    console.log(res);
    if(res.fight.length == 0) {
        return;
    }
    var hit = res.fight.shift();
    var x = cursorX - mapoffsetX;
    var y = cursorY - mapoffsetY;
    var hp = hit.hp * 10;

    if(hit.u == 2) {
        x = x + res.animation.x;
        y = y + res.animation.y;
    }
    x = x  * tileSize - offset + 50;
    y = y * tileSize - offset;
    drawHP(hp,x,y);
    renderer.render(stage);

    setTimeout(function() {
        loopFight(res);
    }, 1000)
}