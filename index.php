<?php


define("ACTION", "import");
define("SUB_ACTION", "sperky");

require_once "src/config.php";

require_once "src/Vmprim.php";
require_once "src/Product.php";
require_once "src/extensions/Categories.php";
require_once "src/extensions/Customfields.php";

use vmprim\src as VirtuemartProductImporter;

$db_prefix = "g9rqb_";


$productHandler     = new VirtuemartProductImporter\Product($config["dbPrefix"]);
$paramHandler       = new VirtuemartProductImporter\Customfields($config["dbPrefix"]);
$categoryHandler    = new VirtuemartProductImporter\Category($config["dbPrefix"]);

echo("APP RUNNING");
