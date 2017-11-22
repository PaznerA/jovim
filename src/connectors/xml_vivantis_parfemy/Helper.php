<?php
namespace vmprim\src\connectors\xml_vivantis_parfemy\helper;


class CategoryHelper
{
    static function getNewCategoriesQuery(){
        $q = "INSERT INTO ".db_prefix."virtuemart_category_categories (category_parent_id, category_child_id) VALUES(0,1)";
        $q.= "INSERT INTO ".db_prefix."virtuemart_category_categories (category_parent_id, category_child_id) VALUES(1,11)";
        $q.= "INSERT INTO ".db_prefix."virtuemart_category_categories (category_parent_id, category_child_id) VALUES(1,12)";
        $q.= "INSERT INTO ".db_prefix."virtuemart_category_categories (category_parent_id, category_child_id) VALUES(1,87570)";
        $q.= "INSERT INTO ".db_prefix."virtuemart_category_categories (category_parent_id, category_child_id) VALUES(1,87571)";
        $q.= "INSERT INTO ".db_prefix."virtuemart_category_categories (category_parent_id, category_child_id) VALUES(1,87572)";
        $q.= "INSERT INTO ".db_prefix."virtuemart_category_categories (category_parent_id, category_child_id) VALUES(1,87573)";
        return $q;
    }

    static function getDefaultCategoryId(){
        return 12;
    }



}