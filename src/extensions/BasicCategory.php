<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 20.11.2017
 * Time: 18:31
 */

namespace vmprim\src\extensions;


class BasicCategory
{
    public $virtuemart_category_id = null;
    public $virtuemart_vendor_id = 1;
    public $category_template = 0;
    public $category_layout = 0;
    public $category_product_layout = 0;
    public $products_per_row = 4;
    public $limit_per_step = 0;
    public $limit_list_initial = 0;
    public $hits = 0;
    public $metarobot = "";
    public $metaauthor = "";
    public $ordering = 0;
    public $shared = 0;
    public $published = 1;
    public $created_on;

    public function __construct()
    {
        $this->created_on = new \DateTime();
        $this->virtuemart_category_id = null;
    }

    public function getArray()
    {
        return [
            'virtuemart_category_id' => $this->virtuemart_category_id,
            'virtuemart_vendor_id' => $this->virtuemart_vendor_id,
            'category_template' => $this->category_template,
            'category_layout' => $this->category_layout,
            'category_product_layout' => $this->category_product_layout,
            'products_per_row' => $this->products_per_row,
            'limit_per_step' => $this->limit_per_step,
            'limit_list_initial' => $this->limit_list_initial,
            'hits' => $this->hits,
            'metarobot' => $this->metarobot,
            'metaauthor' => $this->metaauthor,
            'ordering' => $this->ordering,
            'shared' => $this->shared,
            'published' => $this->published,
            'created_on' => $this->created_on
        ];
    }

}