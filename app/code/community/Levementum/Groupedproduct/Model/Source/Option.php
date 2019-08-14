<?php
/**
 * User: ian.c
 * Date: 5/15/12 12:46 PM
 * File: Option.php
 */

if (!function_exists('value_sort')) {
    function value_sort($a, $b)
    {
        $a = $a['sorted_value'];
        $b = $b['sorted_value'];
        if ($a == $b) {
            return 0;
        }

        return ($a < $b) ? -1 : 1;
    }
}

class Levementum_Groupedproduct_Model_Source_Option extends Mage_Eav_Model_Entity_Attribute_Source_Table
{
    public function getAllOptions()
    {
        return $this->getOptionFromTable();
    }

    private function getOptionFromTable()
    {
        $sorted_value = 1;

        /* Change ian.c on 10/18/12 at 3:27 PM - Description: If no product is defined we are in a process other then import/export.  Reverse the result. */
        if (!Mage::registry('current_product') && !Mage::registry('product')) {
            $attributes = Mage::getSingleton('eav/config')->getEntityType(Mage_Catalog_Model_Product::ENTITY)->getAttributeCollection();

            $_options = array();
            foreach ($attributes as $attribute) {
                if (!$attribute->getStoreLabel()) {
                    continue;
                }

                $_options[] = array(
                    'label' => $attribute->getStoreLabel(),
                    'value' => $attribute->getAttributeCode()
                );
            }

            return $_options;
        }

        /** @var $product Mage_Catalog_Model_Product */
        $product             = Mage::registry('current_product');
        $attributeCodesInSet = $this->getAttributeCodesinSet($product->getAttributeSetId());

        $data = $product->getData('lev_displayed_attributes');
        if (gettype($data) == 'string') {
            $data = explode(',', $data);
        }
//        echo '<pre>',print_r($data,true),'</pre>';

        $attributes = Mage::helper('groupedproduct/data')->getAdditionalData();

        if (!empty($data)) {
            //this prioritizes the order of the data, not the attribute list.
            foreach ($data as $datum) {
                foreach ($attributes as $key => $attribute) {
                    if ($attribute['value'] == $datum) {
                        $attributes[$key]['sorted_value'] = $sorted_value++;
                    }
                }
            }

            uasort($attributes, 'value_sort');
        }

//        echo '<pre>',print_r($attributes,true),'</pre>';
//        die('File: '.__FILE__.' on Line: '.__LINE__);

        return array_intersect_key($attributes, $attributeCodesInSet);
    }

    public function getUnprocessedOptions()
    {
        return parent::getAllOptions();
    }

    public function getAttributeCodesinSet($setid)
    {

        $attributes = Mage::getModel('catalog/product')->getResource()
            ->loadAllAttributes()
            ->getSortedAttributes($setid);
        $result     = array();

        foreach ($attributes as $attribute) {
            if ($attribute->getId()) {
                $result[$attribute->getAttributeCode()] = true;
            }
        }

        return $result;
    }
}