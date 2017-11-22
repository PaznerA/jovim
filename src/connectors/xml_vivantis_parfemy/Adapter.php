<?php

namespace vmprim\src\connectors\xml_vivantis_parfemy;

use vmprim\src\connectors\xml_vivantis_parfemy\helper;
use vmprim\src\connectors\AdapterInterface;
use vmprim\src\connectors\DataWriter;
use vmprim\src\extensions\BasicCategory;
use vmprim\src\extensions\external\VivantisPriceHistory;
use vmprim\src\extensions\ProductCategory;
use vmprim\src\extensions\ProductCustomfield;
use vmprim\src\Product;

class Adapter implements AdapterInterface
{
    private $dataWriter;
    private $dataObj;
    private $indexedCategories=[];
    private $indexedManufacturers=[];
    private $indexedCustomfields=[];
    private $indexedCollections=[];
    private $categoryHelper;


    public $enabledExternals=[];
    public $productIterator=0;
    public $name="Vivantis_xml";



    public function __construct($db_settings)
    {
        $this->productIterator=0;
        $this->categoryHelper=new helper\CategoryHelper();
        $this->dataWriter=new DataWriter($db_settings);
        $this->enabledExternals["VivantisPriceHistory"]=new VivantisPriceHistory();
    }

    public function setData($rawData){
        $this->setDataObj($rawData);
    }


    public function getNextProduct(){
        if(array_key_exists($this->productIterator,$this->dataObj->products)){
            $prod=$this->dataObj->products[$this->productIterator];
            $this->productIterator++;
            return $prod;
        }
        return false;
    }

    public function printData($data=FALSE)
    {
        if(!$data){
            $data=$this->dataObj;
        }
        echo "<pre>";
        echo (var_export($data,true));
        echo "</pre>";
    }

    public function createCategories()
    {
        $categories=[];
        if(isset($this->dataObj->categories) && is_array($this->dataObj->categories)){
            foreach ($this->dataObj->categories as $counter => $item) {
                $category=new BasicCategory();
                $categories[]=$category;
                $this->indexedCategories[$item->category_id]=$item;
            }
            return $categories;
        }
        return false;

    }

    public function createCollections()
    {
        $collections=[];
        if(isset($this->dataObj->collections) && is_array($this->dataObj->collections)){
            foreach ($this->dataObj->collections as $counter => $item) {
                $collection=new \stdClass();
                $collection->id=$item['id'];
                $collection->parent_id=$item['parent_id'];
                $collection->name_cs_cz=$item['name_cze'];
                $collections[]=$collection;
                $this->indexedCollections[$collection->id]=$item;
            }
            return $collections;
        }
        return false;

    }

    private function writeVivantisPriceLog(){


    }


    public function routine()
    {
        $queriesList=[];

        $products=[];
        $customfields=[];

        // for writting manually categories
        //$this->add2array($queriesList,$this->categoryHelper->getNewCategoriesQuery());

        while ($prod=$this->getNextProduct()){
            $product = new Product();
            $product->basicData->product_sku=$prod["product_code"];
            $product->basicData->product_mpn=$prod["product_ean"];
            var_dump($prod); die();



            foreach ($prod['product_parameters'] as $singleParam){
                $parameter=new ProductCustomfield();
                $customfields[]=$parameter;
            }
            $product->customfieldsList=$customfields;
            $products[]=$product;
        }
        //var_dump($products); die();
    }

    private function setDataObj($rawData){
        $parser=new Parser();
        $this->dataObj=$parser->readXML($rawData);
    }

    private function add2array($destinationArray,$items2add){
        if(is_array($destinationArray) && is_array($items2add)){
            foreach ($items2add as $key => $item) {
                if(array_key_exists($key,$destinationArray)){
                    $destinationArray[]=$item;
                }
                else{
                    $destinationArray[$key]=$item;
                }
            }
            return true;
        }
        return false;
    }




}