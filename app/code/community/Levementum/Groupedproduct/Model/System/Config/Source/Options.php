<?php
/**
 * Used in creating options for All|Specified config value selection
 *
 */
class Levementum_Groupedproduct_Model_System_Config_Source_Options
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        /** @var $collection Levementum_Groupedproduct_Model_Resource_Warehouses_Collection */
        $collection =  Mage::getModel('catalog/product_option')->getCollection()->getOptions(Mage::app()->getStore()->getStoreId());

        $options = array();
        $options[] = array(
            'value' => '',
            'label' => ''
        );
        foreach ($collection as $item) {
            $options[$item->getTitle()] = array(
                'value' => $item->getTitle(),
                'label' => $item->getTitle()
            );
        }


        return $options;
    }

}
