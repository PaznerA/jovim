<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15.11.2017
 * Time: 20:55
 */

namespace vmprim\src\extensions;

use vmprim\src\Vmprim;

class Customfields extends Vmprim
{
    public $virtuemart_product_id;
    public $virtuemart_custom_id;
    public $customfield_value;
    public $customfield_price;
    public $disabler;
    public $override;
    public $customfield_params;
    public $product_sku;
    public $product_gtin;
    public $product_mpn;
    public $published;
    public $created_on;
    public $created_by;
    public $modified_on;
    public $modified_by;
    public $locked_on;
    public $locked_by;
    public $ordering;

    public function __construct($dbPrefix, $sourceString = "")
    {
        parent::__construct($dbPrefix, $sourceString);
    }

}