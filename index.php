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

/*
 *
 * when working with auto redirect into root index
 *


$req_array = explode("/", str_replace(APP_URL,'',$_SERVER["REQUEST_URI"]));
if(isset($req_array[1]) && strlen($req_array[1]) > 1){
    define("FEED_NAME", $req_array[1]);
    if(isset($req_array[2]) && strlen($req_array[2]) > 1){
        if($req_array[2]=="1" || $req_array[2]=="true" || $req_array[2]=="multilang"){
            define("FEED_MULTILANG", true);
        }
    }
}

*/


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




// SET ADAPTER BY FEED NAME
switch (FEED_NAME){
    case "parfemy":
        $adapter = new\vmprim\src\connectors\xml_vivantis_parfemy\Adapter($db_connection);
        $feedPath=DATA_PATH.DS."feed-parfemy.xml";
    break;

    case "sperky":
        $adapter = new\vmprim\src\connectors\xml_vivantis_sperky\Adapter($db_connection);
        $feedPath=DATA_PATH.DS."feed-sperky.xml";
        break;

    default: error_log("Cannot find feed data!",E_USER_ERROR);
}

//var_dump($feedPath,$adapter); die();

//INITIALIZE DATA HANDLERS
$dataHandler = new \vmprim\src\connectors\XmlHandler($adapter,$feedPath);




echo(time() . ' | JOB STARTED'.'<br>');




//DEBUG
$adapter->printData();









//RUN AUTOMATICALLY BY ADAPTER CLASS
$adapter->routine();







/*
 * OR YOUR OWN ROUTINE WITHOUT NEW CLASS CREATION
 */
/*
while ($product=$adapter->getNextProduct()){
    $adapter->printData($product);
}
*/

echo(time() . ' | JOB FINISHED');