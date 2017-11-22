<?php

namespace vmprim\src\connectors;

use dibi;
use vmprim\src\extensions\BasicCategory;
use vmprim\src\Product;

class DataWriter
{
    private $db_connection;
    private $db;

    public function __construct($db_connection)
    {
        $this->db_connection=$db_connection;
        $this->db=new dibi\Connection($db_connection);
    }

    /**
     * @param BasicCategory $category
     */
    public function CreateUpdateCategory($category)
    {
        var_dump($category); die();
        $this->db->query('INSERT INTO '.$this->db_connection['prefix'].'virtuemart_categories', [
            'id' => $category->id,
            'name' => $category->name,
            'year' => $category->year,
        ], 'ON DUPLICATE KEY UPDATE', [
            'name' => $category->name,
            'year' => $category->year,
        ]);

        var_dump($this->db->insertId);
        die();
    }

    /**
     * @param string $column
     * @param Product $product
     * @param string $lang_code
     * @return bool
     */
    public function isProductUniqueBy($column,$product,$lang_code="cs_cz")
    {
        $prodFileds=[
            "virtuemart_product_id",
            "product_sku",
            "product_gtin",
            "product_mpn",
            ];
        $prodLangFileds=[
            "virtuemart_product_id",
            "product_s_desc",
            "product_desc",
            "product_name",
            "metadesc",
            "metakey",
            "customtitle",
            "slug"
        ];
        if(array_key_exists($column,$prodFileds)){
            $result=$this->db->query('SELECT id FROM '.$this->db_connection['prefix'].'virtuemart_products WHERE virtuemart_products_?=?',$column,$product->$column);
        }
        elseif(array_key_exists($column,$prodLangFileds)){
            $result=$this->db->query('SELECT id FROM '.$this->db_connection['prefix'].'virtuemart_products WHERE virtuemart_products_'.$lang_code.' ?=?',$column,$product->$column);
        }
        else{
            error_log("Unknown collumn name ".$column,E_USER_ERROR);
            return false;
        }
        $row_count=$result->getRowCount();
        if($result->getRowCount()>0){
            return false;
        }
        else{
            return true;
        }

    }

    /**
     * @param Product $product
     */
    public function CreateUpdateProduct($product)
    {
        $this->db->query('INSERT INTO '.$this->db_connection['prefix'].'virtuemart_products', [
            'id' => $product->id,
            'name' => $product->name,
            'year' => $product->year,
        ], 'ON DUPLICATE KEY UPDATE', [
            'name' => $product->name,
            'year' => $product->year,
        ]);
    }



}