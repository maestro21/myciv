<?php 
	include('config.php'); 
	//include('loadmap.php');
 ?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>	
    <script src="ext/jquery.min.js"></script>
	<script src="ext/pixi-4.2.2.js"></script>
	<script src="ext/pixi-tilemap.min.js"></script>
	<meta charset="UTF-8">
	<title>Webciv</title>
	<style>
		<?php include('style.php');?>
	</style>
</head>
<body style="background:url('img/water2.gif');">
<?php //include('gui.php');?>
		<!--<div id="cp">
			<canvas id="minimap" width=100 height=100></canvas>	
			<div id="console"></div>	
		</div>-->
<div id="content" class="map">
 <script> 
<?php 
	include('data/game.config.js'); 
	//include('data/game.map.js');

	include('script.php');
?> 
 </script>
 </div>
 </body>
 </html>