<?php

namespace vmprim\src\extensions\external;


class VivantisPriceHistory
{

    private $dbSchema;

    public function __construct($dbSchema=false)
    {
        $this->dbSchema=new \stdClass();
        $this->dbSchema->tables=[];

        $logRowColumns=[
            "vm_product_id",
            "vivantis_product_id",
            "created_at",
            "wholesale_price_without_tax",
            "wholesale_price_with_tax",
            "retail_price_without_tax",
            "retail_price_with_tax"];
        $this->dbSchema->tables["vivantis_prices"]=$logRowColumns;

    }

    public function prepareInsertQueries($data=[])
    {
        $data = (array)$data;
        $queries=[];
        foreach ($data as $tableName => $tableData){
            $queries[]='INSERT INTO 
                '.db_prefix.$tableName.'('.implode(",",$this->dbSchema->tables[$tableName]).') 
                VALUES ('.implode(",",$tableData).')';
        }
        $data = (array)$data;
        return $queries;
    }

}