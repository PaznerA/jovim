<?php
namespace vmprim\src\connectors;


interface AdapterInterface
{

    /**
     * @param $rawData
     *      basically anything that you can adapt into Jovim class
     * @return mixed
     */
    function setData($rawData);

    function getNextProduct();

    function printData($data = false);

}