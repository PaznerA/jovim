<?php
namespace vmprim\src\connectors;

//TODO: implement tests
interface AdapterInterface
{

    /**
     * @param $rawData
     *      basically anything that you can adapt into Jovim class
     *      every connector implementing this interface should be added into
     *      SWITCH constructor of jovim/src/connectors/Handler
     * @return mixed
     */
    function setData($rawData);

    function getNextProduct();

    function printData($data = false);

}