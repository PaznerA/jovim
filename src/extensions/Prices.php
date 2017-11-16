<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15.11.2017
 * Time: 21:29
 */

namespace vmprim\src\extensions;

use vmprim\src\Vmprim;

class Prices
{
    public $virtuemart_product_id;
    public $virtuemart_shoppergroup_id=0;
    public $product_price=0;
    public $override=0;
    public $product_override_price=0;
    public $product_tax_id=0;
    public $product_discount_id=0;
    public $product_currency;
    public $product_price_publish_up="0000-00-00 00:00:00";
    public $product_price_publish_down="0000-00-00 00:00:00";
    public $price_quantity_start=0;
    public $price_quantity_end=0;
    public $created_on;
    public $created_by;
    public $modified_on;
    public $modified_by;
    public $locked_on;
    public $locked_by;

    public function __construct($data)
    {
        $this->virtuemart_product_id        =$data->virtuemart_product_id;
        $this->virtuemart_shoppergroup_id   =$data->virtuemart_shoppergroup_id;
        $this->product_price                =$data->product_price;
        $this->override                     =$data->override;
        $this->product_override_price       =$data->product_override_price;
        $this->product_tax_id               =$data->product_tax_id;
        $this->product_discount_id          =$data->product_discount_id;
        $this->product_currency             =$data->product_currency;
        $this->product_price_publish_up     =$data->product_price_publish_up;
        $this->product_price_publish_down   =$data->product_price_publish_down;
        $this->price_quantity_start         =$data->price_quantity_start;
        $this->price_quantity_end           =$data->price_quantity_end;
        $this->created_on                   =$data->created_on;
        $this->created_by                   =$data->created_by;
        $this->modified_on                  =$data->modified_on;
        $this->modified_by                  =$data->modified_by;
        $this->locked_on                    =$data->locked_on;
        $this->locked_by                    =$data->locked_by;
    }

}