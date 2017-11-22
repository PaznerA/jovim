<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15.11.2017
 * Time: 20:55
 */

namespace vmprim\src\extensions;

class ProductCustomfield
{
    public $virtuemart_customfield_id=null;
    public $virtuemart_product_id=null;
    public $virtuemart_custom_id=null;
    public $customfield_value;
    public $customfield_price=null;
    public $disabler=0;
    public $override=0;
    public $customfield_params;
    public $product_sku=null;
    public $product_gtin=null;
    public $product_mpn=null;
    public $published=0;
    public $created_on;
    public $created_by=0;
    public $modified_on;
    public $modified_by;
    public $locked_on="0000-00-00 00:00:00";
    public $locked_by=0;
    public $ordering=0;

    public function __construct()
    {
        $this->virtuemart_customfield_id=null;
        $this->virtuemart_product_id=null;
        $this->virtuemart_custom_id=null;
        $this->created_on=new \DateTime();
        $this->modified_on=new \DateTime();
    }


}