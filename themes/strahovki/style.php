.logo img {
	content:url(<?php echo BASE_URL . tpath(); ?>logo.png);
	padding:0;
	margin: 0;
}
submenu ul {
	padding-left: 0;
}

li {
	list-style: none;
}

*,
h1,h2,h3,h4,h5,h6,
.menu a, .submenu a
{
	font-family: 'Raleway',  sans-serif;	
}	
body {
	font-family: 'Raleway',  sans-serif;
	font-size:15px;
	line-height:23px;
	min-height: 100%;
	position: relative;
}

.header {
	margin: auto;
	box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    -khtml-box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    -webkit-box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    -moz-box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    -ms-box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    -o-box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    transition: padding 0.35s ease;
    -khtml-transition: padding 0.35s ease;
    -webkit-transition: padding 0.35s ease;
    -moz-transition: padding 0.35s ease;
    -ms-transition: padding 0.35s ease;
    -o-transition: padding 0.35s ease;
    background-color: <?php echo $mainColor;?>;
	text-align: center;
}

.header .wrap {
	width: auto;
    display: inline-block;
    margin: auto;
	height: 43px;
}

	.menu {
		height: 50px;
		width: 1200px;
		color: white;
	}

	
	.menu .fa {
		margin-right: 3px;
	}
	
	.menu .phone {
		color: white  !important;
		font-size: 1.3em;
		font-weight: bold;
		margin-left: 20px;
		margin-top: 12px;
		display: inline-block;
	}	
	.menu .phone * {
		color: white !important;
	}

	.menu a {		
		text-transform: uppercase;
		font-size: 15px;
		text-decoration: none;
		margin: 15px;
		display: inline-block;		
		font-weight: 500;
		color: white;
		padding: 0;
	}
	
	.langs {
		display: inline-block;		
	}
	
	.langs a {
		margin: 15px 10px;
	}
	
	
.menu .logo {
	position: absolute;
	margin:0;
	margin-left: -100px;
}

.menu {
	padding-left: 100px;
}

/** DROPDOWN **/

.menu a:hover {
	color: white !important;
	background-color: transparent !important;
}

/* Dropdown Content (Hidden by Default) */
.dropdownmenu .topmenu ul {
    visibility: hidden; 
    position: absolute;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	border-bottom: 3px <?php echo $mainColor;?> solid; 
	background-color: white !important;
	z-index: 99;
	
	transform: translateY(0);
    transition: all 0.2s ease;
}

/* Show the dropdown menu on hover */
.dropdownmenu:hover .topmenu ul {
    visibility: visible;	
	transform: translateY(-15px);
    transition-delay: 0s, 0s, 0.3s; 
}


/* Links inside the dropdown */
.topmenu ul a {
    color: <?php echo $textColor;?>;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
	margin: 0;
	text-transform: none;
	border-bottom: 1px solid #e0e0e0;
	background-color: white !important;
}

/* Change color of dropdown links on hover */
.topmenu ul a:hover {
	color: <?php echo $textColor;?> !important;
	background-color: #f1f1f1 !important;
}


/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdownmenu:hover .dropbtn {
    background-color: #3e8e41;
}

.footer,
header,
.bss-slides,
figure img {
	min-width: 1200px;
}


.bss-slides {
	top: -20px;
}

.bss-slides figcaption {
	top: 50px;
	background: transparent !important;
	left: 20%;
	color: #4a4a4a;		
	font-size: 30px;
}

.bss-slides figcaption p {
	margin: 0;
	font-weight: 100;	
	margin-bottom: 30px;
}

.bss-slides figcaption h1 {	
	text-transform: uppercase;	
	font-size: 30px;
	font-weight: normal;
	margin: 0;
	color: #4a4a4a;
}


/** front **/
.whiteline {
	width: 100%;
    display: block;
    position: absolute;
    height: 100px;
   /* background-color: rgba(255,255,255,0.8);*/
    background: linear-gradient(to top, rgba(255,255,255,1), rgba(255,255,255,0.8));
    margin-top: -100px;
    z-index: 99;
	text-align: center;
}

.whiteline .table {
	margin-top: -50px;
	position: relative;
	table-layout: fixed;
}

.subtext {
	color: <?php echo $textColor;?> !important;
}


.whiteline a {
	text-decoration: none;
}
.whiteline a:hover p {
	color: <?php echo $mainColor;?> !important;
}

.whiteline a i {
    width: 90px;
    height: 90px;
    border: 5px solid white;
    background-color: <?php echo $mainColor;?>;
    color: #fff;
    font-size: 2.5em;
    text-align: center;
    vertical-align: middle;
    line-height: 85px;
    border-radius: 100%;
    margin-bottom: 5px;
    -webkit-transition: 0.2s ease-in-out;
    -moz-transition: 0.2s ease-in-out;
    -ms-transition: 0.2s ease-in-out;
    -o-transition: 0.2s ease-in-out;
    transition: 0.2s ease-in-out;
	box-shadow: 0 0 1pt 1px <?php echo $mainColor;?>;
}
.whiteline a i:hover {
	background-color: white;
	color: <?php echo $mainColor;?>;
	border: 5px solid <?php echo $mainColor;?>;
}

.first h1 {
	display:none;
}

figure {
	margin: 0;
}

.footer,
header,
.bss-slides,
figure img {
	min-width: 1200px;
}




.contact-us {
    position: fixed;
    top: 50%;
    right: -80px;
    transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    background-color: <?php echo $mainColor; ?>;
    color: #ffffff;
    border-radius: 3px;
    font-weight: 600;
    display: block;
    width: 189px;
    height: 55px;
    text-align: center;
    line-height: 4.5;
    z-index: 100;
	text-decoration: none;
}

.contact-us:hover {
    right: -68px;
    color: #ffffff;
}

.contact-us i {
    margin-right: 10px;
    font-size: 1.2em;
}

a,
a *{
	color: <?php echo $mainColor; ?>;
	font-weight: normal;
}



.content {
	display: inline-block;
	width: 790px;
	padding: 50px;
}


.submenu {
	width: 300px;
	display: inline-block;	
	vertical-align: top;
}

.submenu ul {
	padding: 0;
}


.submenu li a {
	padding: 7px 0;
	text-decoration: none;
	display: block;
	
}

.submenu li a:hover,
.submenu li .selected {
	background-color: <?php echo $linkColor; ?>;
	color: white;
}

.submenu a:before {
	display: inline-block;
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    content: "\f105";
    margin-right: 8px;
	margin-left: 8px;
}

h1 {
    text-transform: uppercase;
    font-size: 25px;
    font-weight: normal;
    padding: 30px 0;
}

.bigPic {
	width: 800px;
    border-radius: 20px;
}


.footer {
	border-top: 1px solid #d2d2d2;
	background-color: <?php echo $mainColor;?>;
	color: white;
	position: absolute;
	right: 0;
	left: 0;
}

.footer * { 
	color: white;
}

.footer .wrapper {
	width:1200px;
	margin-left: auto;
    margin-right: auto;
	color: white;
	padding-top: 10px;
}


.faList  {
	margin-top: 10px;
}

.faList li {
	padding-left: 25px;
	margin-bottom: 10px;
}

.faList li:before {
	font-family: FontAwesome;
	content: "\f111";
	color: <?php echo $mainColor; ?>;
	font-size: 0.714em;
	margin: 0px 15px;
	margin-left: -25px;
}

.circle {
	width:130px;
	height:130px;
	overflow:hidden;
	border-radius:50%;
	display: inline-block;
	margin: 10PX;
}

.info {
	display: inline-block;
	width: 600px;
}
h2 {
    text-transform: uppercase;
    font-size: 17px;
}

.content div div {
	vertical-align: top;
}

.half {
	display:  inline-block;
	width: 49.5%;
	vertical-align: top;
}


.icons li{
	margin-bottom: 40px;
	padding-top: 1px;
	height:60px;
}


.icons .fa.icon {
    float: left;
    width: 60px;
    height: 60px;
	background-color: <?php echo $mainColor; ?>;
    color: white;
    border: 4px solid white;
    font-size: 2em !important;
    text-align: center;
    vertical-align: middle;
    line-height: 56px;
    border-radius: 100%;
    margin-right: 10px;
	font-family: FontAwesome;
	margin-top:11px;	
	box-shadow: 0 0 1pt 1px <?php echo $mainColor;?>;
}	

.icons a {
	text-decoration: none;
	margin-top: 30px;
	display: inline-block;
	    width: 270px;
    text-align: left;
}

.tabContent {
	top: -100px;
    position: relative;
}


.main {
		padding-bottom: 100px;
}

.submit {
	width: 300px;
}

form td {
height: 50px;
}

#form textarea {
	width: 500px;
	min-width: 500px !important;
}

.lbl {
	width:200px;
}

#form table input {
	width: 300px;
	margin: 0;
 }
 
 .roundImg {
	     width: 450px;
    border-radius: 10px;
 }
 
.coop {
	margin-bottom: 50px;
	padding-left: 0;
}

.coop  li {
	margin-bottom: 20px;
}

.coop li:before {
	content: "\f00c";
	font-size: 15px;
	margin-left: -30px;
}

.vertical li {
	display: inline-block;
	width: 33%;
}

.left {
	text-align: left;
}


.day {
	width: 50px !important;
}

.month {
	width: 132px !important;
}

.year {
	width: 90px !important;
}

form .half {
	display: inline-block;
	vertical-align: top;
}

label.error {
	position: absolute;
	z-index: 111;
	margin-top: -5px;
}

.contact-us * {
	color: white !important;
}

.tabContent li {
	text-transform: uppercase !important;
}


figure h1 {
	display: block !important;
}

.btn {
    display: inline-block;
    padding: 10px 50px;
    text-decoration: none;
    font-weight: 100;
    font-size: 25px;
    border-radius: 5px;
    color: white;
    cursor: pointer;
	margin: 0;
}

form .btn  {
	font-size: 15px;
	padding: 5px 10px;
	margin: 5px 0px;
}