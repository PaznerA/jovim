<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15.11.2017
 * Time: 20:56
 */

namespace vmprim\src;

use vmprim\src\extensions;

class Product
{
    private $priceClass;
    private $customfieldClass;
    private $manufacturerClass;
    private $categoryClass;

    public $basicData;
    public $customfieldsList=[];
    public $categoriesList=[];
    public $manufacturersList=[];
    public $pricesList=[];
    public $mediaList=[];

    public function __construct()
    {
        $this->basicData=new \stdClass();
//        $this->priceClass=new extensions\ProductPrice();
//        $this->customfieldClass=new extensions\ProductCustomfield();
//        $this->manufacturerClass=new extensions\ProductManufacturer();
//        $this->categoryClass=new extensions\ProductCategory();
    }


    public function addPrice($data){
//        $price=$this->priceClass->setData($data);
//        $this->pricesList[]=$price;

    }



}