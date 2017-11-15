<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15.11.2017
 * Time: 21:29
 */

namespace vmprim\src\extensions;

use vmprim\src\Vmprim;

class Prices extends Vmprim
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

    public function __construct($dbPrefix, $sourceString = "")
    {
        parent::__construct($dbPrefix, $sourceString);
    }
}