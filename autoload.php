<?php 


session_name("engine");
session_start(); 

require_once('settings.php');
require_once(BASE_PATH . "engine/functions/functions.php");
require_once(BASE_PATH . "engine/db/db.query.class.php");
require_once(BASE_PATH . "engine/db/db." . DB_TYPE . ".class.php");
require_once(BASE_PATH . "engine/db/db." . DB_TYPE . ".functions.php");
require_once(BASE_PATH . 'engine/class.masterclass.php');
require_once(BASE_PATH . 'engine/class.cachemasterclass.php');
require_once(BASE_PATH . 'engine/class.filemanager.php');
require_once("functions.php");
//dbempty();dbrestore();
installationCheck();


getGlobals();


DBbackup();

$_SESSION['headerlinks'] = array();
