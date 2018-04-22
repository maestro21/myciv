<?php
include('config.php');
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
		$mapname = (isset($_GET['map']) ? $_GET['map'] : 'worldmap');
		$map = new map();
		$map->loadmap($mapname); 
		//$map->map = $map->loadmap($mapname);print_r($map->map); die();
		if($map) {
			$tiles = $map->getMapTiles();
			echo json_encode($tiles);
		}
	break;	

}