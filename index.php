<?php

require_once __DIR__ . "/src/config/config-dev.php";
require_once __DIR__ . "/vendor/autoload.php";

$db_connection = [
    'charset' => 'utf8',
    'driver' => 'mysqli',
    'host' => 'localhost',
    'username' => db_username,
    'password' => db_password,
    'database' => db_database,
    'prefix'=>'deine_',
];
define("DS", "/");
//define("APP_URL", "http:/superlook.cz/.../jovim");
define("APP_URL", "http://my.git/vmImporter/jovim");
//define("APP_PATH", $_SERVER["DOCUMENT_ROOT"]."/www/vivanis/new");
define("APP_PATH", $_SERVER["DOCUMENT_ROOT"].DS.'vmImporter'.DS.'jovim');
define("DATA_PATH", APP_PATH.DS."feed");



// MINI ROUTER AND CONSTANTS SETTER
if(isset($_GET['f']) && strlen($_GET['f']) > 1){
    define("FEED_NAME", $_GET['f']);
    if(isset($_GET['multilang'])){
        define("FEED_MULTILANG", true);
    }else{
        define("FEED_MULTILANG", false);
    }
    if(isset($_GET['lang']) && strlen($_GET['lang']) > 1){
        define("FEED_LANG", $_GET['lang']);
    }else{
        define("FEED_LANG", false);
    }
}

//INITIALIZE DATA HANDLERS
$dataHandler = new \vmprim\src\connectors\Handler($db_connection);


echo(time() . ' | JOB STARTED'.'<br>');


//DEBUG
//$dataHandler->adapter->printData();



//RUN AUTOMATICALLY BY ADAPTER CLASS
$dataHandler->adapter->routine();


echo(time() . ' | JOB FINISHED');