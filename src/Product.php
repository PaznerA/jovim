<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15.11.2017
 * Time: 20:56
 */

namespace vmprim\src;

use vmprim\src\extensions\Prices as Price;

class Product extends Vmprim
{
    private $customfieldsList;
    private $categoriesList;
    private $manufacturersList;
    private $pricesList;
    private $mediaList;

    public function __construct($dbPrefix, $sourceString = "")
    {
        parent::__construct($dbPrefix, $sourceString);
    }


    public function addCustomfield($data){
        $field=new Price($data);
        $this->pricesList[]=$field;
    }


}