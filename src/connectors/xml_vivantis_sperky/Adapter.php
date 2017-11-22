<?php
namespace vmprim\src\connectors\xml_vivantis_sperky;

use vmprim\src\connectors\AdapterInterface;
use vmprim\src\connectors\DataWriter;
use vmprim\src\extensions\ProductCustomfield;
use vmprim\src\Product;

class Adapter implements AdapterInterface
{
    private $dataWriter;
    private $dataObj;
    private $indexedCategories=[];
    private $indexedManufacturers=[];


    public $productIterator=0;
    public $name="Vivantis_xml";



    public function __construct($db_settings)
    {
        $this->productIterator=0;
        $this->dataWriter=new DataWriter($db_settings);
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

    public function createProductCustomfields()
    {
    }

    public function routine()
    {

        $categories=$this->createCategories();
        if($categories){
            foreach ($categories as $singleCategory){
                $this->dataWriter->CreateUpdateCategory($singleCategory);
            }
        }
        $products=[];
        while ($prod=$this->getNextProduct()){
            $product = new Product();
            $product->basicData->product_sku=$prod["product_code"];
            $product->basicData->product_mpn=$prod["product_ean"];
            $customfields=[];
            foreach ($prod['product_parameters'] as $singleParam){
                $parameter=new ProductCustomfield();
                $customfields[]=$parameter;
            }
            $product->customfieldsList=$customfields;
            $products[]=$product;
        }

    }

    private function setDataObj($rawData){
        $parser=new Parser();
        $this->dataObj=$parser->readXML($rawData);
    }




}