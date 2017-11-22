<?php

namespace vmprim\src\connectors\xml_vivantis_parfemy;


class Parser
{
    private $buffer=array();

    private $regExpCat=array(
        "man_basic"=>90188,
        "man_/hrdel/i"=>90195,
        "man_/etíz/i"=>90195,
        "man_/ívěs/i"=>90195,
        "man_/anžet/i"=>90190,
        "man_/árame/i"=>90195,
        "man_/Spona/i"=>90192,
        "man_/ánský set/i"=>90194,
        "man_/Gentleman set/i"=>90194,

        "woman_basic"=>90189,
        "woman_/nice/i"=>90180,
        "woman_/ničky/i"=>90180,
        "woman_/hrdel/i"=>90181,
        "woman_/etíz/i"=>90186,
        "woman_/ívěs/i"=>90182,
        "woman_/iercing/i"=>90191,
        "woman_/rsten/i"=>90184,
        "woman_/árame/i"=>90183,
        "woman_/áramk/i"=>90183,

        "unisex_base"=>90196,
        "unisex_/hrdel/i"=>90197,
        "unisex_/etíz/i"=>90198,
        "unisex_/ívěs/i"=>90198,
        "unisex_/rste/i"=>90199,
        "unisex_/iercing/i"=>90200,
        "unisex_/árame/i"=>902001,
        "unisex_/áramk/i"=>902001,
    );

    private function fillBuffer($stackName,$data){
        if(array_key_exists($stackName,$this->buffer)){
            array_push($this->buffer[$stackName],$data);
        }
        else{
            $this->buffer[$stackName]=array();
            array_push($this->buffer[$stackName],$data);
        }
    }

    private function getBufferStack($stackName){
        if(array_key_exists($stackName,$this->buffer)){
            return $this->buffer[$stackName];
        }
        return false;
    }

    private function flushBuffer($stackName=false){
        if($stackName){
            unset($this->buffer[$stackName]);
        }else{
            $this->buffer=array();
        }
    }

    private function regExpProductSearch($type,$productName){
        $ids=array();
        $into_lists=array();
        foreach ($this->regExpCat as $categoryMarker => $categoryId){
            $categoryMarker=str_replace($type."_","",$categoryMarker);
            //var_dump($categoryMarker); die();
            if(@preg_match($categoryMarker, $productName)){
                $into_lists[$categoryId]=1;
            }
        }
        foreach ($ids as $id) {
            $into_lists[] = array('list_name' => "categories", "id_in_list" => $id);
        }
        return $into_lists;

    }

    private function searchInStaticData($product)
    {
        $this->flushBuffer();
        $gender = strtolower($product['product_gender']);
        $productName = $product['product_name'];
        $into_lists = $this->regExpProductSearch($gender,$productName);
        return $into_lists;
    }





    /*
     * Main function
     * @params
     *      \SimpleXMLElement $xml
     *
     * @return type \stdClass
     */
    public function readXML($xml)
    {
        $data=new \stdClass();
        if(isset($xml->lists->categories)){
            $categories=(array) $xml->lists->categories;
            $data->categories=$this->readCategories($categories);
        }

        if(isset($xml->lists->collections)){
            $collections=(array) $xml->lists->collections;
            $data->collections=$this->readCollections($collections['item']);
            $this->fillBuffer("collections",$data->collections);
        }


        if(isset($xml->products)){
            $products = (array) $xml->products;
            $data->products=$this->readProducts($products);
        }
        $this->flushBuffer();
        return $data;
    }







    private function readCategories($xml_categories){
        $categories = array();
        $counter = 0;
        foreach ($xml_categories->item as $category) {
            $category= (object) $category;
            $categories[$counter]['category_parent_id'] = intval($category->parent);
            $categories[$counter]['category_id'] = intval($category->id);
            $categories[$counter]['category_name_cze'] = strval($category->name);
            $counter++;

        }
        return $categories;
    }

    private function readCollections($xml_collections){
        $collections = array();
        $counter = 0;
        foreach ($xml_collections as $collection) {
            $collection= (object) $collection;
            $collections[$counter]['parent_id'] = intval($collection->parent);
            $collections[$counter]['id'] = intval($collection->id);
            $collections[$counter]['name_cze'] = strval($collection->name);
            $counter++;

        }
        return $collections;
    }


    private function readProducts($xml_products){
        $products = array();
        $prodCounter = 0;
        $collections=$this->getBufferStack("collections");
        foreach ((array) $xml_products['product'] as $prod_counter => $product) {
            //var_dump($product); die();
            if(isset($product->parameters)){
                $products[$prodCounter]['product_parameters'] = $this->readProductParams((array)$product->parameters);
            }
            else{
                $products[$prodCounter]['product_parameters'] = false;
            }
            if(isset($product->images)){
                $products[$prodCounter]['product_images'] = $this->readProductMedia((array)$product->images);
            }
            else{
                $products[$prodCounter]['product_images'] = false;
            }

            $products[$prodCounter]['product_prices_czk'] = $this->readProductPricesCZK((array)$product->prices);

            /*
             * TODO: refactor and repair
             */
            @$into_lists = $this->readProductIntoListsData((array)$product->lists,$product);
            // manually into category "Šperky"?
            $into_lists[] = array('list_name' => "categories", "id_in_list" => 90179);
            $products[$prodCounter]['into_lists'] = $into_lists;

            $products[$prodCounter]['product_id'] = intval($product->id);
            $products[$prodCounter]['product_code'] = strval($product->code);
            $products[$prodCounter]['product_supplierId'] = intval($product->supplierId);
            $products[$prodCounter]['product_name'] = strval($product->name);
            $products[$prodCounter]['product_gender'] = strval($product->gender);
            $products[$prodCounter]['product_manufacturer'] = strval($product->manufacturer);
            $products[$prodCounter]['product_description'] = htmlspecialchars(strval($product->description));
            $products[$prodCounter]['product_vat'] = intval($product->vat);
            $products[$prodCounter]['product_url'] = strval($product->url);
            $products[$prodCounter]['product_availability'] = intval($product->availability);
            $products[$prodCounter]['product_inStock'] = intval($product->inStock);
            $products[$prodCounter]['product_delivery_from'] = intval($product->deliveryDate->from);
            $products[$prodCounter]['product_delivery_to'] = intval($product->deliveryDate->to);
            $products[$prodCounter]['product_ean'] = strval($product->ean);

            if (is_array($product->notes)) {
                $products[$prodCounter]['product_notes'] = implode("||", $product->notes);
            }
            if (is_array($product->flags)) {
                $products[$prodCounter]['product_flags'] = implode("||", $product->flags);
            }
//var_dump($product->lists[0]); die();

            if(isset($product->lists) && is_array($product->lists) && ((int)$product->lists[0]>0)){
                $counter2=0;
                foreach ((array) $product->lists as $prod_list_key => $prod_list_item) {
                    if ($prod_list_item["list"]->name == "collections") {
                        $collection_param = array();
                        $collection_param['name'] = "Kolekce " . ucfirst($collections[intval($prod_list_item["list"]->id)]['name_cze']);
                        $collection_param['value'] = 1;
                        $products[$prodCounter]['product_parameters'][] = $collection_param;
                    }
                    $counter2++;
                }
            }


            $prodCounter++;
        }
        return $products;
    }

    private function readProductIntoListsData($intoListData,$product){
        $into_lists=array();
        $counter2 = 0;
        // set ids from XML
        //var_dump($intoListData); die();
        if(is_array($intoListData)) {
            foreach ($intoListData as $prod_list_key => $prod_list_item) {
                $param = array();
                $param['list_name'] = strval($prod_list_item->name);
                $param['id_in_list'] = intval($prod_list_item->id);
                $into_lists[$counter2] = $param;

                $counter2++;
            }
        }
        // set category ids by product name regexp
        $listRecords = $this->searchInStaticData($product);
        if (is_array($listRecords)) {
            foreach ($listRecords as $listRecord) {
                array_push($into_lists, $listRecord);
            }
        }
        return $into_lists;

    }


    private function readProductMedia($media){
        $prod_images = array();
        if(is_array($media)) {
            foreach ($media as $mediaType => $prodImage) {
                if(is_array($prodImage)){
                    foreach ($prodImage as $key => $img){
                        $prod_images[$mediaType."|".$key] = str_replace("s_v3", "v", strval($img));
                    }
                }
                else{
                    $prod_images[$mediaType] = str_replace("s_v3", "v", strval($prodImage));
                }
            }
        }
        return $prod_images;
    }

    private function readProductParams($params){
        $prod_params = array();
        $counter = 0;
        if(is_array($params["parameter"])){
            foreach ($params["parameter"] as $prod_param) {
                $param = array();
                $param['name'] = ucfirst(strval($prod_param->name));
                $param['value'] = ucfirst(strval($prod_param->value));
                $prod_params[$counter] = $param;
                $counter++;
            }
        }
        return $prod_params;
    }

    private function readProductPricesCZK($prices){
        $prod_prices = array();
        if(isset($prices["CZK"])){
            $prod_prices['wholesalePrice_withoutVat'] = floatval($prices["CZK"]->wholesalePrice->withoutVat);
            $prod_prices['wholesalePrice_withVat'] = floatval($prices["CZK"]->wholesalePrice->withVat);
            $prod_prices['retailPrice_withoutVat'] = floatval($prices["CZK"]->retailPrice->withoutVat);
            $prod_prices['retailPrice_withVat'] = floatval($prices["CZK"]->retailPrice->withVat);
        }
        return $prod_prices;
    }

}