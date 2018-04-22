.game_menu {
    margin: 100px auto;
    width: 400px;
    background-color:white;
    border-radius:10px;
    text-align: center;
    padding:50px;
    text-align:center;
}


.game_menu a {
    display: inline-block;
    margin: 25px;
    font-size: 30px;
}

.games a {
    margin-right:20px;
    display:inline-block;
    font-weight: bold !important;
}

.game canvas {
    position:fixed;
    top:50px;
    left: 0px;
}


#gamecontrol {
    position: fixed;
    z-index:2;
    bottom: 0;
    width: 100%;
    height: 200px;
    left:0;
    box-shadow: 0px 0px 5px -1px #000000;
}

.animation {
    z-index: 99;
    position: fixed;
}

.editsections {
    display: none;
}

.active {
    background-color: white;
}
.del {
    background-color: red;
}

#playerdata {
    height: 35px;
    width: 100%;
    position: fixed;
    top: 50px;
    z-index: 2;
    left: 0;
}

#playerdata div {
    display: inline-block;
    padding: 7px;
    font-weight: 600 !important;
}

#playerdata img {
    vertical-align: top;
    border: 1px black solid;
    border-top: none;
}



<?php $tilesize = 100; ?>

.moveright          { transform: translate(<?=$tilesize;?>px,0px); transition: transform  1s ease-in-out; }
.moveleft           { transform: translate(-<?=$tilesize;?>px,0px); transition: transform  1s ease-in-out; }
.movetop            { transform: translate(0px,-<?=$tilesize;?>px); transition: transform  1s ease-in-out; }
.movebottom         { transform: translate(0px,<?=$tilesize;?>px); transition: transform  1s ease-in-out; }

.movetopleft        { transform: translate(-<?=$tilesize;?>px,-<?=$tilesize;?>px); transition: transform  1s ease-in-out; }
.movetopright       { transform: translate(<?=$tilesize;?>px,-<?=$tilesize;?>px); transition: transform  1s ease-in-out; }
.movebottomleft     { transform: translate(-<?=$tilesize;?>px,<?=$tilesize;?>px); transition: transform  1s ease-in-out; }
.movebottomright    { transform: translate(<?=$tilesize;?>px,<?=$tilesize;?>px); transition: transform  1s ease-in-out; }
