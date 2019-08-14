<?php

class Levementum_Groupedproduct_Model_System_Config_Source_Attributes
{
    protected $_options;

    public function toOptionArray($currentOptions = array())
    {
        if (!$this->_options) {
            if (!$currentOptions || is_bool($currentOptions)) {
                $currentOptions = Mage::getStoreConfig('levementum_grouped/groupedproduct/displayed_attributes');
            }

            if (!is_array($currentOptions)) {
                $currentOptions = explode(',', $currentOptions);
            }

            $currentOptions = array_flip($currentOptions);

            /** @var $_attributes Mage_Eav_Model_Resource_Entity_Attribute_Collection */
            $_attributes = Mage::getSingleton('eav/config')->getEntityType(Mage_Catalog_Model_Product::ENTITY)->getAttributeCollection();

            /** @var $attribute Mage_Eav_Model_Entity_Attribute */
            $this->_options = array();
            foreach ($_attributes as $attribute) {
                $tmpArray = array(
                    'value' => $attribute->getAttributeCode(),
                    'label' => $attribute->getStoreLabel(),
                );

                if (isset($currentOptions[$attribute->getAttributeCode()])) {
                    $currentOptions[$attribute->getAttributeCode()] = $tmpArray;
                } else {
                    $this->_options[] = $tmpArray;
                }
            }

            foreach ($currentOptions as $tmpArray) {
                $this->_options[] = $tmpArray;
            }
        }

        return $this->_options;
    }
}
