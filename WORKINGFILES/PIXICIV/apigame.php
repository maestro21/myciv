<?php
include('config.php'); //print_r($config);
include('map.php');

$do = $_GET['do'];

switch($do) {
	
	case 'getRandomMap':
		$map = new map();
		$map->randomMap();
		$tiles = $map->getMapTiles();
		echo json_encode($tiles);
	break;	
	
	case 'loadmap':
		$mapname = (isset($_GET['map']) ? $_GET['map'] : 'bigmap');
		$x = @$_GET['x'];
		$y = @$_GET['y'];
		$map = new map();
		$map->loadmap($mapname, $x, $y); 
		//$map->map = $map->loadmap($mapname);print_r($map->map); die();
		if($map) {
			$tiles = $map->getMapTiles();// print_r($map->map);
			echo json_encode($tiles);
		}
	break;	
	
	
	//case 
}