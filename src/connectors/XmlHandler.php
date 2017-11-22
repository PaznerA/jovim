<?php

namespace vmprim\src\connectors;



class XmlHandler
{
    private $adapter;
    private $productClass;
    private $filePath;

    public $lastObj;




    public function __construct(AdapterInterface $adapter,$filePath)
    {

        $log = new \StdClass();
        try{
            $fileData = simplexml_load_file($filePath);
            $this->adapter=$adapter;
            $this->adapter->setData($fileData);
        } catch (\Exception $exception) {
            var_dump($exception);
            trigger_error('Error reading XML file', E_USER_ERROR);
        }

    }

    public function getNextProduct(){
        return $this->adapter->getNextProduct();
    }


}