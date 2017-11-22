<?php
define("APP_PATH", $_SERVER["DOCUMENT_ROOT"]."/www/updater/");
define("DATA_PATH", APP_PATH."feed/");

$options = [
    'driver'   => 'mysqli',
    'host'     => 'localhost',
    'username' => 'homestead',
    'password' => 'secret',
    'database' => 'dbname',
    'charset'  => 'utf8',
    'prefix'   => ''
];

