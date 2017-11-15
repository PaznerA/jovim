<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15.11.2017
 * Time: 21:27
 */

namespace vmprim\src\extensions;

use vmprim\src\Vmprim;

class Media extends Vmprim
{
    public $virtuemart_product_id;
    public $virtuemart_media_id;
    public $ordering;
    public function __construct($dbPrefix, $sourceString = "")
    {
        parent::__construct($dbPrefix, $sourceString);
    }

}