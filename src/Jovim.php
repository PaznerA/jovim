<?php

namespace vmprim\src;

use dibi;

class Jovim
{
    private $db;
    public $dbPrefix;
    public $import_source;

    public function __construct($dbSettings, $sourceString = "")
    {
        $this->db=new dibi\Connection($dbSettings);
        $this->dbPrefix = $dbSettings['prefix'];
    }


}