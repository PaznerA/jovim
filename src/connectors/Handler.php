<?php

namespace vmprim\src\connectors;


class Handler
{
    public $adapter;
    private $productClass;
    private $filePath;
    private $db_settings;

    public $lastObj;


    //TODO: implement loading adapters anonymously
    public function __construct($db_connection)
    {
        $this->db_settings =$db_connection;
        $log = new \StdClass();
        try {

            // SET ADAPTER BY FEED NAME
            switch (FEED_NAME) {
                case "parfemy":
                    $adapter = new\vmprim\src\connectors\xml_vivantis_parfemy\Adapter($db_connection);
                    $feedPath = DATA_PATH . DS . "feed-parfemy.xml";
                    break;

                case "sperky":
                    $adapter = new\vmprim\src\connectors\xml_vivantis_sperky\Adapter($db_connection);
                    $feedPath = DATA_PATH . DS . "feed-sperky.xml";
                    break;

                default:
                    error_log("Cannot find feed data!", E_USER_ERROR);
                    die();

            }


            $fileData = simplexml_load_file($feedPath);
            $this->adapter = $adapter;
            $this->adapter->setData($fileData);
        } catch (\Exception $exception) {
            var_dump($exception);
            trigger_error('Error reading XML file', E_USER_ERROR);
        }

    }

    public function getNextProduct()
    {
        return $this->adapter->getNextProduct();
    }


}