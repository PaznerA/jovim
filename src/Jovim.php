<?php

namespace vmprim\src;

use dibi;

class Jovim
{
    private $db;

    public function __construct($dbSettings, $sourceString = "")
    {
        $this->db=new dibi\Connection($dbSettings);
    }


}