<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15.11.2017
 * Time: 20:48
 */

namespace vmprim\src;


class Vmprim
{
    public $database_prefix;
    public $import_source;

    public function __construct($dbPrefix, $sourceString = "")
    {
        $this->database_prefix = $dbPrefix;
        $this->import_source = $sourceString;
    }


}