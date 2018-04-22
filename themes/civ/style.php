body,
.header ul li ul a {
background: url('<?php echo BASE_URL . tpath(); ?>img/bg.png');
}

.gamebg {
    background: url('<?php echo BASE_URL . tpath(); ?>img/bg.png');
    border: 3px <?php echo $mainColor; ?> solid;
    border-radius:5px;
}

body {
    padding-top: 50px !important;
    cursor:url('<?php echo BASE_URL . tpath(); ?>img/cursor.cur'), default;
}

.logo a img {
content:url('<?php echo BASE_URL . tpath(); ?>img/logo.png');
}

.header,
.footer {
background-color: rgba(123,90,45, 0.5);
}
.header a, .footer .wrap, .footer a {
background:transparent;
}

* {
font-weight: normal !important;
}

.header .wrap {
    height: 50px;
}

.logo a, .logo a img {
    margin: 5px !important;
    height: 40px;
    padding: 0 !important;
}

.menu a {
    padding: 15px 20px;
}

.header {
    position: fixed;
    z-index: 100;
    width: 100%;
    box-shadow: 0px -1px 5px 1px #000000;
    height: 50px !important;
    top: 0;
}

.header .wrap div {
    margin:0;
}
.header .wrap div.login {
float: right;
}

.header ul li ul a {
    display: block;
}

#gamecontrol {
    position: fixed;
    z-index:2;
    bottom: 0;
    width: auto;
    left:0;
    display:inline-block;
}

#minimap {
    width: 150px;
    height: 150px;
    background-repeat: repeat-x;
    background-color: black;
    border: 1px <?php echo $maincolor; ?> solid;
}

#minimap .selection {
    border: 1px white solid;
        position: absolute;
    
}

.editpanel {
position: fixed;
/*top: 50px;
left: 0;
z-index: 5;*/
top: 5px;
    left: 50%;
    z-index: 999;
}
.editpanel .fa {
padding: 10px;
}

.editpanel .fa:hover {
    background-color: white;
}



#coords {
    /* position: absolute;
    top: -30px; */
    padding: 5px;
}


.cursor {
    animation: cursor 1s steps(12) infinite;
}
@keyframes cursor {
    from { background-position:    0px; }
    to { background-position: 1806px; }
}



.blink {
animation: blink 1s linear infinite;
}
@keyframes blink {
50% { opacity: 0; }
}