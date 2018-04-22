<?php 
	include('config.php');
	//include('loadmap.php');
 ?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<script src="scripts/ext/jquery.min.js"></script>
	<script src="scripts/ext/phaser.min.js?tghf"></script>
  <meta charset="UTF-8">
  <title>Webciv</title>
	<style>
		<?php include('style.php');?>
	</style>
</head>
<body>
<?php include('gui.php');?>
<div id="content">
 <script>
<?php 
	$data = "var screen = $.parseJSON('" . json_encode($screen) . "');";
	file_put_contents('scripts/game.screen.js', $data);

	include('scripts/game.config.js'); 
	/*include('scripts/game.map.js');
	include('scripts/game.screen.js');*/

	include('script.php');
?>
 </script>
 </div>
 </body>
 </html>