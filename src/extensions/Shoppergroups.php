<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15.11.2017
 * Time: 21:31
 */

namespace vmprim\src\extensions;

use vmprim\src\Vmprim;

class Shoppergroups extends Vmprim
{
    public $virtuemart_product_id;
    public $virtuemart_shoppergroup_id;

    public function __construct($dbPrefix, $sourceString = "")
    {
        parent::__construct($dbPrefix, $sourceString);
    }

}